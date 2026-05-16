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

                    <!-- Responsive changes add new list item -->
                    <ul class="header__head__contacts__list">
                        <li class="header__head__contacts__list__item header__head__contacts__list__item--desktop-small">
                            <div class="dropdown show">
                                <a class="header__head__contacts__list__item__link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                    <span class="header__head__contacts__list__item__link__text">+38 (095) 323-82-62</span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a href="" class="header__head__contacts__list__item__link">
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
                                        <span class="header__head__contacts__list__item__link__text">+38 (095) 323-82-62</span>
                                    </a>
                                    <a href="" class="header__head__contacts__list__item__link">
                                        <div class="header__head__contacts__list__item__link__icon svg">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 width="20" height="20" viewBox="0 0 20 20">
                                                <defs>
                                                    <path id="a" d="M0 .081h19.92v19.914H0z"/>
                                                </defs>
                                                <g fill="none" fill-rule="evenodd">
                                                    <mask id="b" fill="#fff">
                                                        <use xlink:href="#a"/>
                                                    </mask>
                                                    <path fill="#F5BB29"
                                                          d="M0 10.04C0 4.54 4.459.082 9.959.082c5.504 0 9.962 4.458 9.962 9.96 0 5.502-4.458 9.959-9.962 9.959-1.086 0-2.13-.174-3.108-.493.708-4.11 3.303-7.463 6.733-8.886a2.213 2.213 0 0 0 3.889-1.448 2.213 2.213 0 0 0-4.427-.004c-4.377 1.316-7.923 4.372-9.724 8.299A9.928 9.928 0 0 1 1.8 15.753c.103-3.824 1.995-7.166 4.828-9.136a2.21 2.21 0 0 0 1.656.745 2.216 2.216 0 0 0 0-4.43 2.214 2.214 0 0 0-2.206 2.404c-2.639.926-4.804 2.757-6.071 5.09A7.98 7.98 0 0 1 0 10.042"
                                                          mask="url(#b)"/>
                                                </g>
                                            </svg>
                                        </div>
                                        <span class="header__head__contacts__list__item__link__text">+38 (093) 860-97-99</span>
                                    </a>
                                </div>
                            </div>
                        </li>

                        <!-- RESPONSIVE add class header__head__contacts__list__item--desktop-large -->
                        <li class="header__head__contacts__list__item header__head__contacts__list__item--desktop-large">
                            <a href="" class="header__head__contacts__list__item__link">
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
                                <span class="header__head__contacts__list__item__link__text">+38 (095) 323-82-62</span>
                            </a>
                        </li>

                        <!-- RESPONSIVE add class header__head__contacts__list__item--desktop-large -->
                        <li class="header__head__contacts__list__item header__head__contacts__list__item--desktop-large">
                            <a href="" class="header__head__contacts__list__item__link">
                                <div class="header__head__contacts__list__item__link__icon svg">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                         width="20" height="20" viewBox="0 0 20 20">
                                        <defs>
                                            <path id="a" d="M0 .081h19.92v19.914H0z"/>
                                        </defs>
                                        <g fill="none" fill-rule="evenodd">
                                            <mask id="b" fill="#fff">
                                                <use xlink:href="#a"/>
                                            </mask>
                                            <path fill="#F5BB29"
                                                  d="M0 10.04C0 4.54 4.459.082 9.959.082c5.504 0 9.962 4.458 9.962 9.96 0 5.502-4.458 9.959-9.962 9.959-1.086 0-2.13-.174-3.108-.493.708-4.11 3.303-7.463 6.733-8.886a2.213 2.213 0 0 0 3.889-1.448 2.213 2.213 0 0 0-4.427-.004c-4.377 1.316-7.923 4.372-9.724 8.299A9.928 9.928 0 0 1 1.8 15.753c.103-3.824 1.995-7.166 4.828-9.136a2.21 2.21 0 0 0 1.656.745 2.216 2.216 0 0 0 0-4.43 2.214 2.214 0 0 0-2.206 2.404c-2.639.926-4.804 2.757-6.071 5.09A7.98 7.98 0 0 1 0 10.042"
                                                  mask="url(#b)"/>
                                        </g>
                                    </svg>
                                </div>
                                <span class="header__head__contacts__list__item__link__text">+38 (093) 860-97-99</span>
                            </a>
                        </li>
                        <li class="header__head__contacts__list__item">
                            <a href="" class="header__head__contacts__list__item__link">
                                <div class="header__head__contacts__list__item__link__icon svg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16">
                                        <path fill="#FFF" fill-rule="nonzero" d="M18 0H2C.9 0 .01.9.01 2L0 14c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V2c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V2l8 5 8-5v2z"/>
                                    </svg>
                                </div>
                                <span class="header__head__contacts__list__item__link__text">zakaz@gstream.com.ua</span>
                            </a>
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
                            <div class="header__body__cart__block__description__head">Корзина товаров</div>
                            <div class="header__body__cart__block__description__counter"><span class="totalCost"><?php echo $woocommerce->cart->get_cart_contents_count(); ?></span> товаров</div>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44">
                                <g fill="none" fill-rule="evenodd">
                                    <path d="M4 4h36v36H4z"/>
                                    <path fill="#FFF" fill-rule="nonzero" d="M27.25 25h-1.185l-.42-.405A9.707 9.707 0 0 0 28 18.25a9.75 9.75 0 0 0-9.75-9.75 9.75 9.75 0 0 0-9.75 9.75A9.75 9.75 0 0 0 18.25 28a9.707 9.707 0 0 0 6.345-2.355l.405.42v1.185l7.5 7.485 2.235-2.235L27.25 25zm-9 0a6.741 6.741 0 0 1-6.75-6.75 6.741 6.741 0 0 1 6.75-6.75A6.741 6.741 0 0 1 25 18.25 6.741 6.741 0 0 1 18.25 25z"/>
                                </g>
                            </svg>
                        </div>
                    </div>
                    <div class="mobile-header__controls__cart">
                        <div class="mobile-header__controls__cart__icon svg">
                            <a href="<?php  echo WC()->cart->get_cart_url() ?>">
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
                    <div class="mobile-header__nav__close">&times;</div>
                </div>
            </div>
        </div>
    </header>