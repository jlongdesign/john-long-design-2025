<?php get_header(); ?>

<section class="page-header py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-4">My Projects</h1>
                <p class="lead text-muted">A collection of case studies showcasing my design process and problem-solving approach</p>
            </div>
        </div>
    </div>
</section>

<section class="projects-grid py-5">
    <div class="container">
        <div class="row g-4">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                <div class="col-lg-6 col-md-6">
                    <article class="project-card h-100 border-0 shadow-sm overflow-hidden rounded-3">
                        <div class="project-image position-relative">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('project-hero', array('class' => 'card-img-top')); ?>
                                </a>
                            <?php endif; ?>
                            <div class="project-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                <a href="<?php the_permalink(); ?>" class="btn btn-light btn-sm">View Case Study</a>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <h3 class="card-title fw-bold h4">
                                <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark"><?php the_title(); ?></a>
                            </h3>
                            <p class="card-text text-muted mb-3"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                            
                            <div class="project-meta">
                                <div class="row g-2">
                                    <?php $client = get_post_meta(get_the_ID(), '_project_client', true); ?>
                                    <?php if ($client) : ?>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Client</small>
                                        <small class="text-primary fw-semibold"><?php echo esc_html($client); ?></small>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php $role = get_post_meta(get_the_ID(), '_project_role', true); ?>
                                    <?php if ($role) : ?>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Role</small>
                                        <small class="text-primary fw-semibold"><?php echo esc_html($role); ?></small>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="col-12 text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h3 class="text-muted">No projects found</h3>
                    <p class="text-muted">Check back soon for new case studies and projects.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <?php
        // Pagination
        the_posts_pagination(array(
            'mid_size' => 2,
            'prev_text' => '<i class="fas fa-chevron-left"></i> Previous',
            'next_text' => 'Next <i class="fas fa-chevron-right"></i>',
            'class' => 'mt-5',
        ));
        ?>
    </div>
</section>

<?php get_footer(); ?>
