<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package storefront
 */

get_header(); ?>

	<main class="main-content">
		<div class="section">
			<div class="custom-container">
				<div class="section__head section__head--default"></div>
				<div class="section__body">
					<div class="post_my_bg">
						<h1 class="section__head__title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'storefront' ); ?></h1>
					</div>
				</div>
			</div>
		</div>
	</main>

<?php
get_footer();
