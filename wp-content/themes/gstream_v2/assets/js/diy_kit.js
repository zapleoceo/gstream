// setup and other stuff...
links.click(function(e) {
    /* unrelated stuff */
    jQuery.post(
        cpp_ajax.ajaxurl, 
        {
            action      : 'cpp_ajax-submit',
            nonce       : cpp_ajax.diy_product_nonce,
            product_id  : jQuery(this).attr('data-product-id')
        },
        function(response) {
            console.log(response);
        }
    );
});