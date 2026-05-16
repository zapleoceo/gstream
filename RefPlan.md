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

| Пріоритет | Задача | Ризик | Статус |
|-----------|--------|-------|--------|
| 🔴 Зараз | Хотфікс AUTO_INCREMENT на `actionscheduler_actions` | Низький | ✅ Виконано |
| 🔴 Зараз | Активувати SMTP-плагін | Низький | ✅ Виконано (⚠️ пароль потребує оновлення) |
| 🔴 Цього тижня | Оновити PHP 7.3 → 8.1+ | Середній | ⏳ Хостинг-панель |
| 🟠 Цього тижня | Запустити WooCommerce DB updater | Середній | ⏳ WP Admin → WooCommerce |
| 🟠 Цього тижня | Очистити сміття БД (revisions, spam) | Низький | ✅ Виконано |
| 🟡 Планово | Конвертація MyISAM → InnoDB | Середній (бекап) | ✅ Виконано (63 таблиці, 2026-05-16) |
| 🟡 Планово | Оптимізація зображень + WebP | Низький | ⏳ Підключити Imagify/ShortPixel |
| 🟡 Планово | Видалити неактивні/старі плагіни | Низький | ✅ Частково (старі папки _gmace, _smsfly, _1centerprise видалено) |

---

## ✅ Виконані роботи (2026-05-16)

### Код / git
- Видалено небезпечні файли: `testmail.php`, `fix-mysql-auth.php`, `php.ini`, `.user.ini`
- Видалено старі папки плагінів: `_gmace`, `_smsfly`, `_woocommerce-and-1centerprise-data-exchange`, `_OLD__...`
- Видалено мертвий код теми: `old_header.php`, `old_footer.php`, `test.php`
- Виправлено `wp-translitera`: `$value{0}` → `$value[0]` (PHP 8 сумісність)
- Виправлено дублювання handle у `wp_enqueue_script` + CSS через `wp_enqueue_style`
- Санітизація вводу: `$_GET['showby']`, `$_REQUEST['count']`, `$_REQUEST['product_id']`
- SQL-захист: `array_map('intval', $categories)` у price range і count queries
- Оновлено `.gitignore`

### БД
- `gs_actionscheduler_actions.action_id` — додано `AUTO_INCREMENT` (помилка `Duplicate entry '0'` усунена)
- Очищено: 3 362 ревізій, 1 745 спам-коментарів, 45 transients, 148 старих ActionScheduler логів
- Конвертовано **63 таблиці** з MyISAM → InnoDB

### WP Admin
- Активовано WP Mail SMTP, налаштовано SMTP (mail.adm.tools, TLS, 587)
- ⚠️ Пароль `zakaz@gstream.com.ua` — AUTH 535, потрібно оновити з хостинг-панелі

## ⏳ Залишилось

| Задача | Де виконати |
|--------|------------|
| Оновити SMTP-пароль | Хостинг `mail.adm.tools` → WP Admin → WP Mail SMTP |
| WooCommerce DB updater (3.6.5 → 8.6.4) | WP Admin → WooCommerce → Run updater |
| PHP 7.3 → 8.1+ | Хостинг-панель |
| Видалити старі теми: `gstream`, `twentytwenty` | WP Admin → Теми |
| Активувати Akismet | WP Admin → Плагіни |
| Оптимізація зображень + WebP | Imagify або ShortPixel |
