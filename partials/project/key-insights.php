<?php
/**
 * Key Insights
 */
// Get key insights meta data
$key_insights_title = get_post_meta(get_the_ID(), '_key_insights_title', true);
$key_insights_intro = get_post_meta(get_the_ID(), '_key_insights_intro', true);
$key_insight_1_title = get_post_meta(get_the_ID(), '_key_insight_1_title', true);
$key_insight_1_description = get_post_meta(get_the_ID(), '_key_insight_1_description', true);
$key_insight_2_title = get_post_meta(get_the_ID(), '_key_insight_2_title', true);
$key_insight_2_description = get_post_meta(get_the_ID(), '_key_insight_2_description', true);

// Only show section if content exists
if ($key_insights_intro || $key_insight_1_title || $key_insight_2_title) :
?>

<section class="insights-section py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-5 fw-bold mb-4"><?php echo esc_html($key_insights_title ?: 'Key Insights'); ?></h2>
                <p class="lead text-muted"><?php echo esc_html($key_insights_intro ?: 'What we learned from our research that shaped the design direction'); ?></p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="insight-card bg-white p-4 rounded-3 shadow-sm h-100">
                    <div class="insight-number text-primary fw-bold fs-1 mb-3">01</div>
                    <h5 class="fw-bold mb-3"><?php echo esc_html($key_insight_1_title ?: 'Users Need Clear Navigation'); ?></h5>
                    <p class="text-muted"><?php echo esc_html($key_insight_1_description ?: '85% of users mentioned difficulty finding information due to unclear navigation structure and terminology.'); ?></p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="insight-card bg-white p-4 rounded-3 shadow-sm h-100">
                    <div class="insight-number text-primary fw-bold fs-1 mb-3">02</div>
                    <h5 class="fw-bold mb-3"><?php echo esc_html($key_insight_2_title ?: 'Mobile Experience is Critical'); ?></h5>
                    <p class="text-muted"><?php echo esc_html($key_insight_2_description ?: '73% of users primarily access the platform on mobile devices, but the current experience is not optimized.'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>