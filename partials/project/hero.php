<?php
/**
 * Project Hero Section
 */

// Get hero meta data
$hero_image = get_post_meta(get_the_ID(), '_project_hero_image', true);
$project_client = get_post_meta(get_the_ID(), '_project_client', true);
$project_role = get_post_meta(get_the_ID(), '_project_role', true);
$project_duration = get_post_meta(get_the_ID(), '_project_duration', true);
$project_url = get_post_meta(get_the_ID(), '_project_url', true);
?>

<!-- Project Hero -->
<section class="project-hero position-relative">
    <?php if (has_post_thumbnail()) : ?>
        <div class="hero-image">
            <?php the_post_thumbnail('full', array('class' => 'img-fluid w-100')); ?>
        </div>
    <?php endif; ?>
    <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-end">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="hero-content p-5">
                        <h1 class="display-3 text-white fw-bold mb-4"><?php the_title(); ?></h1>
                        <p class="lead text-white mb-0"><?php echo get_the_excerpt(); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Project Meta -->
<section class="project-meta py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-6 mb-3">
                <h6 class="text-muted mb-1">Client</h6>
                <p class="fw-semibold mb-0"><?php echo esc_html(get_post_meta(get_the_ID(), '_project_client', true) ?: 'Confidential'); ?></p>
            </div>
            <div class="col-lg-3 col-6 mb-3">
                <h6 class="text-muted mb-1">Role</h6>
                <p class="fw-semibold mb-0"><?php echo esc_html(get_post_meta(get_the_ID(), '_project_role', true) ?: 'UX Designer'); ?></p>
            </div>
            <div class="col-lg-3 col-6 mb-3">
                <h6 class="text-muted mb-1">Duration</h6>
                <p class="fw-semibold mb-0"><?php echo esc_html(get_post_meta(get_the_ID(), '_project_duration', true) ?: '3 months'); ?></p>
            </div>
            <div class="col-lg-3 col-6 mb-3">
                <h6 class="text-muted mb-1">Live Project</h6>
                <?php $project_url = get_post_meta(get_the_ID(), '_project_url', true); ?>
                <?php if ($project_url) : ?>
                    <a href="<?php echo esc_url($project_url); ?>" target="_blank" class="btn btn-sm btn-primary">
                        <i class="fas fa-external-link-alt me-1"></i> View Live
                    </a>
                <?php else : ?>
                    <p class="fw-semibold mb-0 text-muted">Coming Soon</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>