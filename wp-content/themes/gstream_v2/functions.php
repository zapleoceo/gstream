<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */
function theme_scripts(){
	wp_enqueue_script('elevate-zoom', get_template_directory_uri() . '/assets/js/zoom/jquery.elevatezoom.js');
	wp_enqueue_script('elevate-zoom-min', get_template_directory_uri() . '/assets/js/zoom/jquery.elevateZoom-3.0.8.min.js');
	wp_enqueue_script('elevate-zoom-jquery', get_template_directory_uri() . '/assets/js/zoom/jquery-1.8.3.min.js');

	wp_enqueue_style('slick-css', get_template_directory_uri() . '/slick/slick.css');
	wp_enqueue_style('slick-theme-css', get_template_directory_uri() . '/slick/slick-theme.css');
	wp_enqueue_script('slick-js', get_template_directory_uri() . '/slick/slick.min.js');
}
add_action('wp_enqueue_scripts', 'theme_scripts');
/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';

	if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
		require 'inc/nux/class-storefront-nux-starter-content.php';
	}
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */

add_theme_support('post-thumbnails');

// FUNCTION

register_nav_menus(
	array(
		'primary' => __( 'Primary menu (header)', 'gstream' ),
		'top_menu' => __( 'Top menu (header)', 'gstream' ),
		'information_menu' => __( 'Information menu (footer)', 'gstream' ),
		'about_us_menu' => __( 'About Us menu (footer)', 'gstream' ),
		'top_menu_mobile' => __( 'Top menu mobile (header mobile)', 'gstream' ),
	)
);

function true_get_nav_menu_children_items( $parent_id, $nav_menu_items ) {
	$dochernie = array();
	foreach((array)$nav_menu_items as $val){
		if($val->menu_item_parent == $parent_id){
			$dochernie[$val->ID] = $val;
		}
	}
	return $dochernie;
}

add_action('main_menu', 'primary_menu');
function primary_menu(){
	$menu_home = '';
	$menu_name = 'primary';
	$locations = get_nav_menu_locations();
	if( $locations && isset($locations[ $menu_name ]) ){
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] ); // получаем объект меню
		$menu_items = wp_get_nav_menu_items( $menu ); // получаем элементы меню
		$menu_home = '<ul class="header__catalog__list">';
		foreach ( (array) $menu_items as $key => $menu_item ){
			if($menu_item->menu_item_parent == 0){				
				$menu_home .= '<li class="header__catalog__list__item dropdown">';
				$menu_home .= '<a href="'.$menu_item->url.'" data-no-folow class="header__catalog__list__item__link" role="button" id="catalog_2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
				$menu_home .= '<div class="header__catalog__list__item__link__icon svg">';
				$thumbnail_id = get_woocommerce_term_meta( $menu_item->object_id, 'thumbnail_id', true );
				$image = wp_get_attachment_url( $thumbnail_id );
				if($image){
					$menu_home .= '<img src="'.$image.'">';
				}	
				$menu_home .= '</div>';
				$menu_home .= '<div class="header__catalog__list__item__link__text">'.$menu_item->title.'</div>';
				$menu_home .= '</a>';
				$menu_home .= '<div class="dropdown-menu category-menu " aria-labelledby="catalog_2">';
				$menu_home .= '<div class="category-menu__list--wrapper">';

				$count_item = count(true_get_nav_menu_children_items($menu_item->ID, $menu_items));
				$row_sum = 1;
				foreach(true_get_nav_menu_children_items($menu_item->ID, $menu_items) as $item){
					if($row_sum == 1){
						$menu_home .= '<div class="category-menu__list">';
					}
					$menu_home .= '<a href="'.$item->url.'" class="category-menu__list__link category-menu__list__link--main">'.$item->title.'</a>';
					foreach(true_get_nav_menu_children_items($item->ID, $menu_items) as $item_sub){
						$menu_home .= '<a href="'.$item_sub->url.'" class="category-menu__list__link category-menu__list__link--sub">'.$item_sub->title.'</a>';
					}	
					if($row_sum == ceil($count_item/4)){
						$menu_home .= '</div>';	
					}
					if($row_sum == ceil($count_item/4)){
						$row_sum = 1;
					}else{
						$row_sum++;	
					}
				}
				$menu_home .= '</div>';
				$menu_home .= '<div class="category-menu__banner--wrapper">';
				$menu_home .= '<div class="category-menu__banner">';
				$menu_home .= '</div>';
				$menu_home .= '</div>';
				$menu_home .= '</div>';
				$menu_home .= '</li>';
			}
		}
		$menu_home .= "</ul>";
	}
	echo $menu_home;
}

add_action('top_menu', 'top_menu');
function top_menu(){
	$my_menu = '';
	$menu_name = 'top_menu';
	$locations = get_nav_menu_locations();
	if( $locations && isset($locations[ $menu_name ]) ){
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] ); // получаем объект меню
		$menu_items = wp_get_nav_menu_items( $menu ); // получаем элементы меню
		$my_menu = '<ul class="header__head__nav__list">';
		foreach ( (array) $menu_items as $key => $menu_item ){
			$my_menu .= '<li class="header__head__nav__list__item">';
			$my_menu .= '<a href="'.$menu_item->url.'" class="header__head__nav__list__item__link">'.$menu_item->title.'</a>';
			$my_menu .= '</li>';
		}
		$my_menu .= "</ul>";
	}
	echo $my_menu;
}

add_action('information_menu','information_menu');
function information_menu(){
	$my_menu = '';
	$menu_name = 'information_menu';
	$locations = get_nav_menu_locations();
	if( $locations && isset($locations[ $menu_name ]) ){
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
		$menu_items = wp_get_nav_menu_items( $menu );
		foreach ( (array) $menu_items as $key => $menu_item ){
			$my_menu .= '<a href="'.$menu_item->url.'" class="footer__navigation__list__item">'.$menu_item->title.'</a>';
		}
	}
	echo $my_menu;
}

add_action('about_us_menu','about_us_menu');
function about_us_menu(){
	$my_menu = '';
	$menu_name = 'about_us_menu';
	$locations = get_nav_menu_locations();
	if( $locations && isset($locations[ $menu_name ]) ){
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
		$menu_items = wp_get_nav_menu_items( $menu );
		foreach ( (array) $menu_items as $key => $menu_item ){
			$my_menu .= '<a href="'.$menu_item->url.'" class="footer__navigation__list__item">'.$menu_item->title.'</a>';
		}
	}
	echo $my_menu;
}

add_action('top_menu_mobile','top_menu_mobile');
function top_menu_mobile(){
	$my_menu = '';
	$menu_name = 'top_menu_mobile';
	$locations = get_nav_menu_locations();
	if( $locations && isset($locations[ $menu_name ]) ){
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
		$menu_items = wp_get_nav_menu_items( $menu );
		foreach ( (array) $menu_items as $key => $menu_item ){
			$my_menu .= '<a href="'.$menu_item->url.'" class="mobile-header__nav__menu__item">'.$menu_item->title.'</a>';
		}
	}
	echo $my_menu;
}

function my_pagination() {

	if( is_singular() )
		return;
	
	global $wp_query;
	
	/** Stop execution if there's only 1 page */
	if( $wp_query->max_num_pages <= 1 )
		return;
	$paged = get_query_var( 'paged', 1 );
	$max   = intval( $wp_query->max_num_pages );
	/** Add current page to the array */
	if ( $paged >= 1 ){
		$links[] = $paged;
	}
	if ( $paged == 0 && $max > 4){
		$links[] = $paged + 3;
		$links[] = $paged + 4;
	}
	/** Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}
	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}
	echo '<nav class="theme-pagination">
	<div class="custom-container">
	<ul class="theme-pagination__list">';
	/** Previous Post Link */
	if ( get_previous_posts_link() )
		printf( '<li class="theme-pagination__list__item theme-pagination__list__item--prev">%s</li>' . "\n", get_previous_posts_link('') );
	/** Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? 'active' : '';

		printf( '<li class="theme-pagination__list__item" %s><a href="%s" class="theme-pagination__list__item__link '.$class.'">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

		if ( ! in_array( 2, $links ) )
			echo '<li>…</li>';
	}
	/** Link to current page, plus 2 pages in either direction if necessary */
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? 'active' : '';
		if($paged == 0 && $link == 1){
			$class = 'active';
		}
		printf( '<li class="theme-pagination__list__item" %s><a href="%s" class="theme-pagination__list__item__link '.$class.'">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	}
	/** Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) )
			echo '<li>…</li>' . "\n";

		$class = $paged == $max ? ' class="active"' : '';
		printf( '<li class="theme-pagination__list__item" %s><a href="%s" class="theme-pagination__list__item__link '.$class.'">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	}
	/** Next Post Link */
	if ( get_next_posts_link() )
		printf( '<li class="theme-pagination__list__item theme-pagination__list__item--next">%s</li>' . "\n", get_next_posts_link('') );
	echo '</ul></div></nav>';
}

add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes() {
	return 'class="theme-pagination__list__item__link"';
}


function wpp_get_extremes_price_in_product_cat( $categories ) {

	global $wpdb;
	$result = $wpdb->get_results("
		SELECT  MIN({$wpdb->wc_product_meta_lookup}.min_price) as min_price , MAX({$wpdb->wc_product_meta_lookup}.max_price) as max_price
		FROM {$wpdb->posts} 
		INNER JOIN {$wpdb->term_relationships} ON ({$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id)
		INNER JOIN {$wpdb->wc_product_meta_lookup} ON ({$wpdb->posts}.ID = {$wpdb->wc_product_meta_lookup}.product_id) 
		WHERE  
		( {$wpdb->term_relationships}.term_taxonomy_id IN (".implode(',', $categories).") ) 
		AND {$wpdb->posts}.post_type = 'product' 
		AND {$wpdb->posts}.post_status = 'publish' 
		");


	return $result[ 0 ];

}

function wpp_get_extremes_count_products_in_cat( $attribute, $categories ) {

	global $wpdb;
	$result = $wpdb->get_results("
		SELECT  COUNT({$wpdb->posts}.ID) AS count
		FROM {$wpdb->posts} 
		INNER JOIN {$wpdb->term_relationships} AS attribute ON {$wpdb->posts}.ID = attribute.object_id
		INNER JOIN {$wpdb->term_relationships} AS category ON {$wpdb->posts}.ID = category.object_id
		WHERE  
		attribute.term_taxonomy_id IN (".$attribute.")
		AND category.term_taxonomy_id IN (".implode(',',$categories).")
		AND {$wpdb->posts}.post_type = 'product' 
		AND {$wpdb->posts}.post_status = 'publish' 
		");

	return $result[0];

}

function wpp_get_children_category( $category ) {
	$categories = array($category);
	$categories = array_merge($categories, get_term_children( $category, 'product_cat' ));
	foreach (get_term_children( $category, 'product_cat' ) as $key => $value) {
		$categories = array_merge($categories, get_term_children( $value, 'product_cat' ));
	}
	return $categories;
}


function wp_test_test($categories){
	global $wpdb;
	return "

	SELECT  MIN(meta_value) as min_price , MAX(meta_value) as max_price
	FROM {$wpdb->posts} 
	INNER JOIN {$wpdb->term_relationships} ON ({$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id)
	INNER JOIN {$wpdb->wc_product_meta_lookup} ON ({$wpdb->posts}.ID = {$wpdb->wc_product_meta_lookup}.product_id) 
	WHERE  
	( {$wpdb->term_relationships}.term_taxonomy_id IN (".implode(',', $categories).") ) 
	AND {$wpdb->posts}.post_type = 'product' 
	AND {$wpdb->posts}.post_status = 'publish' 
	";
}


function showby(){
	return array(12,18,24,36);
}
$showby = in_array($_GET['showby'], showby()) ? $_GET['showby'] : '12';
add_filter( 'loop_shop_per_page', function($cols) { return $showby;}, 20 );



function open_cart_popup(){
	
	global $woocommerce;
	$items = $woocommerce->cart->get_cart();
	$products = '';
	foreach ($items as $key => $value) {
		if($value['data']->get_image_id()){
			$image_item = '<img src="'.wp_get_attachment_image_url($value['data']->get_image_id(),"smoll").'" alt="">';
		}else{
			$image_item = '<img src="'.wp_get_attachment_image_url(5,"smoll").'" alt="">';
		}
		$products .= '<tr class="cart-table__body__row">
		<td class="cart-table__body__row__item">
		<div class="cart-table__body__product-img">'.$image_item.'</div>
		</td>
		<td class="cart-table__body__row__item">
		<div class="cart-table__body__product-name">
		<a href="'.get_permalink($value['data']->get_id()).'">'.$value['data']->get_name().'</a>
		</div>
		</td>
		<td class="cart-table__body__row__item">
		<div class="cart-table__body__product-quantity--wrapper">
		<div class="cart-table__body__product-quantity">
		<div class="cart-table__body__product-quantity__down update_item" data-route="down" data-quantity="quantity_'.$value['data']->get_id().'">
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="4" viewBox="0 0 16 4">
		<path fill="#EF8812" fill-rule="evenodd" d="M0 0h16v4H0z"/>
		</svg>
		</div>
		<div id="quantity_'.$value['data']->get_id().'" class="cart-table__body__product-quantity__counter" data-product_id="'.$value['key'].'">'.$value['quantity'].'</div>
		<div class="cart-table__body__product-quantity__up update_item" data-route="up" data- data-quantity="quantity_'.$value['data']->get_id().'">
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
		<path fill="#EF8812" fill-rule="evenodd" d="M10 6h6v4h-6v6H6v-6H0V6h6V0h4z"/>
		</svg>
		</div>
		</div>
		</div>
		</td>
		<td class="cart-table__body__row__item">
		<div class="cart-table__body__product-price">
		'.$value['data']->get_price().'<span class="woocommerce-Price-currencySymbol">грн</span>
		</div>
		</td>
		<td class="cart-table__body__row__item">
		<div class="cart-table__body__product-remove" data-product_id="'.$value['key'].'">
		<svg xmlns="http://www.w3.org/2000/svg" width="10" height="11" viewBox="0 0 10 11">
		<path fill="#D72828" fill-rule="evenodd" d="M6.538 5.904L10 9.365l-1.538 1.539L5 7.442l-3.462 3.462L0 9.365l3.462-3.461L0 2.442 1.538.904 5 4.365 8.462.904 10 2.442z"/>
		</svg>
		Видалити з кошика
		</div>
		</td>
		</tr>
		';
	}
	
	$cart_total = $woocommerce->cart->get_cart_subtotal();
	$cart_count = $woocommerce->cart->get_cart_contents_count();
	echo json_encode(array('products' => $products, 'cart_total' => $cart_total, 'cart_count' => $cart_count ));
	wp_die();
}
add_action('wp_ajax_nopriv_ajax_cart_popup', 'open_cart_popup' );
add_action('wp_ajax_ajax_cart_popup', 'open_cart_popup' );

function count_item_to_cart(){
	global $woocommerce;
	echo $woocommerce->cart->get_cart_contents_count();
	wp_die();
}
add_action('wp_ajax_nopriv_ajax_count_item_to_cart', 'count_item_to_cart' );
add_action('wp_ajax_ajax_count_item_to_cart', 'count_item_to_cart' );

function update_item_to_cart(){
	global $woocommerce;
	$count = $_REQUEST['count'];
	$product_id = $_REQUEST['product_id'];
	$items = $woocommerce->cart->get_cart();
	foreach ($items as $key => $value) {
		if($value['key'] == $product_id){
			$woocommerce->cart->set_quantity( $product_id, $count, true );
			break;
		}
	}
	$cart_total = $woocommerce->cart->get_cart_subtotal();
	$cart_count = $woocommerce->cart->get_cart_contents_count();
	echo json_encode(array('cart_total' => $cart_total, 'cart_count' => $cart_count));
	wp_die();
}
add_action('wp_ajax_nopriv_ajax_update_item_to_cart', 'update_item_to_cart' );
add_action('wp_ajax_ajax_update_item_to_cart', 'update_item_to_cart' );

function remove_item_to_cart(){
	global $woocommerce;
	$product_id = $_REQUEST['product_id'];
	$items = $woocommerce->cart->get_cart();
	foreach ($items as $key => $value) {
		if($value['key'] == $product_id){
			$woocommerce->cart->remove_cart_item( $product_id);
			break;
		}
	}
	$cart_total = $woocommerce->cart->get_cart_subtotal();
	$cart_count = $woocommerce->cart->get_cart_contents_count();
	echo json_encode(array('cart_total' => $cart_total, 'cart_count' => $cart_count));
	wp_die();
}
add_action('wp_ajax_nopriv_ajax_remove_item_to_cart', 'remove_item_to_cart' );
add_action('wp_ajax_ajax_remove_item_to_cart', 'remove_item_to_cart' );
// хлебные крошки для магазина
function breadcrumbs($cat_id, $page){
	if($page == 'product_tag'){
		$cat = get_term_by( 'id', $cat_id, 'product_tag' );
		$breadcrumbs = '<li class="breadcrumbs__list__item"><a href="/" class="breadcrumbs__list__item__link">Головна</a></li><li class="breadcrumbs__list__item"><a '.$link.' class="breadcrumbs__list__item__link">'.$cat->name.'</a></li>';
		return $breadcrumbs;
	}
	$cat = get_term_by( 'id', $cat_id, 'product_cat' );
	if($page == 'product'){
		$link = 'href="/?product_cat='.$cat->slug.'"';
	}elseif($page == 'product_cat') {
		$link = '';
	}else{
		return '<li class="breadcrumbs__list__item"><a href="/" class="breadcrumbs__list__item__link">Головна</a></li>';
	}
	$breadcrumbs = '<li class="breadcrumbs__list__item"><a '.$link.' class="breadcrumbs__list__item__link">'.$cat->name.'</a></li>';
	$chek = $cat->parent;
	while($chek !== 0){
		$cat = get_term_by( 'id', $chek, 'product_cat' );
		$breadcrumbs = '<li class="breadcrumbs__list__item"><a href="/?product_cat='.$cat->slug.'" class="breadcrumbs__list__item__link">'.$cat->name.'</a></li>' . $breadcrumbs; 
		$chek = $cat->parent;
	}
	$breadcrumbs = '<li class="breadcrumbs__list__item"><a href="/" class="breadcrumbs__list__item__link">Головна</a></li>'. $breadcrumbs;
	return $breadcrumbs;
}

// // Hook in
// add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// // Our hooked in function - $fields is passed via the filter!
// function custom_override_checkout_fields( $fields ) {
//      $fields['billing']['shipping_payment'] = array(
//         'label'     => __('Выберите способ оплаты', 'woocommerce'),
//     'placeholder'   => _x('Наложенный платеж...', 'placeholder', 'woocommerce'),
//     'required'  => true,
//     'class'     => array('form-row-wide'),
//     'clear'     => true
//      );

//      return $fields;
// }

// /**
//  * Display field value on the order edit page
//  */
 
// add_action( 'woocommerce_admin_order_data_after_shipping_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

// function my_custom_checkout_field_display_admin_order_meta($order){
//     echo '<p><strong>'.__('Payment From Checkout Form').':</strong> ' . get_post_meta( $order->get_id(), 'shipping_payment', true ) . '</p>';
// }


// отключить оплату
add_filter( 'woocommerce_cart_needs_payment', '__return_false' );
// удаление полей с формы "детали оплаты"

add_filter('woocommerce_checkout_fields','remove_checkout_fields');
function remove_checkout_fields($fields){

    $fields['billing']['billing_address_1']['placeholder'] = 'Введите город';
    
    $fields['billing']['billing_address_2']['type']="select";
    $fields['billing']['billing_address_2']['value']="";
    $fields['billing']['billing_address_2']['autocomplete']="";
    $fields['billing']['billing_address_2']['required'] = true;
    $fields['billing']['billing_address_2']['placeholder'] = 'Новая почта...';
    $fields['billing']['billing_address_2']['label']="Выберите способ доставки";
    $fields['billing']['billing_address_2']['options'] = array(
      'option_1' => 'Новая почта',
      'option_2' => 'Автолюкс',
      'option_3' => 'Деливери',
      'option_4' => 'Міст-експрес',
      'option_5' => 'Гюнсел',
      'option_6' => 'Самовывоз (м.Дніпро, вул. Алана Шепарда 33а (Суворова 33а))',
    );
    

    $fields['billing']['billing_city']['type']="select";
    $fields['billing']['billing_email']['required']=false;
    $fields['billing']['billing_city']['value']="";
    $fields['billing']['billing_city']['autocomplete']="";
    $fields['billing']['billing_city']['required'] = true;
    $fields['billing']['billing_city']['placeholder'] = 'Наложенный платеж...';
    $fields['billing']['billing_city']['label']="Введите способ оплаты";
    $fields['billing']['billing_city']['options'] = array(
      'option_7' => 'Безналичный расчет (на карту Приват Банк)',
      'option_8' => 'Наложенный платеж',
      'option_9' => 'Оплата наличными (при самовывозе г.Днепр)',
    );
    
	//unset($fields['billing']['billing_address_2']);
	//unset($fields['billing']['billing_email']);
	//unset($fields['billing']['billing_address_1']);
	unset($fields['billing']['billing_country']);
	unset($fields['billing']['billing_company']);
	unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_postcode']);
	return $fields;
}






add_filter('template_include', 'my_template', 99);
function my_template( $template ) {

	$product_cat = get_queried_object();
	if($product_cat->taxonomy == 'category'){ // && in_array($product_cat->term_taxonomy_id, array(192, 2072))
		return get_stylesheet_directory() . '/news-blog.php';
	}
	return $template;
}

// анонс поста
add_filter( 'excerpt_more', 'new_excerpt_more' );
function new_excerpt_more( $more ){
	global $post;
	return '...';
}
function new_excerpt_length($length) {
	return 20;
}
add_filter('excerpt_length', 'new_excerpt_length');





add_filter( 'wpcf7_form_class_attr', 'custom_custom_form_class_attr' );
function custom_custom_form_class_attr( $class ) {
  $class .= ' section__body__contacts__form';
  return $class;
}

function dco_pre_get_posts($query) {
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_search) {
            $query->set('post_type', 'product');
        }
    }
}

add_action('pre_get_posts', 'dco_pre_get_posts');

// настройки для баннеров
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'G-Stream settings',
		'menu_title'	=> 'Доп. настройки',
		'menu_slug' 	=> 'g-stream-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));	
}


