<?php get_header(); 

$product_cat = get_queried_object();

$breadcrumbs = '<li class="breadcrumbs__list__item"><a  class="breadcrumbs__list__item__link">'.$product_cat->name.'</a></li>';
if($product_cat->parent > 0){
    $parent_product_cat = get_term_by( 'id', $product_cat->parent, 'product_cat' );
    $breadcrumbs = '<li class="breadcrumbs__list__item"><a href="/?product_cat='.$parent_product_cat->slug.'" class="breadcrumbs__list__item__link">'.$parent_product_cat->name.'</a></li>' . $breadcrumbs;
    if($parent_product_cat->parent > 0){
        $parent_product_cat = get_term_by( 'id', $parent_product_cat->parent, 'product_cat' );
        $breadcrumbs = '<li class="breadcrumbs__list__item"><a href="/?product_cat='.$parent_product_cat->slug.'" class="breadcrumbs__list__item__link">'.$parent_product_cat->name.'</a></li>' . $breadcrumbs;
        
    }
}
$breadcrumbs = '<li class="breadcrumbs__list__item"><a href="/" class="breadcrumbs__list__item__link">Головна</a></li>'. $breadcrumbs;


$sort_array = [
    'menu_order' => 'Замовчанню',
    'popularity' => 'Популярності',
    'rating' => 'Рейтингу',
    'date' => 'Даті',
    'price' => 'Ціні: зростанню',
    'price-desc' => 'Ціні: спаданню',
];

$posts_per_page = 25;
$loop = new WP_Query( array(
    // 'post_type' => 'product',  // указываем, что выводить нужно именно товары
    'posts_per_page' => $posts_per_page, // количество товаров для отображения
    'orderby' => get_query_var('orderby'), // тип сортировки (в данном случае по дате)
    'product_cat' => $product_cat->slug, // указываем слаг нужной категории
    ));

echo '<pre>';
// var_dump($loop);
echo '</pre>';

?>











<!-- Main content -->
<main class="main-content">

<!-- Breadcrumbs  -->
<div class="breadcrumbs">
    <div class="custom-container">
        <div class="breadcrumbs--wrapper">
            <a href="#" class="breadcrumbs__home svg" title="Home">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11">
                    <path fill="#393A45" fill-opacity=".96" fill-rule="evenodd"
                          d="M10.8 6.433V11H1.2V6.433H0L6 0l6 6.433z"/>
                </svg>
            </a>
            <ul class="breadcrumbs__list">
                <?= $breadcrumbs ?>
            </ul>
        </div>
    </div>
</div>

<div class="products-section">
    <div class="custom-container">
        <div class="products-section__head">
            <h2 class="products-section__head__title"><?= $product_cat->name?></h2>
            <div class="products-section__head__controls">

                <div class="products-section__head__controls__sort">
                    <form class="woocommerce-ordering" method="get">
                            <span>Сортувати за:</span>
                            <select name="orderby" class="orderby" id="sortBy">
                                <?php foreach($sort_array as $key=> $val): ?>
                                    <option value="<?php echo $key ?>"><?php echo  $val ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="paged" value="1">
                        <input type="hidden" name="product_cat" value="<?php echo  $product_cat->slug ?>">
                        <input type="submit">
                    </form>
                </div>
                        
                <div class="products-section__head__controls__sort">
                    <span>Показати по:</span>
                    <select name="sort_by" id="showBy">
                        <option>25 од.товару</option>
                        <option selected="selected">50 од.товару</option>
                        <option>75 од.товару</option>
                        <option>100 од.товару</option>
                    </select>
                </div>



            </div>
        </div>
        <div class="products-section__body">

            <!-- NEW: Filter Button toggle -->
            <button class="products-section__body__mobile-filter-button">фільтри</button>

            <!-- Filter wrapper-->
            <div class="products-section__body__filter">
                <div class="products-filter">

                    <!-- Chips section -->
                    <div class="products-filter__item">
                        <div class="chips">
                            <div class="chips__item">
                                <span class="chips__item__content">
                                    <span class="chips__item__content__close"></span>
                                    GStream
                                </span>
                            </div>

                            <div class="chips__item">
                                <span class="chips__item__content">
                                    <span class="chips__item__content__close"></span>
                                    Човнове
                                </span>
                            </div>

                            <div class="chips__item">
                                <span class="chips__item__content">
                                    <span class="chips__item__content__close"></span>
                                    EVA
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Checkboxes filter section  -->
                    <div class="products-filter__item">
                        <div class="products-filter__item__title">Виробник</div>

                        <div class="checkboxes">
                            <div class="checkboxes__item">
                                <label class="checkboxes__item__content">
                                    <input type="checkbox" class="hidden" checked>
                                    <span class="checkboxes__item__content__checkbox"></span>
                                    <span class="checkboxes__item__content__text">GStream</span>
                                    <span class="checkboxes__item__content__quantity">(154)</span>
                                </label>
                            </div>

                            <div class="checkboxes__item">
                                <label class="checkboxes__item__content">
                                    <input type="checkbox" class="hidden">
                                    <span class="checkboxes__item__content__checkbox"></span>
                                    <span class="checkboxes__item__content__text">Carp-Pro</span>
                                    <span class="checkboxes__item__content__quantity">(64)</span>
                                </label>
                            </div>

                            <div class="checkboxes__item">
                                <label class="checkboxes__item__content">
                                    <input type="checkbox" class="hidden">
                                    <span class="checkboxes__item__content__checkbox"></span>
                                    <span class="checkboxes__item__content__text">Daiwa</span>
                                    <span class="checkboxes__item__content__quantity">(4)</span>
                                </label>
                            </div>

                            <div class="checkboxes__item">
                                <label class="checkboxes__item__content">
                                    <input type="checkbox" class="hidden">
                                    <span class="checkboxes__item__content__checkbox"></span>
                                    <span class="checkboxes__item__content__text">Drennan</span>
                                    <span class="checkboxes__item__content__quantity">(21)</span>
                                </label>
                            </div>

                            <div class="checkboxes__item">
                                <label class="checkboxes__item__content">
                                    <input type="checkbox" class="hidden">
                                    <span class="checkboxes__item__content__checkbox"></span>
                                    <span class="checkboxes__item__content__text">Browning</span>
                                    <span class="checkboxes__item__content__quantity">(13)</span>
                                </label>
                            </div>

                            <div class="checkboxes__item">
                                <label class="checkboxes__item__content">
                                    <input type="checkbox" class="hidden">
                                    <span class="checkboxes__item__content__checkbox"></span>
                                    <span class="checkboxes__item__content__text">Garbolino</span>
                                    <span class="checkboxes__item__content__quantity">(34)</span>
                                </label>
                            </div>

                            <div class="checkboxes__item">
                                <label class="checkboxes__item__content">
                                    <input type="checkbox" class="hidden">
                                    <span class="checkboxes__item__content__checkbox"></span>
                                    <span class="checkboxes__item__content__text">Korum</span>
                                    <span class="checkboxes__item__content__quantity">(11)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Range input section -->
                    <div class="products-filter__item">
                        <div class="products-filter__item__title">Ціна</div>
                        <div class="range-input">
                            <div class="range-input__slider" id="slider-range"></div>
                            <div class="range-input__values">
                                <div class="range-input__values__item">
                                    від
                                    <input type="text" id="min-amount" readonly>
                                    <span>₴</span>
                                </div>
                                <div class="range-input__values__item">
                                    до
                                    <input type="text" id="max-amount" readonly>
                                    <span>₴</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Checkboxes filter section  -->
                    <div class="products-filter__item">
                        <div class="products-filter__item__title">Виробник</div>

                        <div class="checkboxes">
                            <div class="checkboxes__item">
                                <label class="checkboxes__item__content">
                                    <input type="checkbox" class="hidden" checked>
                                    <span class="checkboxes__item__content__checkbox"></span>
                                    <span class="checkboxes__item__content__text">Човнове</span>
                                    <span class="checkboxes__item__content__quantity">(154)</span>
                                </label>
                            </div>

                            <div class="checkboxes__item">
                                <label class="checkboxes__item__content">
                                    <input type="checkbox" class="hidden">
                                    <span class="checkboxes__item__content__checkbox"></span>
                                    <span class="checkboxes__item__content__text">Телескопічний</span>
                                    <span class="checkboxes__item__content__quantity">(64)</span>
                                </label>
                            </div>

                            <div class="checkboxes__item">
                                <label class="checkboxes__item__content">
                                    <input type="checkbox" class="hidden">
                                    <span class="checkboxes__item__content__checkbox"></span>
                                    <span class="checkboxes__item__content__text">Фідерне</span>
                                    <span class="checkboxes__item__content__quantity">(4)</span>
                                </label>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            
            <!-- Products wrapper -->
            <div class="products-section__body__products">
                <div class="products-list">
                <?php if ( have_posts() ) : ?>
                    <?php while( have_posts() ) : the_post(); ?>

                        <div class="products-list__item">
                            <a href="<?php echo get_permalink(); ?>" class="products-list__item--wrapper">
                                <div class="products-list__item__image">
                                    <img srcset="
                                    <?php
                                        $thumb_id = get_post_thumbnail_id();
                                        $thumb_url = wp_get_attachment_image_src($thumb_id, 'thubnail-size', true);
                                        echo $thumb_url[0];
                                    ?>
                                    "
                                        alt="<?php the_title(); ?>"
                                        title="<?php the_title(); ?>">
                                </div>
                                <p class="products-list__item__description"><?php the_title(); ?></p>
                                <div class="products-list__item__footer">
                                    <div class="products-list__item__price"><?php echo $product->get_price(); ?> ₴</div>
                                    <button class="products-list__item__button">
                                        <span class="products-list__item__button__text">Купити</span>
                                    </button>
                                </div>
                            </a>
                        </div>

                    <?php endwhile; ?> 
                <?php else: ?>
                    <?php echo __( 'No products found' ); ?>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <nav class="theme-pagination">
    <div class="custom-container">
        <ul class="theme-pagination__list">
            <li class="theme-pagination__list__item theme-pagination__list__item--prev">
                <a href="#" class="theme-pagination__list__item__link"></a>
            </li>
            <li class="theme-pagination__list__item">
                <a href="#" class="theme-pagination__list__item__link">1</a>
            </li>
            <li class="theme-pagination__list__item">
                <a href="#" class="theme-pagination__list__item__link active">2</a>
            </li>
            <li class="theme-pagination__list__item">
                <a href="#" class="theme-pagination__list__item__link">3</a>
            </li>
            <li class="theme-pagination__list__item">
                <a href="#" class="theme-pagination__list__item__link">4</a>
            </li>
            <li class="theme-pagination__list__item">
                <a href="#" class="theme-pagination__list__item__link">5</a>
            </li>
            <li class="theme-pagination__list__item">
                <a href="#" class="theme-pagination__list__item__link">6</a>
            <li class="theme-pagination__list__item theme-pagination__list__item--next">
                <a href="#" class="theme-pagination__list__item__link"></a>
            </li>
        </ul>
    </div>
</nav> -->
<?php the_posts_pagination(); ?>

</main>

<?php get_footer(); ?>