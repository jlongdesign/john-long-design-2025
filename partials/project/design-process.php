<?php
/**
 * Design Process
 */
// Get design process meta data
$design_process_title = get_post_meta(get_the_ID(), '_design_process_title', true);
$design_process_intro = get_post_meta(get_the_ID(), '_design_process_intro', true);
$design_process_step_1_number = get_post_meta(get_the_ID(), '_design_process_step_1_number', true);
$design_process_step_1_title = get_post_meta(get_the_ID(), '_design_process_step_1_title', true);
$design_process_step_1_description = get_post_meta(get_the_ID(), '_design_process_step_1_description', true);
$design_process_step_2_number = get_post_meta(get_the_ID(), '_design_process_step_2_number', true);
$design_process_step_2_title = get_post_meta(get_the_ID(), '_design_process_step_2_title', true);
$design_process_step_2_description = get_post_meta(get_the_ID(), '_design_process_step_2_description', true);
$design_process_step_3_number = get_post_meta(get_the_ID(), '_design_process_step_3_number', true);
$design_process_step_3_title = get_post_meta(get_the_ID(), '_design_process_step_3_title', true);
$design_process_step_3_description = get_post_meta(get_the_ID(), '_design_process_step_3_description', true);
$design_process_step_4_number = get_post_meta(get_the_ID(), '_design_process_step_4_number', true);
$design_process_step_4_title = get_post_meta(get_the_ID(), '_design_process_step_4_title', true);
$design_process_step_4_description = get_post_meta(get_the_ID(), '_design_process_step_4_description', true);

// Only show section if content exists
if ($design_process_intro || $design_process_step_1_title || $design_process_step_2_title) :
?>

<!-- Design Process -->
<section class="design-process py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold mb-4"><?php echo esc_html($design_process_title) ?: 'Design Process'; ?></h2>
                <p class="lead text-muted"><?php echo esc_html($design_process_intro) ?: 'A systematic approach to solving design challenges'; ?></p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="process-step text-center">
                    <div class="step-number bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <span class="fw-bold fs-4"><?php echo esc_html($design_process_step_1_number) ?: '1'; ?></span>
                    </div>
                    <h5 class="fw-bold"><?php echo esc_html($design_process_step_1_title) ?: 'Discover'; ?></h5>
                    <p class="text-muted"><?php echo esc_html($design_process_step_1_description) ?: 'Research and understand the problem space'; ?></p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="process-step text-center">
                    <div class="step-number bg-success text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <span class="fw-bold fs-4"><?php echo esc_html($design_process_step_2_number) ?: '2'; ?></span>
                    </div>
                    <h5 class="fw-bold"><?php echo esc_html($design_process_step_2_title) ?: 'Define'; ?></h5>
                    <p class="text-muted"><?php echo esc_html($design_process_step_2_description) ?: 'Synthesize insights and define the problem'; ?></p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="process-step text-center">
                    <div class="step-number bg-info text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <span class="fw-bold fs-4"><?php echo esc_html($design_process_step_3_number) ?: '3'; ?></span>
                    </div>
                    <h5 class="fw-bold"><?php echo esc_html($design_process_step_3_title) ?: 'Design'; ?></h5>
                    <p class="text-muted"><?php echo esc_html($design_process_step_3_description) ?: 'Create and iterate on design solutions'; ?></p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="process-step text-center">
                    <div class="step-number bg-warning text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <span class="fw-bold fs-4"><?php echo esc_html($design_process_step_4_number) ?: '4'; ?></span>
                    </div>
                    <h5 class="fw-bold"><?php echo esc_html($design_process_step_4_title) ?: 'Deliver'; ?></h5>
                    <p class="text-muted"><?php echo esc_html($design_process_step_4_description) ?: 'Test, refine, and implement the solution'; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>