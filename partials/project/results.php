<?php
/**
 * Project Results Section
 */
$results_title = get_post_meta(get_the_ID(), '_results_title', true);
$results_intro = get_post_meta(get_the_ID(), '_results_intro', true);
$results_point_1_percentage = get_post_meta(get_the_ID(), '_results_point_1_percentage', true);
$results_point_1_title = get_post_meta(get_the_ID(), '_results_point_1_title', true);
$results_point_1_description = get_post_meta(get_the_ID(), '_results_point_1_description', true);
$results_point_2_percentage = get_post_meta(get_the_ID(), '_results_point_2_percentage', true);
$results_point_2_title = get_post_meta(get_the_ID(), '_results_point_2_title', true);
$results_point_2_description = get_post_meta(get_the_ID(), '_results_point_2_description', true);
$results_point_3_percentage = get_post_meta(get_the_ID(), '_results_point_3_percentage', true);
$results_point_3_title = get_post_meta(get_the_ID(), '_results_point_3_title', true);
$results_point_3_description = get_post_meta(get_the_ID(), '_results_point_3_description', true);
$results_point_4_percentage = get_post_meta(get_the_ID(), '_results_point_4_percentage', true);
$results_point_4_title = get_post_meta(get_the_ID(), '_results_point_4_title', true);
$results_point_4_description = get_post_meta(get_the_ID(), '_results_point_4_description', true);

// Only show section if content exists
if ($results_intro || $results_point_1_title || $results_point_2_title || $results_point_3_title || $results_point_4_title) :
?>

<!-- Results Section -->
<section class="results-section py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold mb-4"><?php echo esc_html($results_title) ?: 'Results & Impact'; ?></h2>
                <div class="lead text-muted"><?php echo wpautop($results_intro) ?: 'Measuring the success of our design solutions'; ?></div>
            </div>
        </div>

        <div class="row g-4 text-center">
            <?php if ($results_point_1_title || $results_point_1_description) : ?>
                <div class="col-lg-3 col-md-6">
                    <div class="result-stat">
                        <div class="stat-number text-primary fw-bold display-3 mb-2"><?php echo esc_html($results_point_1_percentage) ?: '42%'; ?></div>
                        <h6 class="fw-bold text-uppercase"><?php echo esc_html($results_point_1_title) ?: 'Increase in Conversions'; ?></h6>
                        <p class="text-muted small"><?php echo esc_html($results_point_1_description) ?: 'More users completing their goals'; ?></p>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($results_point_2_title || $results_point_2_description) : ?>
            <div class="col-lg-3 col-md-6">
                <div class="result-stat">
                    <div class="stat-number text-success fw-bold display-3 mb-2"><?php echo esc_html($results_point_2_percentage) ?: '58%'; ?></div>
                    <h6 class="fw-bold text-uppercase"><?php echo esc_html($results_point_2_title) ?: 'Faster Task Completion'; ?></h6>
                    <p class="text-muted small"><?php echo esc_html($results_point_2_description) ?: 'Users finding what they need quicker'; ?></p>
                </div>
            </div>
            <?php endif; ?>
            <?php if ($results_point_3_title || $results_point_3_description) : ?>
            <div class="col-lg-3 col-md-6">
                <div class="result-stat">
                    <div class="stat-number text-info fw-bold display-3 mb-2"><?php echo esc_html($results_point_3_percentage) ?: '73%'; ?></div>
                    <h6 class="fw-bold text-uppercase"><?php echo esc_html($results_point_3_title) ?: 'User Satisfaction Score'; ?></h6>
                    <p class="text-muted small"><?php echo esc_html($results_point_3_description) ?: 'Based on post-launch surveys'; ?></p>
                </div>
            </div>
            <?php endif; ?>
            <?php if ($results_point_4_title || $results_point_4_description) : ?>
            <div class="col-lg-3 col-md-6">
                <div class="result-stat">
                    <div class="stat-number text-warning fw-bold display-3 mb-2"><?php echo esc_html($results_point_4_percentage) ?: '35%'; ?></div>
                    <h6 class="fw-bold text-uppercase"><?php echo esc_html($results_point_4_title) ?: 'Reduction in Support Tickets'; ?></h6>
                    <p class="text-muted small"><?php echo esc_html($results_point_4_description) ?: 'Fewer usability-related issues'; ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php endif; ?>