<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

$attributes = '';
$attributes_min = '';
$i = 0;
foreach ($product->get_attributes() as $key => $value) {  
    if(substr($value['name'], 0,3) == 'pa_'){     
        $options = array();
        foreach ($value['options'] as $k => $val) {
            array_push($options, get_term($val)->name);
        }
        $attributes .= wc_attribute_label($value['name']).": ".implode(', ', $options).'<br>';
        if($i < 3){
          $attributes_min .= wc_attribute_label($value['name']).": ".implode(', ', $options).'<br>';
        }
    }else {
        $attributes .= $value['name'].": ".implode(', ', $value['options']).'<br>';
        if($i < 3){
          $attributes_min .= $value['name'].": ".implode(', ', $value['options']).'<br>';
        }
    }   
  $i++;
}


$terms = get_the_terms( $product->get_id(), 'product_tag' );
$images_terms = array();
if($terms):
    $i = 0;
    foreach ($terms as $term) : 
        $i++;
        $images = apply_filters( 'taxonomy-images-get-terms', '', array(
            'taxonomy' => 'product_tag',
            'term_args' => array('slug' => $term->slug)
            ));
        foreach( (array) $images as $image) :
            array_push($images_terms, array('term'=>$term,'img'=>wp_get_attachment_url( $image->image_id)));
        endforeach;
        if($i>=5):
            break;
        endif;
    endforeach;
endif;

?>


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
                <?= breadcrumbs(wp_get_post_terms( $product->get_id(), 'product_cat')[0]->term_id, 'product') ?>
            </ul>
        </div>
    </div>
</div>

<!-- Product Card -->
<div class="product-card">
    <div class="custom-container">
        <div class="product-card__head">
            <h2 class="product-card__head__title"><?= $product->name ?></h2>
            <?php if($product->sku): ?>
            <p class="product-card__head__sub-title">Код товару: <?= $product->sku ?></p>
            <?php endif; ?>
            <div class="product-card__head__controls">

            </div>
        </div>
        <div class="product-card__body">
            <div class="nav nav-tabs product-card__body__tabs" id="nav-tab" role="tablist">

                <!-- Все о товаре -->
                <a class="nav-item nav-link active" id="nav-about-product-tab" data-toggle="tab" href="#nav-about-product" role="tab" aria-controls="nav-about-product" aria-selected="true">
                    Все про товар
                </a>

                <!-- Характеристики -->
                        <a class="nav-item nav-link"
                           id="nav-specifications-tab"
                           data-toggle="tab"
                           href="#nav-specifications"
                           role="tab"
                           aria-controls="nav-specifications"
                           aria-selected="false"
                        >
                            Характеристики та Опис
                        </a>

                        <!-- Описание -->
                       <!--  <a class="nav-item nav-link"
                           id="nav-description-tab"
                           data-toggle="tab"
                           href="#nav-description"
                           role="tab"
                           aria-controls="nav-description"
                           aria-selected="false"
                        >
                            Описание
                        </a> -->

                        <!-- Отзывы -->
                       <!--  <a class="nav-item nav-link"
                           id="nav-review-tab"
                           data-toggle="tab"
                           href="#nav-review"
                           role="tab"
                           aria-controls="nav-review"
                           aria-selected="false"
                        >
                            Отзывы
                        </a> -->

                    </div>
                    <div class="tab-content product-card__body__content">

                        <!-- Все о товаре -->
                        <div class="product-card__body__content__item tab-pane fade show active"
                        id="nav-about-product"
                        role="tabpanel"
                        aria-labelledby="nav-about-product-tab"
                        >
                        <div class="product-card__body__content__about-product">

                            <!--Slider Block -->
                            <div class="product-card__body__content__about-product__slider">
                                <div class="product-card-slider">
                                    <div class="product_tag_block">
                                        <ul>
                                            <?php foreach($images_terms as $val): ?>
                                                <?php if($val['img']): ?>
                                                    <li class="product_tag_img">
                                                        <img src="<?= $val['img'] ?>" class="product_tag_img" title="<?= $val['term']->name ?>" data-slug="<?= $val['term']->slug ?>">
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <!-- Main slider -->
                                    <div class="product-card-slider__main">
                                        <?php if($product->image_id): ?>
                                            <img id="image_zoom" class="img_block_zoom" src="<?= wp_get_attachment_image_url($product->image_id, 'full')?>" data-zoom-image="<?= wp_get_attachment_image_url($product->image_id, 'full')?>">
                                            
                                            <div style="visibility: hidden;">
                                                <img width="324" height="324" src="<?= wp_get_attachment_image_url($product->image_id, 324)?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" srcset="<?= wp_get_attachment_image_url($product->image_id, 324)?> 324w, <?= wp_get_attachment_image_url($product->image_id, 150)?> 150w, <?= wp_get_attachment_image_url($product->image_id, 100)?> 100w" sizes="(max-width: 324px) 100vw, 324px">
                                            </div>
                                            
                                        <?php else: ?>
                                            <img class="img_block_zoom" src="<?= wp_get_attachment_image_url(5,'full') ?>" alt="">
                                        <?php endif;?>
                                    </div>

                                <!-- small slider (navigation )-->
                                <div id="gallery_zoom" class="product-card-slider__nav">
                                    <?php if($product->image_id): ?>
                                        <?php foreach(array_merge(array($product->image_id), $product->gallery_image_ids) as $val): ?>
                                            <div class="product-card-slider__nav__item">
                                                <div class="product-card-slider__nav__item--wrapper elevatezoom-gallery" data-image="<?= wp_get_attachment_image_url($val, 'midle')?>" data-zoom-image="<?= wp_get_attachment_image_url($val, 'full')?>" >
                                                    <img src="<?= wp_get_attachment_image_url($val, 'smoll')?>" width="100">   
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="product-card-slider__nav__item">
                                        <div class="product-card-slider__nav__item--wrapper">
                                            <img src="<?= wp_get_attachment_image_url(5,'smoll') ?>" alt="">
                                        </div>
                                    </div>
                                    <?php endif?>
                            </div>
                        </div>
                    </div>

                    <!-- Details Block -->
                    <div class="product-card__body__content__about-product__details">

                        <div class="product-card__body__content__about-product__details__item">

                            <!-- Product Price BOX-->
                            <div class="product-card__body__content__buy-box">

                                <?php if($product->stock_status == 'instock'): ?>
                                    <div class="product-card__body__content__buy-box__title product-card__body__content__buy-box__title--exist">Є в наявності</div>
                                    <div class="product-card__body__content__buy-box__price">
                                        <?= $product->get_price_html(); ?>
                                    </div>
                                    <div class="product-card__body__content__buy-box__controls">
                                        <button data-quantity="1" class="product-card__body__content__buy-box__controls__button button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="<?= $product->get_id() ?>" data-title='<?= esc_attr( $product->get_name() ) ?>' data-product_sku="<?= esc_attr( $product->get_sku() ) ?>" aria-label="Добавить &quot;<?= esc_attr( $product->get_name() ) ?>&quot; в корзину" rel="nofollow"
                                            >Купити зараз</button>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="product-card__body__content__buy-box__title product-">Нема в наявності</div>
                                    <div class="product-card__body__content__buy-box__price"></div>
                                    <div class="product-card__body__content__buy-box__controls"></div>
                                    </div>
                                <?php endif; ?>


                                <!-- Product specifications BOX-->
                                <div class="product-card__body__content__specifications-box">
                                    <div class="product-card__body__content__specifications-box__title">Основні характеристики</div>
                                    <div class="product-card__body__content__specifications-box__description">
                                        <?= $attributes_min ?>
                                    </div>
                                </div>

                            </div>

                            <div class="product-card__body__content__about-product__details__item">

                                <!-- Product Delivery way BOX-->
                                <div class="product-card__body__content__delivery-box">
                                    <div class="product-card__body__content__delivery-box__title">
                                        Способи доставки
                                        <div class="product-card__body__content__delivery-box__title__notice">i</div>
                                    </div>

                                    <div class="product-card__body__content__delivery-box__list">
                                        <div class="product-card__body__content__delivery-box__list__item">
                                            <img src="<?= get_template_directory_uri(); ?>/static/pc_del_1.png" alt=""
                                            class="product-card__body__content__delivery-box__list__item__image">
                                        </div>
                                        <div class="product-card__body__content__delivery-box__list__item">
                                            <img src="<?= get_template_directory_uri(); ?>/static/pc_del_2.png" alt=""
                                            class="product-card__body__content__delivery-box__list__item__image">
                                        </div>
                                        <!-- <div class="product-card__body__content__delivery-box__list__item">
                                            <img src="<?= get_template_directory_uri(); ?>/static/pc_del_3.png" alt=""
                                            class="product-card__body__content__delivery-box__list__item__image">
                                        </div> -->
                                        <div class="product-card__body__content__delivery-box__list__item">
                                            <img src="<?= get_template_directory_uri(); ?>/static/pc_del_4.png" alt=""
                                            class="product-card__body__content__delivery-box__list__item__image">
                                        </div>
                                        <div class="product-card__body__content__delivery-box__list__item">
                                            <img src="<?= get_template_directory_uri(); ?>/static/pc_del_5.png" alt=""
                                            class="product-card__body__content__delivery-box__list__item__image">
                                        </div>
                                    </div>
                                    <div class="product-card__body__content__delivery-box__notice">
                                        Вартість доставки визначається
                                        тарифами перевізника
                                        <div class="product-card__body__content__delivery-box__notice__icon svg">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="22" viewBox="0 0 25 22">
                                                <g fill="none" fill-rule="evenodd">
                                                    <path fill="#EF8812" d="M0 22L12.314 0l12.313 22z"/>
                                                    <g fill="#FFF">
                                                        <path d="M11.314 7h2l-.113 8h-1.767zM11.314 17h2v2h-2z"/>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Delivery way BOX-->
                                <div class="product-card__body__content__payment-methods-box">
                                    <div class="product-card__body__content__payment-methods-box__title">Способи оплати</div>
                                    <ul class="product-card__body__content__payment-methods-box__list">
                                        <li class="product-card__body__content__payment-methods-box__list__item">Готівковий</li>
                                        <li class="product-card__body__content__payment-methods-box__list__item">Безготівковий</li>
                                        <li class="product-card__body__content__payment-methods-box__list__item">Накладений платіж</li>
                                    </ul>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <!-- Характеристики -->
                        <div class="product-card__body__content__item tab-pane fade"
                             id="nav-specifications"
                             role="tabpanel"
                             aria-labelledby="nav-specifications-tab"
                        >
                          <div class="tab_description_content">
                            <div class="tab_description_content_1">
                              <div class="product-card__body__content__specifications-box__title">
                                Опис
                              </div>
                              <div class="product-card__body__content__specifications-box__description">
                                <?php the_content() ?>                                  
                              </div>
                            </div>
                            <div class="tab_description_content_2">
                              <div class="product-card__body__content__specifications-box__title">
                                Характеристики
                              </div>
                              <div class="product-card__body__content__specifications-box__description">
                                <?= $attributes ?>
                              </div>
                            </div>
                          </div>
                        </div>

            <!-- Описание -->
                        <!-- <div class="product-card__body__content__item tab-pane fade"
                             id="nav-description"
                             role="tabpanel"
                             aria-labelledby="nav-description-tab"
                        >
                    </div> -->

                    <!-- Отзывы -->
                        <!-- <div class="product-card__body__content__item tab-pane fade"
                             id="nav-review"
                             role="tabpanel"
                             aria-labelledby="nav-review-tab"
                        >
                    </div> -->

                </div>
            </div>
        </div>
    </div>





    <?php 
// global $product, $woocommerce_loop;

    if ( empty( $product ) || ! $product->exists() ) {
      return;
  }

  $related = $product->get_related( $posts_per_page );

  if ( sizeof( $related ) !== 0 ):

  foreach (get_the_terms( $product->id, 'product_cat' ) as $cat){
     if($cat->parent == 0){
       $mama = $cat->term_id;    
       foreach (get_the_terms( $product->id, 'product_cat' ) as $cat2){
          if($cat2->parent == $cat->term_id){
            $child = $cat2->term_id;                
            break;              
        }         
    }
    break;
}   
}


$args = array(  
  'orderby'=>'rand',
  'tax_query' => array(
    array(
      'taxonomy' => 'product_cat',          
      'terms' => $child,
      'include_children' => false
  )
)
);
$childprod = new WP_Query( $args );
$arr = array();
foreach ($childprod->posts as $pid){    
  array_push($arr, $pid->ID);           
}
wp_reset_postdata();
unset($arr[array_search($product->id,$arr)]);
shuffle($arr); 
array_splice($arr, 3);
if(count($arr) < 3){
  $arr = $related;
}

$args = apply_filters( 'woocommerce_related_products_args', array(
  'post_type'            => 'product',
  'ignore_sticky_posts'  => 1,
  'no_found_rows'        => 1,
  'posts_per_page'       => $posts_per_page,
  'orderby'              => $orderby,   
  'post__in'             => $arr,   
  'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;
?>

<!-- Section rec products -->
<section class="section">
    <div class="custom-container">
        <div class="section__head section__head--default">
            <h2 class="section__head__title">Рекомендовані товари</h2>
        </div>
        <div class="section__body">
            <div class="products-slider" id="recommendedProducts">

                <?php if ( $products->have_posts() ) : ?>
                    <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                       <?php

                       do_action( 'woocommerce_shop_loop' );
                        wc_get_template_part( 'content', 'product' );

                       ?>
                    <?php endwhile; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
<?php endif;?>
<br><br>


<script>
    jQuery(function($) {
        $("#image_zoom").elevateZoom({
            scrollZoom : true,
            // zoomType: "lens",
            containLensZoom: true, 
            gallery:'gallery_zoom', 
        });   

        $('#gallery_zoom').slick({
            slidesToShow: 4,
             slidesToScroll: 1,
             autoplay: false,
             vertical: true,
             verticalSwiping: true,
             responsive: [
                 {
                     breakpoint: 768,
                     settings: {
                         slidesToShow: 3,
                         vertical: false,
                         verticalSwiping: false,
                     }
                 }
             ]            
        });

        $('.elevatezoom-gallery').on('click', function(){
            $('#gallery_zoom').slick('slickGoTo',$(this).parents('.slick-slide').data('slick-index'));
        });

    });
</script> 













<!-- <div id="product-<?php // the_ID(); ?>" <?php // wc_product_class( '', $product ); ?>> -->

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	// do_action( 'woocommerce_before_single_product_summary' );
	?>

	<!-- <div class="summary entry-summary"> -->
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		// do_action( 'woocommerce_single_product_summary' );
		?>
       <!-- </div> -->

       <?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	// do_action( 'woocommerce_after_single_product_summary' );
	?>
    <!-- </div> -->

    <?php // do_action( 'woocommerce_after_single_product' ); ?>






