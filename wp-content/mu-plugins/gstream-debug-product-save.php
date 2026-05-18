<?php
/**
 * Temporary debug: log + show admin notice on product save.
 * Remove after diagnosis. Safe — read-only checks, no side effects.
 */

add_action( 'save_post', function ( $post_id, $post ) {
    if ( ! $post || $post->post_type !== 'product' ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( wp_is_post_revision( $post ) ) {
        return;
    }

    $nonce_present = ! empty( $_POST['woocommerce_meta_nonce'] );
    $nonce_valid   = $nonce_present && (bool) wp_verify_nonce(
        wp_unslash( $_POST['woocommerce_meta_nonce'] ),
        'woocommerce_save_data'
    );
    $post_id_match = ! empty( $_POST['post_ID'] ) && absint( $_POST['post_ID'] ) === $post_id;
    $has_price     = isset( $_POST['_regular_price'] );
    $has_sku       = isset( $_POST['_sku'] );

    $info = [
        'nonce_present' => $nonce_present,
        'nonce_valid'   => $nonce_valid,
        'post_id_match' => $post_id_match,
        'can_edit'      => current_user_can( 'edit_post', $post_id ),
        'price_in_post' => $has_price ? sanitize_text_field( $_POST['_regular_price'] ) : 'MISSING',
        'sku_in_post'   => $has_sku   ? sanitize_text_field( $_POST['_sku'] )           : 'MISSING',
        'product_type'  => isset( $_POST['product-type'] ) ? sanitize_text_field( $_POST['product-type'] ) : 'MISSING',
        'wc_meta_saved' => class_exists( 'WC_Admin_Meta_Boxes' )
            ? ( new ReflectionClass( 'WC_Admin_Meta_Boxes' ) )->getStaticPropertyValue( 'saved_meta_boxes' )
            : 'n/a',
    ];

    // Write file log.
    $log   = WP_CONTENT_DIR . '/debug-product-save.log';
    $entry = '[' . date( 'Y-m-d H:i:s' ) . "] product_id=$post_id\n";
    foreach ( $info as $k => $v ) {
        $entry .= "  $k=" . var_export( $v, true ) . "\n";
    }
    file_put_contents( $log, $entry . "\n", FILE_APPEND );

    // Show as admin notice on next page load.
    $msg = '<strong>DEBUG product save (#' . $post_id . '):</strong><br>';
    foreach ( $info as $k => $v ) {
        $color = ( is_bool( $v ) && ! $v ) || $v === 'MISSING' ? 'red' : 'green';
        $msg  .= '<span style="color:' . $color . '">' . esc_html( $k ) . ' = ' . esc_html( var_export( $v, true ) ) . '</span><br>';
    }
    set_transient( 'gstream_debug_product_save_' . $post_id, $msg, 120 );
}, 2, 2 ); // priority 2 — after WooCommerce (priority 1), before ACF (priority 10)

add_action( 'admin_notices', function () {
    $screen = get_current_screen();
    if ( ! $screen || $screen->id !== 'product' ) {
        return;
    }
    $post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;
    if ( ! $post_id ) {
        return;
    }
    $msg = get_transient( 'gstream_debug_product_save_' . $post_id );
    if ( $msg ) {
        echo '<div class="notice notice-warning is-dismissible"><p>' . $msg . '</p></div>';
        delete_transient( 'gstream_debug_product_save_' . $post_id );
    }
} );
