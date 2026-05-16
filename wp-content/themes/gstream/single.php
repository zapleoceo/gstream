<?php
/**
 * The template for displaying all single posts.
 *
 * @package storefront
 */

get_header(); ?>
<main class="main-content">
	<div class="section">
		<div class="custom-container">
			<?php
			while ( have_posts() ) :
				the_post();

			// do_action( 'storefront_single_post_before' );

			// get_template_part( 'content', 'single' );

			// do_action( 'storefront_single_post_after' );
				?>
				<div class="section__head section__head--default">
					<h2 class="section__head__title section__head__title--light"><?php the_title(); ?></h2>
				</div>
				<div class="section__body">
					<div class="section__body__news">
						<div class="post_my_bg">
						<?php the_content(); ?>
					</div>

					</div>
				</div>
				<br>
				<?php
		endwhile; // End of the loop.
		?>
	</div>
</div>
</main>
<?php
// do_action( 'storefront_sidebar' );
get_footer();
