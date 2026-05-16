<?php
get_header(); 

$category = get_queried_object();
?>


    <!-- Main content -->
    <main class="main-content">

        <!-- Section category list -->
        <section class="section">
            <div class="custom-container">
                <div class="section__head section__head--default">
                    <h2 class="section__head__title section__head__title--light"><?= $category->cat_name; ?></h2>
                </div>
                <div class="section__body">
                    <div class="section__body__news">
                        <div class="section__body__news__list flex-wrap">

                            <?php while ( have_posts() ) : the_post(); ?>
                                <a href="<?= get_permalink(); ?>"  class="section__body__news__list__item section__body__news__list__item--news-page">
                                    <div class="section__body__news__list__item__head">
                                        <div class="section__body__news__list__item__head__image"
                                             style="background-image: url(<?= get_the_post_thumbnail_url();?>)"></div>
                                    </div>
                                    <div class="section__body__news__list__item__body">
                                        <h4 class="section__body__news__list__item__body__title"><?php the_title(); ?></h4>
                                        <p class="section__body__news__list__item__body__description">
                                            <?= get_the_excerpt()?>
                                        </p>
                                        <div class="section__body__news__list__item__body__link">Читать дальше
                                            <span class="arrow"></span>
                                        </div>
                                    </div>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php my_pagination(); ?>
    </main>

    
<?php
get_footer();