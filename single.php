<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

<article class="single-post">
    <!-- Post Header -->
    <section class="post-header py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="post-meta mb-3">
                        <span class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            <?php echo get_the_date(); ?>
                        </span>
                        <span class="text-muted ms-3">
                            <i class="fas fa-folder me-1"></i>
                            <?php the_category(', '); ?>
                        </span>
                        <?php if (get_the_tags()) : ?>
                            <span class="text-muted ms-3">
                                <i class="fas fa-tags me-1"></i>
                                <?php the_tags('', ', '); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <h1 class="display-4 fw-bold mb-4"><?php the_title(); ?></h1>
                    
                    <?php if (get_the_excerpt()) : ?>
                        <p class="lead text-muted"><?php echo get_the_excerpt(); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Image -->
    <?php if (has_post_thumbnail()) : ?>
    <section class="post-featured-image">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php the_post_thumbnail('full', array('class' => 'img-fluid rounded-3 shadow-sm w-100')); ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Post Content -->
    <section class="post-content py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="content-area">
                        <?php the_content(); ?>
                        
                        <?php
                        wp_link_pages(array(
                            'before' => '<div class="page-links mt-4"><span class="page-links-title fw-bold">' . __('Pages:', 'jld-portfolio') . '</span>',
                            'after'  => '</div>',
                            'link_before' => '<span class="page-number">',
                            'link_after'  => '</span>',
                        ));
                        ?>
                    </div>
                    
                    <!-- Post Tags -->
                    <?php if (get_the_tags()) : ?>
                    <div class="post-tags mt-5 pt-4 border-top">
                        <h6 class="fw-bold mb-3">Tags</h6>
                        <div class="tags-list">
                            <?php
                            $tags = get_the_tags();
                            foreach ($tags as $tag) :
                            ?>
                                <a href="<?php echo get_tag_link($tag->term_id); ?>" class="badge bg-light text-dark text-decoration-none me-2 mb-2 p-2">
                                    <?php echo $tag->name; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Author Bio -->
                    <div class="author-bio mt-5 pt-4 border-top">
                        <div class="d-flex align-items-center">
                            <div class="author-avatar me-3">
                                <?php echo get_avatar(get_the_author_meta('ID'), 80, '', '', array('class' => 'rounded-circle')); ?>
                            </div>
                            <div class="author-info">
                                <h6 class="fw-bold mb-1"><?php the_author(); ?></h6>
                                <p class="text-muted mb-0"><?php echo get_the_author_meta('description') ?: 'UX Designer & Digital Strategist'; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Post Navigation -->
    <section class="post-navigation py-4 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <?php
                    $prev_post = get_previous_post();
                    if ($prev_post) :
                    ?>
                    <a href="<?php echo get_permalink($prev_post); ?>" class="text-decoration-none">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-chevron-left text-primary me-3"></i>
                            <div>
                                <small class="text-muted d-block">Previous Post</small>
                                <strong><?php echo get_the_title($prev_post); ?></strong>
                            </div>
                        </div>
                    </a>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 text-md-end">
                    <?php
                    $next_post = get_next_post();
                    if ($next_post) :
                    ?>
                    <a href="<?php echo get_permalink($next_post); ?>" class="text-decoration-none">
                        <div class="d-flex align-items-center justify-content-md-end">
                            <div class="text-md-end me-3">
                                <small class="text-muted d-block">Next Post</small>
                                <strong><?php echo get_the_title($next_post); ?></strong>
                            </div>
                            <i class="fas fa-chevron-right text-primary"></i>
                        </div>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Posts -->
    <?php
    $related_posts = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'rand'
    ));
    
    if ($related_posts->have_posts()) :
    ?>
    <section class="related-posts py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h3 class="fw-bold">Related Posts</h3>
                </div>
            </div>
            <div class="row g-4">
                <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                <div class="col-lg-4">
                    <article class="related-post-card h-100 bg-white rounded-3 shadow-sm overflow-hidden">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', array('class' => 'img-fluid w-100')); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-content p-3">
                            <h5 class="post-title">
                                <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                                    <?php the_title(); ?>
                                </a>
                            </h5>
                            <p class="text-muted small mb-2"><?php echo get_the_date(); ?></p>
                            <p class="text-muted"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                        </div>
                    </article>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
</article>

<?php endwhile; ?>

<?php get_footer(); ?>
