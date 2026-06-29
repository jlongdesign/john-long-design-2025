<?php
/**
 * Project Testimonial Section
 */

$testimonial_intro = get_post_meta(get_the_ID(), '_testimonial_intro', true);
$testimonial_quote = get_post_meta(get_the_ID(), '_testimonial_quote', true);
$testimonial_author_name = get_post_meta(get_the_ID(), '_testimonial_author_name', true);
$testimonial_author_title = get_post_meta(get_the_ID(), '_testimonial_author_title', true);

// Only show section if content exists
if ($testimonial_intro || $testimonial_quote || $testimonial_author_name || $testimonial_author_title) :
?>

<!-- Testimonial Section -->
<section class="project-testimonial py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <blockquote class="blockquote">
                    <span class="lead mb-4"><?php echo wpautop($testimonial_quote) ?: "Working with John was an absolute pleasure. His attention to detail and user-centered approach resulted in a design that exceeded our expectations and delivered real business value."; ?></span>
                </blockquote>
                <div class="testimonial-author">
                    <h6 class="fw-bold mb-1"><?php echo esc_html($testimonial_author_name) ?: 'Sarah Johnson'; ?></h6>
                    <small class="opacity-75"><?php echo esc_html($testimonial_author_title) ?: 'Product Manager at TechCorp'; ?></small>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>