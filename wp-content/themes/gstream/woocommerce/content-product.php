<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<!-- <li <?php //wc_product_class( '', $product ); ?>> -->
<?php
$terms = get_the_terms( $product->id, 'product_tag' );

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
	<div class="products-list__item">
		<a href="<?= get_permalink(); ?>" class="products-list__item--wrapper">
			<div class="products-list__item__image">
				<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
			</div>
			<p class="products-list__item__description">
				<?php the_title();?>
			</p>
			<div class="products-list__item__footer">
				<?php if($product->stock_status == 'instock'): ?>
					<div class="products-list__item__price">
						<?= $product->get_price_html(); ?>
					</div>
					<button data-quantity="1" class="products-list__item__button button product_type_simple add_to_cart_button ajax_add_to_cart" data-title="<?php the_title();?>" data-product_id="<?= $product->id ?>" data-product_sku="" aria-label="Добавить &quot;<?= $product->name ?>&quot; в корзину" rel="nofollow">
						<span class="products-list__item__button__text">Купить</span>
					</button>
				<?php endif;?>
			</div>
			<div class="product_tag_block">
				<ul>
					<?php foreach($images_terms as $val): ?>
					<li class="product_tag_img">
						<img src="<?= $val['img'] ?>" class="product_tag_img" title="<?= $val['term']->name ?>" data-slug="<?= $val['term']->slug ?>">
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</a>
		<?php

	// do_action( 'woocommerce_before_shop_loop_item' );

	// do_action( 'woocommerce_before_shop_loop_item_title' );

	// do_action( 'woocommerce_shop_loop_item_title' );

	// do_action( 'woocommerce_after_shop_loop_item_title' );

	// do_action( 'woocommerce_after_shop_loop_item' );
		?>
	</div>