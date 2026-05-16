<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

$product_cat = get_queried_object();

$data_price = wpp_get_extremes_price_in_product_cat(wpp_get_children_category($product_cat->term_id));

$min_value = ($_GET['min_price'] > 0 && $_GET['min_price'] >= $data_price->min_price) ? $_GET['min_price'] : $data_price->min_price ;
$max_value = ($_GET['max_price'] > 0 && $_GET['max_price'] <= $data_price->max_price) ? $_GET['max_price'] : $data_price->max_price ;

$catalog_orderby_options = [
	'menu_order' => 'Умолчанию',
	'popularity' => 'Популярности',
	'rating' => 'Рейтингу',
	'date' => 'Дате',
	'price-desc' => 'Цены убыванию',
	'price' => 'Цены возрастанию',
	
];

if($_GET['product_cat']){
	$page = 'product_cat';
}elseif($_GET['product_tag']){
	$page = 'product_tag';
}

$block_attr = '';
foreach (wc_get_attribute_taxonomies() as $key => $value) {
	$attr = 'pa_'.$value->attribute_name;
	$products = 0;
	$filter = '';
	$filter .= '<div class="products-filter__item">';
	$filter .= '<div class="products-filter__item__title">'.$value->attribute_label.'</div>';
	$filter .= '<div class="checkboxes">';
	if($value->attribute_public == true){
		foreach (get_terms($attr) as $key => $value) {
			$count = wpp_get_extremes_count_products_in_cat($value->term_id, wpp_get_children_category($product_cat->term_id))->count;
			if($count > 0 ){
				$checked = '';
				if(in_array($value->slug, explode(',',get_query_var($attr)))){
					$checked = 'checked';
				}
				$products = $count+$products;
				$filter .= '<div class="checkboxes__item">';
				$filter .= '<label class="checkboxes__item__content">';
				$filter .= '<input type="checkbox" class="hidden filter_shop" value="'.$value->slug.'" name="'.$value->taxonomy.'" '.$checked.'>';
				$filter .= '<span class="checkboxes__item__content__checkbox"></span>';
				$filter .= '<span class="checkboxes__item__content__text">'.$value->name.'</span>';
				$filter .= '<span class="checkboxes__item__content__quantity">('.$count.')</span>';
				$filter .= '</label>';
				$filter .= '</div>';		
			}
		}
	}
	$filter .= '</div>';
	$filter .= '</div>';

	if($products > 0) {
		$block_attr .= $filter;
	}
}

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
				<?= breadcrumbs($product_cat->term_id, $page) ?>
			</ul>
		</div>
	</div>
</div>

<div class="products-section">
	<div class="custom-container">
		<form id="sorting_form" method="get">
			<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page', 'showby' ) ); ?>
			<input type="hidden" name="paged" value="1" />

		<div class="products-section__head">
			<h2 class="products-section__head__title">
				<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
					<?php woocommerce_page_title(); ?>
				<?php endif; ?>
			</h2>
			<div class="products-section__head__controls">
				<div class="products-section__head__controls__sort">
					<span>Сортировать по:</span>
					<select name="orderby" class="orderby customSelectSortBy" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
						<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
							<option value="<?php echo esc_attr( $id ); ?>" <?= $_GET['orderby'] ===  $id ? 'selected': '';?>><?php echo $name; ?></option>
						<?php endforeach; ?>
					</select>	
				</div>
				<div class="products-section__head__controls__sort">
					<span>Показать по:</span>
					<select name="showby" id="showBy">
						<?php foreach (showby() as $value) :?>
							<option value="<?= $value ?>" <?= $_GET['showby'] ==  $value ? 'selected': '';?>><?= $value ?> ед.товара</option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</div>
		</form>

		<div class="products-section__body">

			<!-- NEW: Filter Button toggle -->
			<button class="products-section__body__mobile-filter-button">фильтры</button>

			<!-- Filter wrapper-->
			<div class="products-section__body__filter">
				<div class="products-filter">

					<!-- Chips section -->
					<!-- <div class="products-filter__item">
						<div class="chips">

							<div class="chips__item">
								<span class="chips__item__content">
									<span class="chips__item__content__close"></span>
									GStream
								</span>
							</div>
							
						</div>
					</div> -->

					<!-- Range input section -->
					<form id="products_filter" class="get">
						<input type="hidden" name="<?= $page ?>" value="<?= $product_cat->slug?>">
						<input type="hidden" name="orderby" value="<?= $_GET['orderby'] ?>">
						<div class="products-filter__item">
							<div class="products-filter__item__title">Цена</div>
							<div class="range-input">
								<div class="range-input__slider" id="slider-range"></div>
								<div class="range-input__values" style="padding: 0;">
									<input type="hidden" id="min-amount" value="<?= floor($data_price->min_price) ?>">
                                    <input type="hidden" id="max-amount" value="<?= ceil($data_price->max_price); ?>">
									<div class="range-input__values__item">
										от
										<input type="text" id="min-value" class="filter_shop" name="min_price" value="<?= floor($min_value) ?>" readonly>
										<span>₴</span>
									</div>
									<div class="range-input__values__item">
										до
										<input type="text" id="max-value" class="filter_shop" name="max_price" value="<?= ceil($max_value) ?>" readonly>
										<span>₴</span>
									</div>
									<button class="products-list__item__button" style="padding-right: 10px;padding-left: 10px;">
										<span class="products-list__item__button__text">ОК</span>
									</button>
								</div>

							</div>
						</div>

						<?= $block_attr ?>
					</form>
				</div>
			</div>
			
			<!-- Products wrapper -->
			<div class="products-section__body__products">
				<div class="products-list">




					<?php
					if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	// do_action( 'woocommerce_before_shop_loop' );

	// woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	// woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	// do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
// do_action( 'woocommerce_after_main_content' );

?>
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





<?php my_pagination() ?>


	
	<script>
	// document.addEventListener('DOMContentLoaded', function(){ 

	// });

	jQuery(function($) {

		$('body').on('click','.ui-menu-item', function(){
			$('#sorting_form').submit();
		});

		$('.filter_shop').on('click, change', function(){
			var data_form = $('form#products_filter').serializeArray();
			var new_data_form = data_form.reduce((acc, curr) => {
				if(acc.some(obj => obj.name === curr.name)) {
					acc.forEach(obj => {
						if(obj.name === curr.name) {
							obj.value = obj.value + "," + curr.value;
						}
					});
				} else {
					acc.push(curr);
				}
				return acc;
			}, []);
			var form = document.createElement("form");
			$(form).attr("action", "<?= get_site_url(); ?>").attr("method", "get");
			$.each(new_data_form, function(key,val){
				$(form).append("<input name='"+val.name+"' type='hidden' value='"+val.value+"' />");
			});
			$(document.body).append(form);
			form.submit();
		});
	});
</script>
<?php
// do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );

?>