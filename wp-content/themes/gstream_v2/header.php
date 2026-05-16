<?php
global $woocommerce;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-158136092-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-158136092-1');
	</script>
	
    <link rel="stylesheet" type="text/css" href="<?php echo esc_url(get_template_directory_uri()); ?>/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo esc_url(get_template_directory_uri()); ?>/slick/slick-theme.css"/>

    <link rel="stylesheet" type="text/css" href="<?php echo esc_url(get_template_directory_uri()); ?>/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="<?php echo esc_url(get_template_directory_uri()); ?>/slick/slick-theme.css">
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="<?php echo esc_url(get_template_directory_uri()); ?>/slick/slick.js" type="text/javascript" charset="utf-8"></script>
                
    <meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>

	<link href="<?= get_template_directory_uri() ?>/main.css" rel="stylesheet"></head>
<body>
<div class="wrapper">
    <!-- Header -->
    <!-- NEW: className -->
    <header class="header <?php if(is_front_page()):?>header--main-page<?php endif;?>">

        <div class="custom-container">
            <!-- Header Top Part -->
            <div class="header__head">
                <nav class="header__head__nav">
                    <?php do_action('top_menu')?>
                </nav>
                <div class="header__head__contacts">

                    <!-- Responsive changes: two blocks with two lines each -->
                    <ul class="header__head__contacts__list">
                        <li style="display: flex; flex-direction: column; gap: 14px;" class="header__head__contacts__list__item">
                            <a href="tel:+380931372474" class="header__head__contacts__list__item__link">
                                <div class="header__head__contacts__list__item__link__icon svg">
                                    <img src="https://imgs.search.brave.com/J9FNBqcsfFEVDJBvCqWYOVZ2_O7dfkF2K3jb9qHhr8c/rs:fit:64:0:0:0/g:ce/aHR0cDovL2Zhdmlj/b25zLnNlYXJjaC5i/cmF2ZS5jb20vaWNv/bnMvMjg5YjY1MDY1/Y2NmZWZkOWQwZmNk/YTI4ODM1ZmEwNGYz/YjdjOGUyZGRhZDEw/ZTdkOTdhN2NiYzAx/NGUxZGMzMS93d3cu/bGlmZWNlbGwudWEv" width="20" height="20">
                                </div>
                                <span class="header__head__contacts__list__item__link__text">+38 (063) 261-55-67</span>
                            </a>
                            <a href="tel:+380632615567" class="header__head__contacts__list__item__link">
                                <div class="header__head__contacts__list__item__link__icon svg">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g clip-path="url(#clip0)">
                                            <rect width="19.9945" height="19.027" fill="url(#pattern0)"/>
                                        </g>
                                        <defs>
                                            <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                <use xlink:href="#image0" transform="scale(0.05 0.0526316)"/>
                                            </pattern>
                                            <clipPath id="clip0">
                                                <rect width="19.995" height="19.027" fill="white"/>
                                            </clipPath>
                                            <image id="image0" width="20" height="19" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAATCAMAAACnUt2HAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAABYlBMVEUAov8An/8Aof8AoP8Anf8Aqf8Atv8Anv8ArP8AvP8Alv8Arf8AuP8Akf8ApP8Ar/8Amf8At/8Apf8AtP8Al/8A8P8AlP8AmP8Alf8AwP8Am/8Awv8AsP8AnP8Ajv8Ai/8AjP8Ao/8Aiv8Aif8Ajf8Ah/8Ag/8Agv8Af/8Aff8Asf8AhP8Ahv8Akv8Ak/8Amv8Afv8Ad/8Ap/8Ahf8AeP8Apv8Aqv8AfP8AqP8Aof8AoP8AoP8Akf8Aof8AoP8Anf8Arf8Ayf8Aov8Aof8Aof8AnP8Aqf8Anf8An/8Aov8Aef8Atv8AqP8Anf8AoP8AqP8Am/8AoP8Aof8An/8An/8Anv8Am/8Aov8Aof8Amv8ApP8Amf8Aov8An/8Apf8Apv8Aj/8AqP8Aof8AqP8AjP8Aof8Ap/8Ajf8Anv8An/8ApP8AoP8AoP8AoP8Anf8Aof8An/8Aov8Ao/8ApP8Anv8AAACS8G4nAAAAbXRSTlMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAS5U1NYNSFKCjN1oUhLlzy+xw4jN/2FwE+JSl/GwTaq6CLoGTFw2Up/folJPn9KYxgQviMVHKwUwAAAAFiS0dEdahqmPsAAAAJcEhZcwAACxIAAAsSAdLdfvwAAAAHdElNRQfkBxUVODJRQwRpAAABUUlEQVQY0z3PV1PCQBiF4S/ZleBGCEIwEAjFiooaYwOkF3ujCIq9S9kE0P8/gojn5p157g4Aw7CIZdloLBbtB7EMAwAIMRghtEvpbj+YQWiAeMzEjZAzjeEhmsfJCMm4+Q/5CYt1iFbLBP+PRLDFKY3bBDLERDKVniR2R0bXMw47mUynkgnIGp1uLl8QnXt7TrGQz3U7Rhb2D3S90zs8woKAjw57HV0/2Icp6fjklJ6dI45D52f09ORYmgKX6OYviiX0u1LxgneLLiDEzcvDJ4NnMu8mBCTs8bKoXLlUlMtKGbFeD5bA5/cF/NUavQoGr2itOj0dmJmFufmF0OL113fdu1T//roJLYfn/LCyahFvu/QOr3HBe0ofQMYKqOr64xN9fjFrgY3XN+P9Y1NVQVHkT4M2trbtyzvhhmF8yooCmhZptto2IooKlm3tVjOiaT91bD/Qfos+TwAAAABJRU5ErkJggg=="/>
                                        </defs>
                                    </svg>
                                </div>
                                <span class="header__head__contacts__list__item__link__text">+38 (098) 869-92-27</span>
                            </a>
                        </li>
                        <li style="display: flex; flex-direction: column; gap: 14px;" class="header__head__contacts__list__item">
                            <a href="tel:+380994438097" class="header__head__contacts__list__item__link">
                                <div class="header__head__contacts__list__item__link__icon svg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                        <g fill="none" fill-rule="nonzero">
                                            <path fill="#EE3023"
                                                  d="M20 10c0 5.523-4.476 10-10 10-5.522 0-10-4.477-10-10S4.478 0 10 0c5.524 0 10 4.477 10 10"/>
                                            <path fill="#FFF"
                                                  d="M9.97 15.861c-2.744.01-5.6-2.383-5.613-6.228-.01-2.541 1.334-4.989 3.049-6.44C9.08 1.777 11.373.868 13.45.86c.268 0 .549.023.72.083-1.818.384-3.264 2.113-3.259 4.073 0 .066.006.135.013.167 3.042.758 4.422 2.633 4.432 5.227.007 2.596-1.998 5.439-5.387 5.45"/>
                                        </g>
                                    </svg>
                                </div>
                                <span class="header__head__contacts__list__item__link__text">+38 (099) 443-80-97</span>
                                <span style="font-size: x-small;">(Для гуртових замовлень)</span>
                            </a>
                            <a href="mailto:zakaz@gstream.com.ua" class="header__head__contacts__list__item__link">
                                <div class="header__head__contacts__list__item__link__icon svg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16">
                                        <path fill="#FFF" fill-rule="nonzero" d="M18 0H2C.9 0 .01.9.01 2L0 14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V2c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V2l8 5 8-5v2z"/>
                                    </svg>
                                </div>
                                <span class="header__head__contacts__list__item__link__text">zakaz@gstream.com.ua</span>
                            </a>
                        </li>
						<li class="header__head__contacts__list__item">
							<?php echo do_shortcode('[gtranslate]');?>
						</li>
                    </ul>
                </div>
            </div>

            <!-- Header Middle part -->
            <div class="header__body">
                <div class="header__body__logo">
                    <a href="<?= home_url( '/' ) ?>" class="header__body__logo__link"></a>
                </div>

                <?php get_search_form();?>

                <div class="header__body__cart">
                    <a href="<?php echo $woocommerce->cart->get_cart_url() ?>" data-toggle="modal" data-target="#cartModal" data-no-folow class="header__body__cart__block">
                        <div class="header__body__cart__block__icon svg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none" fill-rule="evenodd">
                                    <path d="M0 0h24v24H0z"/>
                                    <path fill="#FFF" fill-rule="nonzero"
                                          d="M8 18c-1.1 0-1.99.9-1.99 2S6.9 22 8 22s2-.9 2-2-.9-2-2-2zM2 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H8.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49A1.003 1.003 0 0 0 21 4H6.21l-.94-2H2zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                                </g>
                            </svg>
                        </div>
                        <div class="header__body__cart__block__description">
                            <div class="header__body__cart__block__description__head">Кошик товарів</div>
                            <div class="header__body__cart__block__description__counter"><span class="totalCost"><?php echo $woocommerce->cart->get_cart_contents_count(); ?></span> товарів</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Header Bottom Part -->
            <div class="header__catalog">
                <ul class="header__catalog__list">
                    <!-- NEW: className -->
                    <?php do_action('main_menu'); ?>
                </ul>
            </div>

        </div>
    </header>

    <!-- RESPONSIVE Mobile header -->
    <!-- NEW: className -->
    <header class="mobile-header mobile-header--main-page">
        <div class="custom-container">
            <div class="mobile-header--wrapper">
                <div class="mobile-header__menu">
                    <button class="mobile-header__menu__button svg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44">
                            <g fill="none" fill-rule="evenodd">
                                <path d="M4 4h36v36H4z"/>
                                <g fill="#FFF">
                                    <path d="M7 11.5h30v3H7zM7 20.5h30v3H7zM7 29.5h21v3H7z"/>
                                </g>
                            </g>
                        </svg>
                    </button>
                </div>
                <div class="mobile-header__logo">
                    <a href="<?= home_url( '/' ) ?>" class="mobile-header__logo__link"></a>
                </div>
                <div class="mobile-header__controls">
                    <div class="mobile-header__controls__search">
                        <div class="mobile-header__controls__search__icon svg">
                            <a href="/?page_id=42903">
                                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44">
                                    <g fill="none" fill-rule="evenodd">
                                        <path d="M4 4h36v36H4z"/>
                                        <path fill="#FFF" fill-rule="nonzero" d="M27.25 25h-1.185l-.42-.405A9.707 9.707 0 0 0 28 18.25a9.75 9.75 0 0 0-9.75-9.75 9.75 9.75 0 0 0-9.75 9.75A9.75 9.75 0 0 0 18.25 28a9.707 9.707 0 0 0 6.345-2.355l.405.42v1.185l7.5 7.485 2.235-2.235L27.25 25zm-9 0a6.741 6.741 0 0 1-6.75-6.75 6.741 6.741 0 0 1 6.75-6.75A6.741 6.741 0 0 1 25 18.25 6.741 6.741 0 0 1 18.25 25z"/>
                                    </g>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="mobile-header__controls__cart">
                        <div class="mobile-header__controls__cart__icon svg">
                            <a href="<?php echo WC()->cart->get_cart_url() ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44">
                                    <g fill="none" fill-rule="evenodd">
                                        <path d="M4 4h36v36H4z"/>
                                        <path fill="#FFF" fill-rule="nonzero" d="M16 31a2.996 2.996 0 0 0-2.985 3c0 1.65 1.335 3 2.985 3s3-1.35 3-3-1.35-3-3-3zM7 7v3h3l5.4 11.385-2.025 3.675A2.9 2.9 0 0 0 13 26.5c0 1.65 1.35 3 3 3h18v-3H16.63a.371.371 0 0 1-.375-.375l.045-.18 1.35-2.445h11.175a2.986 2.986 0 0 0 2.625-1.545l5.37-9.735c.12-.21.18-.465.18-.72 0-.825-.675-1.5-1.5-1.5H13.315l-1.41-3H7zm24 24a2.996 2.996 0 0 0-2.985 3c0 1.65 1.335 3 2.985 3s3-1.35 3-3-1.35-3-3-3z"/>
                                    </g>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-header__nav--wrapper">
            <div class="custom-container">
                <div class="mobile-header__nav">
                    <div class="mobile-header__nav__logo">
                        <div class="mobile-header__logo__link"></div>
                    </div>
                    <div class="mobile-header__nav__menu">
                        <?php do_action('top_menu_mobile');?>
                    </div>
                    <div class="mobile-header__nav__close">×</div>
                </div>
            </div>
        </div>
    </header>