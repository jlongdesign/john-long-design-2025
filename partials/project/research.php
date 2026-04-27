<?php
/**
 * Project Research Section
 */

$research_intro = get_post_meta(get_the_ID(), '_research_intro', true);
$research_user_interviews_title = get_post_meta(get_the_ID(), '_research_user_interviews_title', true);
$research_user_interviews_description = get_post_meta(get_the_ID(), '_research_user_interviews_description', true);
$research_market_analysis_title = get_post_meta(get_the_ID(), '_research_market_analysis_title', true);
$research_market_analysis_description = get_post_meta(get_the_ID(), '_research_market_analysis_description', true);
$research_usability_testing_title = get_post_meta(get_the_ID(), '_research_usability_testing_title', true);
$research_usability_testing_description = get_post_meta(get_the_ID(), '_research_usability_testing_description', true);

// Only show section if content exists
if ($research_intro || $research_user_interviews_title || $research_market_analysis_title || $research_usability_testing_title) :
?>

<!-- Research Section -->
<section class="research-section py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold mb-4">Research & Discovery</h2>
                <div class="lead text-muted"><?php echo wpautop($research_intro ?: 'Understanding users and the problem space through comprehensive research'); ?></div>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="research-card bg-white p-4 rounded-3 shadow-sm h-100">
                    <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-3 p-3 mb-3 d-inline-flex">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                    <h5 class="fw-bold"><?php echo esc_html($research_user_interviews_title ?: 'User Interviews'); ?></h5>
                    <div class="text-muted"><?php echo wpautop($research_user_interviews_description ?: 'Conducted in-depth interviews with 12 users to understand their goals, frustrations, and current workflows.'); ?></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="research-card bg-white p-4 rounded-3 shadow-sm h-100">
                    <div class="icon-box bg-success bg-opacity-10 text-success rounded-3 p-3 mb-3 d-inline-flex">
                        <i class="fas fa-chart-bar fa-lg"></i>
                    </div>
                    <h5 class="fw-bold"><?php echo esc_html($research_market_analysis_title ?: 'Market Analysis'); ?></h5>
                    <div class="text-muted"><?php echo wpautop($research_market_analysis_description ?: 'Analyzed competitors and industry trends to identify opportunities and best practices.'); ?></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="research-card bg-white p-4 rounded-3 shadow-sm h-100">
                    <div class="icon-box bg-info bg-opacity-10 text-info rounded-3 p-3 mb-3 d-inline-flex">
                        <i class="fas fa-mouse-pointer fa-lg"></i>
                    </div>
                    <h5 class="fw-bold"><?php echo esc_html($research_usability_testing_title ?: 'Usability Testing'); ?></h5>
                    <div class="text-muted"><?php echo wpautop($research_usability_testing_description ?: 'Tested the current solution to identify specific usability issues and pain points.'); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>