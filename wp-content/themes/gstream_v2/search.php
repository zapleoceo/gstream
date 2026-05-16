<?php
/**
 * The template for displaying search results pages.
 *
 * @package storefront
 */

get_header(); ?>

	<main class="main-content">
		<div class="section">
			<div class="custom-container">

		<?php if ( have_posts() ) : ?>


<section class="section">
        <div class="custom-container">
        	<br><br>
        	<?php get_search_form();?>
            <div class="section__head section__head--default">
                <h2 class="section__head__title"><?php
						/* translators: %s: search term */
						printf( esc_attr__( 'Search Results for: %s', 'storefront' ), '<span>' . get_search_query() . '</span>' );
					?></h2>
            
            </div>

            <div class="section__body">
                <div class="search_product_block">
			<?php
			// get_template_part( 'loop' );
			while (have_posts()) {
                            the_post();
                            wc_get_template_part( 'content', 'product' );
                        }

		else :

		?>
			<div class="section__head section__head--default"></div>
				<div class="section__body">
					<div class="post_my_bg">
						<h1 class="section__head__title"><?php esc_html_e( 'Nothing Found', 'storefront' ); ?></h1>
							<?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'storefront' ); ?>
					</div>
				</div>
		<?php

		endif;
		?>
		</div>
            </div>
        </div>
    </section>
		</div>
		</div>
	</main>
<?php my_pagination(); ?>


<style>
	.search_product_block .products-list__item{
		width: 25%;
	    display: block;
	    float: left;
	}
</style>

<?php
// do_action( 'storefront_sidebar' );
get_footer();
