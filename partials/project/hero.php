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

$hero_use_gradient  = get_post_meta(get_the_ID(), '_hero_use_gradient', true) === '1';
$hero_gradient_start = get_post_meta(get_the_ID(), '_hero_gradient_start', true) ?: '#f48a4c';
$hero_gradient_end   = get_post_meta(get_the_ID(), '_hero_gradient_end', true) ?: '#3b82f6';
$hero_gradient_angle = get_post_meta(get_the_ID(), '_hero_gradient_angle', true) ?: '135';
?>

<!-- Project Hero -->
<section class="project-hero position-relative">
    <?php if ($hero_use_gradient) : ?>
        <div
            class="hero-image hero-image--gradient"
            style="background: linear-gradient(<?php echo esc_attr($hero_gradient_angle); ?>deg, <?php echo esc_attr($hero_gradient_start); ?>, <?php echo esc_attr($hero_gradient_end); ?>);"
        ></div>
    <?php elseif (has_post_thumbnail()) : ?>
        <div class="hero-image">
            <?php the_post_thumbnail('full', array('class' => 'img-fluid w-100')); ?>
        </div>
    <?php endif; ?>
    <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                        <div class="hero-content pt-3 pb-3">
                        <h1 class="display-3 text-white fw-bold mb-3 mb-md-4"><?php the_title(); ?></h1>
                        <p class="lead text-white mb-0 d-none d-md-block"><?php echo get_the_excerpt(); ?></p>
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