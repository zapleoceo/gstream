# Звіт код-рев'ю — gstream.com.ua

> Дата: 2026-05-16

---

## 🔴 1. КРИТИЧНІ ПОМИЛКИ — ХОТФІКС

### 1.1 ActionScheduler: `Duplicate entry '0' for key 'PRIMARY'`

**Причина:** колонка `action_id` у таблиці `gs_actionscheduler_actions` **не має `AUTO_INCREMENT`**. Через це кожен новий запис вставляється з `id = 0`, конфліктуючи з попереднім.

**Додаткова проблема:** всі таблиці — **MyISAM** замість **InnoDB**. MyISAM не підтримує транзакції — при збоях під час запису замовлень дані можуть корумпуватися.

**Хотфікс:**
```sql
ALTER TABLE gs_actionscheduler_actions
  MODIFY action_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 106425;
```

### 1.2 WooCommerce DB версія застаріла

WC плагін: **8.6.4**, але `woocommerce_db_version` у БД: **3.6.5** — міграції не запускались роками.  
Дія: WP Admin → WooCommerce → Run updater.

### 1.3 PHP 7.3 — EOL з грудня 2021

PHP 7.3 не отримує патчі безпеки з 2021 року. WooCommerce 8.x вимагає PHP 7.4+, рекомендує 8.1+.  
Дія: оновити до PHP 8.1 через хостинг-панель.

### 1.4 Немає активного SMTP-плагіну

`post-smtp` і `wp-mail-smtp` встановлені, але **жоден не активний** → листи клієнтам (підтвердження замовлень, скиди паролів) можуть не надсилатись.  
Дія: активувати один, налаштувати.

---

## 🟠 2. БАЗА ДАНИХ — ОЧИЩЕННЯ

| Тип сміття | Кількість |
|------------|-----------|
| Post revisions | 3 362 |
| Spam comments | 1 745 |
| Expired transients | 45 |
| Old ActionScheduler logs (>30 днів) | 148 |
| ActionScheduler complete/failed | 192 |

**SQL для очищення:**
```sql
DELETE FROM gs_posts WHERE post_status = 'inherit' AND post_type = 'revision';
DELETE FROM gs_postmeta WHERE post_id NOT IN (SELECT ID FROM gs_posts);
DELETE FROM gs_comments WHERE comment_approved = 'spam';
DELETE FROM gs_commentmeta WHERE comment_id NOT IN (SELECT comment_id FROM gs_comments);
DELETE FROM gs_options WHERE option_name LIKE '_transient_timeout_%' AND option_value < UNIX_TIMESTAMP();
DELETE FROM gs_actionscheduler_logs WHERE log_date_gmt < DATE_SUB(NOW(), INTERVAL 30 DAY);
DELETE FROM gs_actionscheduler_actions WHERE status IN ('complete','failed') AND scheduled_date_gmt < DATE_SUB(NOW(), INTERVAL 30 DAY);
```

**Конвертація MyISAM → InnoDB** (робити з бекапом, у неробочі години):
```sql
ALTER TABLE gs_posts ENGINE=InnoDB;
ALTER TABLE gs_postmeta ENGINE=InnoDB;
ALTER TABLE gs_woocommerce_order_items ENGINE=InnoDB;
ALTER TABLE gs_woocommerce_order_itemmeta ENGINE=InnoDB;
ALTER TABLE gs_options ENGINE=InnoDB;
ALTER TABLE gs_users ENGINE=InnoDB;
ALTER TABLE gs_usermeta ENGINE=InnoDB;
ALTER TABLE gs_actionscheduler_actions ENGINE=InnoDB;
```

---

## 🟡 3. ПЛАГІНИ — АУДИТ

### Активні — потребують уваги

| Плагін | Проблема |
|--------|---------|
| `autoptimize` + `wp-fastest-cache` | Два конкуруючі плагіни оптимізації — залишити **один** |
| `advanced-woo-search` | Індекс займає 16.85 MB (294к рядків) — оцінити чи використовується |

### Неактивні — видалити

| Плагін | Причина |
|--------|---------|
| `jetpack` | Не використовується |
| `google-sitemap-generator` | Дублює Rank Math |
| `woocommerce-admin` | Вбудований у WC |
| `shipping-nova-poshta-for-woocommerce` | Дублює `wc-ukr-shipping` |
| `woocommerce-attributes-menu-manager` | Не активний |
| `_OLD__woocommerce-and-1centerprise-data-exchange__OLD` | Стара папка |
| `_gmace`, `_smsfly` | Старі залишки |

### Неактивні — активувати або видалити

| Плагін | Дія |
|--------|-----|
| `akismet` | Активувати (захист від спаму — вже 1745 записів) |
| `seo-by-rank-math` | Вирішити: активувати або видалити разом з таблицями |
| `post-smtp` або `wp-mail-smtp` | Активувати один, налаштувати SMTP |

---

## 🟡 4. ТЕМИ

| Тема | Дія |
|------|-----|
| `gstream_v2` | Активна — залишити |
| `gstream` | Стара версія — **видалити** |
| `twentytwenty` | Дефолтна WP — **видалити** |

---

## 🟡 5. ЗОБРАЖЕННЯ

| Показник | Значення |
|----------|---------|
| Розмір uploads | **3.8 GB** |
| JPEG | 37 201 шт |
| PNG | 2 341 шт |
| WebP | лише **21 шт** |
| Найбільший файл | **45 MB** (karas-2.tif) |

**Дії:**
1. Видалити `karas-2.tif` (45 MB, формат не для веб)
2. Оптимізувати важкі файли (топ 10 — по 11–23 MB кожен)
3. Підключити WebP-конвертацію (плагін Imagify або ShortPixel)

---

## Пріоритетний план дій

| Пріоритет | Задача | Ризик |
|-----------|--------|-------|
| 🔴 Зараз | Хотфікс AUTO_INCREMENT на `actionscheduler_actions` | Низький |
| 🔴 Зараз | Активувати SMTP-плагін | Низький |
| 🔴 Цього тижня | Оновити PHP 7.3 → 8.1+ | Середній |
| 🟠 Цього тижня | Запустити WooCommerce DB updater | Середній |
| 🟠 Цього тижня | Очистити сміття БД (revisions, spam) | Низький |
| 🟡 Планово | Конвертація MyISAM → InnoDB | Середній (бекап) |
| 🟡 Планово | Оптимізація зображень + WebP | Низький |
| 🟡 Планово | Видалити неактивні/старі плагіни | Низький |
