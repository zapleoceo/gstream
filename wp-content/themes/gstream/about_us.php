<?php
/*
Template Name: О нас
*/
get_header(); 
?>
 
<!-- Main content -->
<main class="main-content">

<!-- Section category list -->
<section class="section">
    <div class="custom-container">
        <div class="section__head section__head--default">
            <h2 class="section__head__title section__head__title--light"><?php the_title(); ?></h2>
        </div>
        <div class="section__body">
            <div class="section__body__about-us">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</section>

</main>

<?php
get_footer();
