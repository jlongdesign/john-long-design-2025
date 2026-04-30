<?php get_header(); ?>

<section class="page-header py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-4"><?php the_title(); ?></h1>
                <?php if (get_the_excerpt()) : ?>
                    <p class="lead text-muted"><?php echo get_the_excerpt(); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="page-content py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <article class="page-article">
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="content-area">
                            <?php the_content(); ?>
                            
                            <?php
                            wp_link_pages(array(
                                'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'jld-portfolio') . '</span>',
                                'after'  => '</div>',
                                'link_before' => '<span>',
                                'link_after'  => '</span>',
                            ));
                            ?>
                        </div>
                    <?php endwhile; ?>
                </article>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
