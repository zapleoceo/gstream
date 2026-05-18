<?php
/*
Template Name: Главная страница сайта
*/

get_header(); 
?>

<!-- Main content -->
<main class="main-content">

    <!-- Banner section -->
    <section class="main-banner">
        <div class="main-banner__slider">
            <?php while ( have_rows('slider_home', 'option') ) : the_row(); ?>
                <?php if(get_sub_field('state')): ?>
                    <div class="main-banner__slider__item main-banner__slider__item--1" style="background-image: url(<?php echo wp_get_attachment_image_url(get_sub_field('image'),'full'); ?>)">
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

        </div>
        <div class="main-banner__slick-controls--wrapper">
            <div class="custom-container">
                <div class="main-banner__slick-controls">
                    <div class="main-banner__slick-prev"></div>
                    <div class="main-banner__slick-next"></div>
                </div>
            </div>
        </div>
    </section>


    <!-- Section popular products -->
    <section class="section">
        <div class="custom-container">
            <div class="section__head section__head--default">
                <h2 class="section__head__title">Популярні товари</h2>
                <div class="section__head__controls">
                    <!-- Slider controls-->
                    <div class="section__head__controls__slider">
                        <div class="section__head__controls__slider__prev" id="popularProductsPrev"></div>
                        <div class="section__head__controls__slider__next" id="popularProductsNext"></div>
                    </div>
                </div>
            </div>
            <div class="section__body">
                <div class="products-slider products-slider--with-banner" id="popularProducts">

                    <?php

                    $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => 12,
                        'orderby' => 'meta_value_num',
                        'meta_query'     => array(
                        array( // Simple products type
                            'key'           => 'total_sales',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
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
                <div class="section__body__banner">
                    <div class="mini-banner mini-banner--popular-products" style="background-size: cover;background-image: url(<?php echo wp_get_attachment_image_url(get_field('image_top_products', 'option'),'full'); ?>);">
                        <!-- <div class="mini-banner__logo svg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="158" height="64" viewBox="0 0 158 64">
                                <path fill="#fff" fill-rule="evenodd"
                                d="M54.905 32.957h-7.416v-2.276c0-1.063-.095-1.736-.284-2.031-.189-.29-.506-.434-.945-.434-.479 0-.846.194-1.09.59-.246.395-.368.985-.368 1.786 0 1.024.139 1.798.417 2.315.267.518 1.018 1.147 2.253 1.876 3.555 2.109 5.792 3.84 6.715 5.192.924 1.352 1.386 3.534 1.386 6.545 0 2.187-.256 3.8-.768 4.836-.512 1.035-1.502 1.909-2.965 2.61a10.45 10.45 0 0 1-2.376.79c-3.366 4.859-10.153 9.428-23.522 8.977-7.049-.24-13.319-3.6-17.09-7.29C1.401 49.151-.3 38.293.183 29.784c.239-4.152 1.351-11.72 6.158-18.337C10.554 5.648 17.413.45 28.284.45 52.908.45 54.35 21.682 54.35 21.682l-14.866.017s-1.307-8.765-10.359-8.715c-4.8.027-8.284 1.486-9.741 5.86-1.002 3-.924 7.507-.924 14.269 0 5.131-.395 9.06.518 11.576 1.702 4.697 5.14 6.277 8.044 6.6 4.056.45 7.105-2.065 7.105-2.065L20.568 37.615l18.504-.016c-.423-.524-.79-1.164-1.102-1.932-.423-1.051-.634-2.387-.634-4.023 0-2.354.3-4.074.901-5.16.601-1.084 1.569-1.936 2.91-2.548 1.34-.612 2.96-.918 4.857-.918 2.075 0 3.838.334 5.301 1.007 1.458.668 2.426 1.514 2.899 2.532.473 1.019.712 2.75.712 5.187v1.213h-.011zm-8.579 22.055c-1.97-.044-3.666-.45-5.08-1.207-1.512-.807-2.497-1.843-2.964-3.09-.468-1.251-.701-3.027-.701-5.33v-2.01h7.416v3.735c0 1.152.105 1.892.311 2.22.212.328.579.495 1.107.495.529 0 .924-.211 1.185-.623.256-.417.39-1.035.39-1.859 0-1.808-.245-2.988-.74-3.545-.506-.556-1.753-1.486-3.733-2.788-.607-.4-1.152-.768-1.63-1.102l-15.105.017 10.921 9.35-2.114 1.741c-.328.273-3.327 2.644-7.583 2.644-.412 0-.823-.022-1.235-.067-2.732-.3-7.655-1.759-9.947-8.103-.83-2.298-.774-5.181-.701-8.832.022-1.124.044-2.282.044-3.528v-1.353c-.005-6.322-.01-10.496 1.04-13.646 1.658-4.964 5.553-7.396 11.906-7.43h.09c7.298 0 10.814 4.943 12.072 8.71l10.37-.01C50.432 14.224 45.77 2.765 28.29 2.765c-8.49 0-15.244 3.378-20.084 10.045-4.479 6.172-5.508 13.373-5.725 17.119-.278 4.864-.055 17.018 7.978 24.882 3.127 3.06 8.857 6.411 15.56 6.64.585.016 1.17.027 1.737.027 8.206 0 14.348-2.054 18.248-6.1.105-.133.211-.25.322-.367zm106.75-34.265v-6.01h.89v.857c.429-.663 1.046-.99 1.853-.99.35 0 .673.066.968.194.295.128.512.3.662.512.145.211.25.462.306.751.04.19.056.518.056.99v3.696h-.985v-3.656c0-.418-.039-.724-.117-.93a1.005 1.005 0 0 0-.406-.495 1.264 1.264 0 0 0-.69-.184c-.423 0-.784.14-1.09.412-.306.279-.456.796-.456 1.57v3.283h-.99zm-2.53-3.016c-.357.15-.897.278-1.614.384-.406.061-.69.128-.863.206a.85.85 0 0 0-.39.334.91.91 0 0 0-.138.484c0 .272.1.5.3.679.2.183.49.272.874.272a1.97 1.97 0 0 0 1.012-.256c.295-.172.512-.406.651-.706.106-.229.162-.568.162-1.019v-.378h.005zm.083 2.276c-.368.323-.718.545-1.058.679-.339.133-.7.2-1.09.2-.64 0-1.13-.161-1.474-.484-.345-.323-.518-.735-.518-1.235 0-.295.067-.562.195-.807s.3-.44.512-.585c.211-.144.445-.256.706-.334.195-.055.484-.105.88-.15.795-.1 1.385-.217 1.758-.35.005-.14.005-.229.005-.268 0-.417-.095-.706-.278-.879-.25-.228-.629-.345-1.124-.345-.462 0-.807.084-1.03.25-.222.167-.383.468-.489.89l-.962-.133c.089-.428.233-.773.434-1.035.2-.261.49-.462.873-.606a3.81 3.81 0 0 1 1.319-.212c.495 0 .901.061 1.213.184.311.122.54.272.684.456.145.184.25.412.306.696.033.172.05.484.05.94v1.358c0 .946.022 1.547.061 1.798.045.25.128.49.25.723h-1.029a2.364 2.364 0 0 1-.194-.751zm-13.152.74v-6.01h.884v.846a2.019 2.019 0 0 1 1.764-.98c.428 0 .784.095 1.062.278.279.184.473.446.585.774.461-.701 1.057-1.052 1.797-1.052.578 0 1.018.167 1.33.495.31.329.467.84.467 1.525v4.124h-.98v-3.784c0-.406-.033-.701-.094-.88a.831.831 0 0 0-.35-.434 1.043 1.043 0 0 0-.59-.161c-.407 0-.751.14-1.018.423-.273.284-.407.729-.407 1.352v3.495h-.984v-3.907c0-.45-.084-.79-.24-1.018-.16-.228-.422-.34-.79-.34-.278 0-.534.078-.767.229-.234.15-.406.373-.512.662-.106.29-.161.712-.161 1.258v3.116h-.996v-.01zm-3.744 0v-6.01h.89v.912c.228-.428.434-.706.628-.846.19-.133.4-.205.635-.205.333 0 .673.11 1.012.328l-.34.946a1.404 1.404 0 0 0-.723-.223.903.903 0 0 0-.578.2 1.07 1.07 0 0 0-.367.557 4.03 4.03 0 0 0-.162 1.191v3.15h-.995zm-5.492-3.584h3.25c-.045-.506-.167-.885-.373-1.135a1.502 1.502 0 0 0-1.224-.59c-.456 0-.835.156-1.14.467-.307.318-.48.735-.513 1.258zm3.244 1.647l1.018.128c-.161.618-.456 1.091-.896 1.43-.434.34-.99.513-1.663.513-.851 0-1.524-.273-2.025-.813-.5-.54-.751-1.302-.751-2.276 0-1.013.25-1.798.756-2.354.507-.557 1.158-.84 1.964-.84.78 0 1.413.272 1.908.818.496.545.74 1.319.74 2.31 0 .06 0 .15-.005.272h-4.34c.04.662.217 1.169.54 1.52.328.35.729.528 1.218.528.362 0 .674-.1.93-.295.25-.195.456-.512.606-.94zm-10.231 1.937V12.45h.985v2.978c.461-.551 1.04-.83 1.74-.83.43 0 .808.09 1.125.262.317.178.545.418.684.73.14.31.206.756.206 1.346v3.812h-.985v-3.812c0-.512-.106-.88-.323-1.113-.21-.234-.517-.35-.906-.35-.295 0-.568.077-.824.233-.256.156-.44.367-.55.634-.112.268-.162.64-.162 1.108v3.289h-.99v.011zm-6.009-1.792l.974-.156c.056.407.206.713.456.93.25.217.601.322 1.052.322.45 0 .79-.094 1.007-.283.217-.19.328-.412.328-.674a.628.628 0 0 0-.29-.545c-.133-.09-.472-.206-1.006-.345-.724-.19-1.224-.35-1.502-.49a1.48 1.48 0 0 1-.635-.573 1.553 1.553 0 0 1-.217-.807 1.62 1.62 0 0 1 .662-1.313c.156-.117.362-.218.629-.295.267-.084.55-.123.851-.123.456 0 .857.067 1.202.206.345.134.6.317.762.551.167.234.278.545.34.93l-.963.133c-.045-.312-.172-.551-.384-.724-.211-.172-.506-.261-.89-.261-.45 0-.779.078-.968.234-.195.155-.29.334-.29.545 0 .134.04.25.123.356.078.112.206.2.378.273.1.039.39.122.874.261.7.195 1.185.351 1.463.474.278.122.49.3.65.534.157.234.235.523.235.874 0 .339-.095.662-.29.957-.194.3-.467.534-.829.695a2.993 2.993 0 0 1-1.23.245c-.756 0-1.334-.161-1.73-.484-.394-.328-.65-.812-.762-1.447zm-2.091 1.792v-6.01h.984v6.01h-.984zm0-7.129v-1.174h.984v1.174h-.984zm-2.888 7.13v-5.221h-.873v-.79h.873v-.64c0-.407.034-.702.106-.902.094-.261.261-.478.5-.64.24-.161.574-.245 1.008-.245.278 0 .584.034.918.1l-.15.89a3.077 3.077 0 0 0-.58-.055c-.3 0-.511.067-.633.2-.123.134-.184.379-.184.74v.557h1.13v.79h-1.136v5.22h-.979v-.005zm-5.87 0v-8.299h.986v8.298h-.985zm-2.508-3.017c-.356.15-.896.278-1.614.384-.406.061-.69.128-.862.206a.85.85 0 0 0-.39.334.91.91 0 0 0-.138.484c0 .272.1.5.3.679.2.183.49.272.873.272a1.97 1.97 0 0 0 1.013-.256c.295-.172.512-.406.65-.706.107-.229.162-.568.162-1.019v-.378h.006zm.083 2.276c-.367.323-.717.545-1.057.679-.34.133-.7.2-1.09.2-.64 0-1.13-.161-1.475-.484-.344-.323-.517-.735-.517-1.235 0-.295.067-.562.195-.807s.3-.44.512-.585c.211-.144.445-.256.712-.334.194-.055.484-.105.879-.15.795-.1 1.385-.217 1.758-.35.005-.14.005-.229.005-.268 0-.417-.094-.706-.278-.879-.25-.228-.629-.345-1.124-.345-.461 0-.806.084-1.029.25-.222.167-.384.468-.49.89l-.962-.133c.09-.428.234-.773.434-1.035.2-.261.49-.462.873-.606a3.81 3.81 0 0 1 1.319-.212c.495 0 .901.061 1.213.184.311.122.54.272.684.456.145.184.25.412.306.696.033.172.05.484.05.94v1.358c0 .946.022 1.547.061 1.798.045.25.128.49.25.723h-1.029a2.228 2.228 0 0 1-.2-.751zm-9.296-2.844h3.249c-.045-.506-.167-.885-.373-1.135a1.502 1.502 0 0 0-1.224-.59c-.456 0-.834.156-1.146.467-.3.318-.473.735-.506 1.258zm3.238 1.647l1.018.128c-.162.618-.456 1.091-.896 1.43-.434.34-.99.513-1.669.513-.851 0-1.524-.273-2.025-.813-.5-.54-.751-1.302-.751-2.276 0-1.013.25-1.798.757-2.354.506-.557 1.157-.84 1.963-.84.78 0 1.414.272 1.909.818.495.545.74 1.319.74 2.31 0 .06 0 .15-.006.272h-4.34c.04.662.218 1.169.546 1.52.328.35.729.528 1.218.528.362 0 .668-.1.924-.295.261-.195.461-.512.612-.94zm-7.733 1.937v-6.01h.89v.912c.228-.428.434-.706.628-.846.19-.133.4-.205.635-.205.333 0 .667.11 1.012.328l-.34.946a1.404 1.404 0 0 0-.722-.223.93.93 0 0 0-.585.2 1.07 1.07 0 0 0-.367.557 4.027 4.027 0 0 0-.167 1.191v3.15h-.984zm-5.636-3.016c-.356.15-.896.278-1.614.384-.406.061-.69.128-.862.206a.879.879 0 0 0-.528.818c0 .272.1.5.3.679.2.183.49.272.874.272a1.97 1.97 0 0 0 1.012-.256c.295-.172.512-.406.651-.706.106-.229.161-.568.161-1.019v-.378h.006zm.083 2.276c-.367.323-.717.545-1.057.679-.34.133-.7.2-1.09.2-.64 0-1.13-.161-1.474-.484-.345-.323-.518-.735-.518-1.235 0-.295.067-.562.195-.807s.3-.44.512-.585c.211-.144.445-.256.712-.334.195-.055.484-.105.879-.15.795-.1 1.385-.217 1.758-.35.005-.14.005-.229.005-.268 0-.417-.094-.706-.278-.879-.25-.228-.628-.345-1.124-.345-.461 0-.806.084-1.029.25-.222.167-.384.468-.49.89l-.962-.133c.09-.428.234-.773.434-1.035.2-.261.49-.462.874-.606a3.81 3.81 0 0 1 1.318-.212c.495 0 .901.061 1.213.184.311.122.54.272.684.456.145.184.25.412.306.696.034.172.05.484.05.94v1.358c0 .946.023 1.547.061 1.798.045.25.123.49.25.723h-1.028a2.228 2.228 0 0 1-.2-.751zM70.21 17.163h3.249c-.045-.506-.167-.885-.373-1.135a1.51 1.51 0 0 0-1.224-.59c-.45 0-.834.156-1.14.467-.306.318-.479.735-.512 1.258zm3.243 1.647l1.018.128c-.16.618-.456 1.091-.895 1.43-.434.34-.99.513-1.67.513-.85 0-1.524-.273-2.024-.813-.501-.54-.751-1.302-.751-2.276 0-1.013.25-1.798.756-2.354.506-.557 1.157-.84 1.964-.84.779 0 1.413.272 1.908.818.495.545.74 1.319.74 2.31 0 .06 0 .15-.005.272h-4.34c.04.662.217 1.169.54 1.52.328.35.729.528 1.218.528.362 0 .668-.1.93-.295.255-.195.461-.512.611-.94zm-10.325.958h2.002c.345 0 .585-.011.724-.04.245-.044.45-.122.612-.227.167-.106.3-.262.406-.462.106-.2.161-.434.161-.702 0-.311-.078-.578-.228-.807a1.186 1.186 0 0 0-.64-.478c-.272-.095-.662-.14-1.174-.14h-1.858v2.856h-.005zm0-3.835h1.735c.473 0 .813-.033 1.013-.094.273-.084.473-.223.612-.412.139-.195.206-.434.206-.724a1.37 1.37 0 0 0-.19-.729.967.967 0 0 0-.55-.428c-.24-.078-.645-.117-1.224-.117h-1.608v2.504h.006zm-1.068 4.814V12.45h3.015c.612 0 1.107.084 1.48.25.372.168.662.43.873.774.212.351.317.713.317 1.097 0 .356-.094.69-.278 1.001-.189.312-.467.568-.846.757.484.145.863.401 1.124.752.262.356.395.773.395 1.257 0 .39-.078.752-.239 1.086-.161.334-.356.59-.59.773-.233.184-.528.317-.879.412-.35.095-.784.14-1.296.14H62.06zm95.311 2.916v30.71h-6.976l-.011-20.731-2.776 20.73h-4.952l-2.932-20.257-.01 20.257h-6.972V23.663h10.331c.306 1.848.624 4.024.946 6.528l1.135 7.814 1.836-14.342h10.381zM122.59 43.41c-.406-3.479-.812-7.775-1.218-12.9-.813 5.882-1.324 10.178-1.53 12.9h2.748zm4.228-19.746l4.568 30.71h-8.156l-.429-5.522h-2.854l-.478 5.521h-8.256l4.072-30.709h11.533zm-29.93 0h13.312v6.144h-5.33v5.822h4.986v5.843h-4.985v6.75h5.858v6.145H96.886V23.663zM83.95 28.917v6.828c.896 0 1.525-.122 1.886-.367.362-.245.54-1.046.54-2.399v-1.686c0-.974-.172-1.614-.523-1.914-.345-.312-.98-.462-1.903-.462zm-7.983-5.254h5.652c3.767 0 6.315.145 7.65.434 1.335.29 2.42 1.036 3.26 2.226.84 1.197 1.263 3.1 1.263 5.722 0 2.387-.295 3.995-.89 4.819-.595.824-1.764 1.313-3.505 1.48 1.58.39 2.643.919 3.188 1.575.545.657.879 1.264 1.012 1.815.134.55.2 2.064.2 4.54v8.098h-7.415V44.166c0-1.642-.128-2.66-.39-3.056-.261-.39-.94-.59-2.036-.59v13.847h-7.983V23.663h-.006zm-1.82 0v6.144h-4.74v24.565h-7.983V29.807h-4.723v-6.144h17.447z"/>
                            </svg>
                        </div>
                        <p class="mini-banner__text">
                            Украинская торговая марка,
                            которая предлагает всем любителям рыбной
                            ловли качественную рыболовную прикормку
                            и арамотические добавки к ней
                        </p> -->
                        <div class="mini-banner__footer">
                            <a href="<?php echo get_field('url_button_top_products', 'option'); ?>" class="mini-banner__button mini-banner__button--1">
                                <span><?php echo get_field('name_button_top_products', 'option'); ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Section new products -->
    <section class="section">
        <div class="custom-container">
            <div class="section__head section__head--default">
                <h2 class="section__head__title">Нові надходження</h2>
                <div class="section__head__controls">
                    <!-- Slider controls-->
                    <div class="section__head__controls__slider">
                        <div class="section__head__controls__slider__prev" id="newProductsPrev"></div>
                        <div class="section__head__controls__slider__next" id="newProductsNext"></div>
                    </div>
                </div>
            </div>
            <div class="section__body">
                <div class="section__body__banner">
                    <div class="mini-banner mini-banner--popular-products" style="background-size: cover;background-image: url(<?php echo wp_get_attachment_image_url(get_field('image_new_products', 'option'),'full'); ?>);">
                        <div class="mini-banner__footer">
                            <a href="<?php echo get_field('url_button_new_products', 'option'); ?>" class="mini-banner__button mini-banner__button--1">
                                <span><?php echo get_field('name_button_new_products', 'option'); ?></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="products-slider products-slider--with-banner" id="newProducts">

                    <?php

                    $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => 12,
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'meta_query' => array(
                            array(
                                'key' => '_thumbnail_id'
                            )
                        )
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
    </section>


    <!-- Section special offers products -->
    <section class="section">
        <div class="custom-container">
            <div class="section__head section__head--default">
                <h2 class="section__head__title">Наші спецпропозиції</h2>
                <div class="section__head__controls">
                    <!-- Slider controls-->
                    <div class="section__head__controls__slider">
                        <div class="section__head__controls__slider__prev" id="specialOffersPrev"></div>
                        <div class="section__head__controls__slider__next" id="specialOffersNext"></div>
                    </div>
                </div>
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
    </section>


    <!-- Section Delivery ways-->
    <?php if(get_field('our_achievements', 'option')): ?>
        <section class="section">
            <div class="custom-container">
                <div class="section__head section__head--centered">
                    <h2 class="section__head__title">Наші досягненння</h2>
                </div>

                <div class="section__body ourAchievementsBlock">
                    <div class="products-slider" id="ourAchievements">
                        <?php foreach(get_field('our_achievements', 'option') as $img): ?>
                            <div class="ourAchievementsSlide">
                                <img src="<?= $img['url'] ?>" alt="<?= $img['title'] ?>" title="<?= $img['title'] ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
<!-- <section class="section">
    <div class="custom-container">
        <div class="section__head section__head--centered">
            <h2 class="section__head__title">Службы доставки</h2>
        </div>

        <div class="section__body">
            <div class="section__body__delivery">
                <ul class="section__body__delivery__list">
                    <li class="section__body__delivery__list__item">
                        <img srcset="<?php // get_template_directory_uri()?>/static/delivery_way_1.png, <?php // get_template_directory_uri()?>/static/delivery_way_1@2x.png 2x"
                             src="<?php // get_template_directory_uri()?>/static/delivery_way_1.png"
                             alt="Meest"
                             title="Meest">
                    </li>
                    <li class="section__body__delivery__list__item">
                        <img srcset="<?php // get_template_directory_uri()?>/static/delivery_way_2.png, <?php // get_template_directory_uri()?>/static/delivery_way_2@2x.png 2x"
                             src="<?php // get_template_directory_uri()?>/static/delivery_way_2.png"
                             alt="GUNSEL"
                             title="GUNSEL">
                    </li>
                    <li class="section__body__delivery__list__item">
                        <img srcset="<?php // get_template_directory_uri()?>/static/delivery_way_3.png, <?php // get_template_directory_uri()?>/static/delivery_way_3@2x.png 2x"
                             src="<?php // get_template_directory_uri()?>/static/delivery_way_3.png"
                             alt="Новая почта"
                             title="Новая почта">
                    </li>
                    <li class="section__body__delivery__list__item">
                        <img srcset="<?php // get_template_directory_uri()?>/static/delivery_way_4.png, <?php // get_template_directory_uri()?>/static/delivery_way_4@2x.png 2x"
                             src="<?php // get_template_directory_uri()?>/static/delivery_way_4.png"
                             alt="IН тайм"
                             title="IН тайм">
                    </li>
                    <li class="section__body__delivery__list__item">
                        <img srcset="<?php // get_template_directory_uri()?>/static/delivery_way_5.png, <?php // get_template_directory_uri()?>/static/delivery_way_5@2x.png 2x"
                             src="<?php // get_template_directory_uri()?>/static/delivery_way_5.png"
                             alt="Delivery GROUP"
                             title="Delivery GROUP">
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section> -->

<br>
<!-- Section News -->
<section class="section">
    <div class="custom-container">
        <div class="section__head section__head--default">
            <h2 class="section__head__title">Новинний блог</h2>
            <div class="section__head__controls">
                <a href="./?cat=192" class="section__head__controls__link">Дивитись все</a>
            </div>
        </div>

        <div class="section__body">
            <div class="section__body__news">
                <div class="section__body__news__list flex-wrap">
                    

                    <?php if ( have_posts() ) : query_posts('cat=192&posts_per_page=4');  
                        while (have_posts()) : the_post();  ?> 
                            
                            <!-- News item 1 -->
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
                                    <div class="section__body__news__list__item__body__link">Читати далі
                                        <span class="arrow"></span>
                                    </div>
                                </div>
                            </a>

                        <?php  endwhile;  
                        wp_reset_query(); 
                    endif;?>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Section Videos -->
<section class="section">
    <div class="custom-container">
        <div class="section__head section__head--default">
            <h2 class="section__head__title">Наш Youtube канал</h2>
            <div class="section__head__controls">
                <a href="./?cat=2071" class="section__head__controls__link">Смотреть все</a>
            </div>
        </div>

        <div class="section__body">
            <div class="section__body__video">
                <ul class="section__body__video__list">
                    <!-- News item 1 -->

                    <?php if ( have_posts() ) : query_posts('cat=2071&posts_per_page=4');  
                        while (have_posts()) : the_post();  ?>        
                    <li class="section__body__video__list__item">
                        <div class="section__body__video__list__item__head">
                            <div class="section__body__video__list__item__head__image"
                            style="background-image: url(<?= get_the_post_thumbnail_url();?>)"></div>
                            <a href="<?= get_permalink(); ?>" class="section__body__video__list__item__head__button"></a>
                        </div>
                        <div class="section__body__video__list__item__body">
                            <h4 class="section__body__video__list__item__body__title"><?php the_title(); ?></h4>
                            <p class="section__body__video__list__item__body__description">
                               <!--  4,2 тыс.просмотров
                                <br>
                                2 недели назад -->
                            </p>
                        </div>
                    </li>

                    <?php  endwhile;  
                        wp_reset_query(); 
                    endif;?>

                </ul>
            </div>
        </div>
    </div>
</section>
</main>

<?php
get_footer();
