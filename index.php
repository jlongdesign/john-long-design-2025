<?php
/**
 * The main template file
 */

get_header(); ?>

<div class="container py-5">
    <?php if (have_posts()) : ?>
        <div class="row">
            <?php while (have_posts()) : the_post(); ?>
                <div class="col-12 mb-4">
                    <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
                        <div class="card-body">
                            <h2 class="card-title">
                                <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <div class="card-text">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn btn-primary">Read More</a>
                        </div>
                    </article>
                </div>
            <?php endwhile; ?>
        </div>
        
        <?php the_posts_pagination(); ?>
        
    <?php else : ?>
        <div class="row">
            <div class="col-12">
                <h1>Nothing Found</h1>
                <p>Sorry, no posts matched your criteria.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>