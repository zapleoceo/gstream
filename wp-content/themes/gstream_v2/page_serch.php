<?php
/*
Template Name: Страница с поиском
*/

get_header(); ?>

	<main class="main-content">
		<div class="section">
			<div class="custom-container">

		


	<section class="section">
        <div class="custom-container">
            <div class="section__head section__head--default">
                <h2 class="section__head__title">
                	Поиск
                </h2>            
            </div>
            <div class="section__head section__head--default">
	            <?php get_search_form();?>
	        </div>
	        <div class="section__head section__head--default">
                <h2 class="section__head__title">
                	Возможно вы ищите это:
                </h2>            
            </div>
            <div class="section__body">
                <div class="products-slider" id="specialOffers">

                    <?php

                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 24,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_visibility',
                                'field'    => 'name',
                                'terms'    => 'featured',
                            ),
                        ),
                    );
                    $wc_query = new WP_Query($args);
                    if ($wc_query->have_posts()) {
                        while ($wc_query->have_posts()) {
                            $wc_query->the_post();
                            wc_get_template_part( 'content', 'product' );
                        }
                    }
                    wp_reset_postdata();
                    ?>                
                    
                </div>
            </div>
        </div>
        </div>
    </section>
		</div>
		</div>
	</main>

<?php
// do_action( 'storefront_sidebar' );
get_footer();
