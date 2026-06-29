<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <?php
    // Include project sections in order
    get_template_part('partials/project/hero');
    get_template_part('partials/project/overview');
    get_template_part('partials/project/problem');
    get_template_part('partials/project/research');
    get_template_part('partials/project/key-insights');
    get_template_part('partials/project/solution');
    get_template_part('partials/project/gallery');
    get_template_part('partials/project/design-process');
    get_template_part('partials/project/results');
    get_template_part('partials/project/testimonial');
    get_template_part('partials/project/navigation');
    ?>

<?php endwhile; ?>

<?php get_footer(); ?>
