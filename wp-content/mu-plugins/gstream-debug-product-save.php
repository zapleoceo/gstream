<?php
/**
 * Temporary debug: log why WooCommerce product meta save is skipped.
 * Remove after diagnosis is complete.
 */

add_action( 'save_post', function ( $post_id, $post ) {
    if ( ! $post || $post->post_type !== 'product' ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    $log = WP_CONTENT_DIR . '/debug-product-save.log';
    $ts  = date( 'Y-m-d H:i:s' );

    $nonce_present = ! empty( $_POST['woocommerce_meta_nonce'] );
    $nonce_valid   = $nonce_present && wp_verify_nonce(
        wp_unslash( $_POST['woocommerce_meta_nonce'] ),
        'woocommerce_save_data'
    );
    $post_id_match = ! empty( $_POST['post_ID'] ) && absint( $_POST['post_ID'] ) === $post_id;
    $can_edit      = current_user_can( 'edit_post', $post_id );
    $has_price     = isset( $_POST['_regular_price'] );
    $has_sku       = isset( $_POST['_sku'] );

    $entry = implode( "\n", [
        "[$ts] product_id=$post_id",
        "  nonce_present=" . var_export( $nonce_present, true ),
        "  nonce_valid=" . var_export( (bool) $nonce_valid, true ),
        "  post_id_match=" . var_export( $post_id_match, true ),
        "  can_edit=" . var_export( $can_edit, true ),
        "  has_price_in_post=" . var_export( $has_price, true ),
        "  has_sku_in_post=" . var_export( $has_sku, true ),
        "  _regular_price=" . ( $has_price ? sanitize_text_field( $_POST['_regular_price'] ) : 'NOT IN POST' ),
        "  _sku=" . ( $has_sku ? sanitize_text_field( $_POST['_sku'] ) : 'NOT IN POST' ),
        "  product-type=" . ( isset( $_POST['product-type'] ) ? sanitize_text_field( $_POST['product-type'] ) : 'NOT IN POST' ),
        "",
    ] );

    file_put_contents( $log, $entry, FILE_APPEND );
}, 99, 2 );
