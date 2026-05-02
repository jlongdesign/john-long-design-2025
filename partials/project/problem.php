<?php
/**
 * Project Problem Section
 */

// Get problem meta data
$problem_intro = get_post_meta(get_the_ID(), '_problem_intro', true);
$problem_point_1_title = get_post_meta(get_the_ID(), '_problem_point_1_title', true);
$problem_point_1_description = get_post_meta(get_the_ID(), '_problem_point_1_description', true);
$problem_point_2_title = get_post_meta(get_the_ID(), '_problem_point_2_title', true);
$problem_point_2_description = get_post_meta(get_the_ID(), '_problem_point_2_description', true);

// Only show section if content exists
if ($problem_intro || $problem_point_1_title || $problem_point_2_title) :
?>

<!-- The Problem -->
<?php if (get_post_meta(get_the_ID(), '_problem_intro', true)) : ?>
    <section class="problem-section py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="section-content">
                        <h2 class="display-5 fw-bold mb-4">The Problem</h2>
                        <div class="problem-content bg-white p-4 rounded-3 shadow-sm">
                            <?php if ($problem_intro) : ?>
                                <div class="lead text-muted mb-4">
                                    <?php echo wpautop($problem_intro); ?>
                                </div>
                            <?php else : ?>
                                <p class="lead text-muted mb-4">Every great design solution starts with understanding the problem. Here's what we were trying to solve:</p>
                            <?php endif; ?>
                            
                            <div class="problem-points">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="problem-point">
                                            <div class="icon-box bg-danger bg-opacity-10 text-danger rounded-3 p-3 mb-3 d-inline-flex">
                                                <i class="fas fa-exclamation-triangle fa-lg"></i>
                                            </div>
                                            <h5 class="fw-bold"><?php echo esc_html($problem_point_1_title ?: 'User Pain Point 1'); ?></h5>
                                            <div class="text-muted">
                                                <?php echo wpautop($problem_point_1_description ?: 'Users were struggling with complex navigation and couldn\'t find what they needed quickly.'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="problem-point">
                                            <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-3 p-3 mb-3 d-inline-flex">
                                                <i class="fas fa-chart-line fa-lg"></i>
                                            </div>
                                            <h5 class="fw-bold"><?php echo esc_html($problem_point_2_title ?: 'Business Challenge'); ?></h5>
                                            <div class="text-muted">
                                                <?php echo wpautop($problem_point_2_description ?: 'Low conversion rates and high bounce rates were impacting business goals.'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php endif; ?>