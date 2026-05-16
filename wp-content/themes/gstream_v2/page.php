<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package storefront
 */

get_header(); ?>
<br>
<section class="section">
    <div class="custom-container">
        <div class="section__head section__head--default">
            <h2 class="section__head__title section__head__title--light"><?php the_title(); ?></h2>
        </div>
        <div class="section__body">
            <div class="section_body_page" style="background: #fff; padding: 30px; position: relative; width: 100%;">
				
				<div class="section__body__contacts__info__item__body__item">

		<?php
			while ( have_posts() ) :
				the_post();

				//do_action( 'storefront_page_before' );

				the_content();

			endwhile; // End of the loop.
		?>
		</div>
            </div>
        </div>
        <style>
             .section_body_page {    
                background: #fff;
                padding: 30px;
                position: relative;
                width: 100%;
            }
            .section_body_page ul li {list-style: disc;}
            .section_body_page ul {margin-left: 30px;}
        </style>
    </div>
</section>

</main>
<?php
// do_action( 'storefront_sidebar' );
get_footer();
