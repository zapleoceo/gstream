<?php
/**
 * template name: test
 */

// get_header();
 ?>
<?php echo get_field('url_button_top_products', 'option'); ?>

<?php echo get_field('image_top_products', 'option'); ?>
<br>
<?php while ( have_rows('slider_home', 'option') ) : the_row(); ?>
<?php if(get_sub_field('state')): ?>
<div class="main-banner__slider__item main-banner__slider__item--1" style="background-image: url(<?php echo wp_get_attachment_image_url(get_sub_field('image')); ?>)">
                    <div class="custom-container">
                        <div class="main-banner__slider__item--wrapper">
                            <h3 class="main-banner__slider__item__title"><?= get_sub_field('title') ?></h3>
                            <p class="main-banner__slider__item__description"><?= get_sub_field('description') ?></p>
                            <?php if(get_sub_field('url_button') && get_sub_field('name_button')): ?>
                                <a href="<?= get_sub_field('url_button') ?>" class="main-banner__slider__item__link"><?= get_sub_field('name_button') ?></a>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
<?php endif; ?>
<?php endwhile;?>


<?php
// get_footer();
