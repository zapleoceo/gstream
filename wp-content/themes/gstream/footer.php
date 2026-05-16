<?php wp_footer(); ?>

<!-- Footer -->
<footer class="footer">
    <div class="custom-container">
        <div class="footer--wrapper">

            <div class="footer__brand">
                <div class="footer__brand__logo">
                    <a href="#" class="footer__brand__logo__link"></a>
                </div>
                <p class="footer__brand__text">
                    Украинская торговая марка, которая предлагает всем
                    любителям рыбной ловли качественную рыболовную
                    прикормку и арамотические добавки к ней
                </p>

                <div class="footer__subscription footer__subscription--desktop">
                    <div class="footer__subscription__text">Подписаться на новости</div>
                    <div class="footer__subscription__box">
                        <input type="email" class="footer__subscription__box__input" placeholder="Ваш E-mail адрес">
                        <button class="footer__subscription__box__button">
                            <span class="footer__subscription__box__button__text">ПОДПИСАТЬСЯ</span>
                        </button>
                    </div>
                </div>

            </div>

            <div class="footer__navigation">

                <!-- Information list -->
                <div class="footer__navigation__list">
                    <div class="footer__navigation__list__title">Информация</div>
                    <?php do_action('information_menu');?>
                </div>

                <!-- About us list -->
                <div class="footer__navigation__list">
                    <div class="footer__navigation__list__title">о нас</div>
                    <?php do_action('about_us_menu');?>
                </div>

                <!-- Contacts list -->
                <div class="footer__navigation__list">
                    <div class="footer__navigation__list__title">контакты</div>
                    <div class="footer__navigation__list__item">Пн - Пт : с 9.00 до 20:00</div>
                    <div class="footer__navigation__list__item">Суббота : с 9:00 до 18:00</div>
                    <div class="footer__navigation__list__item">Воскресенье : выходной</div>
                    <a href="tel:+380953238262" class="footer__navigation__list__item">+38 (095) 323-82-62</a>
                    <a href="tel:+380679928071" class="footer__navigation__list__item">+38 (067) 992-80-71</a>
                    <a href="tel:+380938609799" class="footer__navigation__list__item">+38 (093) 860-97-99</a>
                </div>

            </div>
        </div>

        <div class="footer__subscription footer__subscription--mobile">
            <div class="footer__subscription__text">Подписаться на новости</div>
            <div class="footer__subscription__box">
                <input type="email" class="footer__subscription__box__input" placeholder="Ваш E-mail адрес">
                <button class="footer__subscription__box__button">
                    <span class="footer__subscription__box__button__text">ПОДПИСАТЬСЯ</span>
                </button>
            </div>
        </div>

        <div class="footer__copyright">© 2008 – 2019, интернет магазин GStream</div>
    </div>
</footer>


<div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="#cartModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalTitle">Корзина</h5>
                <button type="button" class="close svg" data-dismiss="modal" aria-label="Close">
                    <!--<span aria-hidden="true">&times;</span>-->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                        <g fill="none" fill-rule="evenodd">
                            <path d="M-6-6h32v32H-6z"/>
                            <path fill="#2A2A2D" fill-opacity=".96" d="M11.414 10l7.778 7.778-1.414 1.414L10 11.414l-7.778 7.778-1.414-1.414L8.586 10 .808 2.222 2.222.808 10 8.586 17.778.808l1.414 1.414L11.414 10z"/>
                        </g>
                    </svg>
                </button>
            </div>
            <!--Add class modal-body&#45;&#45;cart-empty -->
            <div class="modal-body modal-body&#45;&#45;cart-empty modal_cart_empty">
                К сожалению Ваша корзина пустая :(
            </div>
            <div class="modal-body modal_cart_full">
                <div class="table-responsive-sm cart-table--wrapper">
                    <table class="table cart-table">
                        <thead class="cart-table__head">
                            <tr>
                                <th></th>
                                <th>Наименование товара</th>
                                <th>Количество</th>
                                <th>Стоимость</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="cart-table__body">                        
                        </tbody>
                    </table>
                </div>
                <div class="modal-body__cart-total">
                    <span>Всего:</span>
                    <span><span id="cart_total"></span></span>
                </div>
            </div>
            <div class="modal-footer modal_cart_full">
                <a href="<?php  echo WC()->cart->get_cart_url() ?>" style="text-decoration: none;" class="theme-button cart-button">ОФОРМИТЬ ЗАКАЗ</a>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    jQuery(function($) {
    $('.product_tag_img').click(function(e){
        e.preventDefault();
        $(this).prop( "disabled", true );
        if($(this).data('slug')){
            window.location.href = '/?product_tag='+$(this).data('slug');
        }
        $(this).prop( "disabled", false );
    });
    //user sided variable for PHP value
    $(".ajax_add_to_cart").click(function(){
        var total = parseInt($(".totalCost").text()); 
        total++;                    
        $(".totalCost").text(total);
        alert("Товар "+$(this).data('title')+" добавлен в корзину.");
    });
    $('.product-remove').click(function(e){
        e.preventDefault();
        var total = parseInt($(".totalCost").text()); 
        total--;                    
        $(".totalCost").text(total);
    });

    $('body').on('click', '.update_item', function(){
        $(this).prop( "disabled", true );
        var quantity = $('#'+$(this).data('quantity'));
        var count = parseInt(quantity.text()); 
        if($(this).data('route') == 'down'){
            count--;
        }else if($(this).data('route') == 'up'){
            count++;
        }
        if (count > 0 && count < 1000){
            $.ajax({
                type: 'POST',
                url: "/wp-admin/admin-ajax.php",
                data: { 
                    action: "ajax_update_item_to_cart",
                    count: count,
                    product_id: quantity.data('product_id')
                },
                success: function(request){
                    quantity.text(count);  
                    var result = JSON.parse(request);
                    $(".totalCost").text(result['cart_count']);   
                    $('#cart_total').html(result['cart_total']);          
                },
                error: function(request){
                    console.log('error', request);
                }
            });
        }
        $(this).prop( "disabled", false );
    });

    $('body').on('click', '.cart-table__body__product-remove', function(){
        var row = $(this).parents('tr.cart-table__body__row');
        $.ajax({
            type: 'POST',
            url: "/wp-admin/admin-ajax.php",
            data: { 
                action: "ajax_remove_item_to_cart",
                product_id: $(this).data('product_id')
            },
            success: function(request){
                row.hide(400);
                var result = JSON.parse(request);
                $(".totalCost").text(result['cart_count']);   
                $('#cart_total').html(result['cart_total']); 
                if(parseInt(result['cart_count']) > 0){
                    $('.modal_cart_empty').hide();
                    $('.modal_cart_full').show();
                }else{
                    $('.modal_cart_empty').show();
                    $('.modal_cart_full').hide();
                }         
            },
            error: function(request){
                console.log('error', request);
            }
        });
    });


    function update_popup_cart(){
        $.ajax({
            type: 'POST',
            url: "/wp-admin/admin-ajax.php",
            data: { 
                action: "ajax_cart_popup"
            },
            success: function(request){
                var result = JSON.parse(request);
                if(parseInt(result['cart_count']) > 0){
                    $('.modal_cart_empty').hide();
                    $('.modal_cart_full').show();
                }else{
                    $('.modal_cart_empty').show();
                    $('.modal_cart_full').hide();
                }
                $('#cart_total').html(result['cart_total']);
                $('.cart-table__body').html(result['products']);                
            },
            error: function(request){
                console.log('error', request);
            }
        });
    }
    $('.header__body__cart__block').click(function(e){
        e.preventDefault();
        update_popup_cart();
    });
    update_popup_cart();    
});
</script>
<script type="text/javascript" src="<?= get_template_directory_uri() ?>/app.bundle.js"></script>
</body>
</html>
