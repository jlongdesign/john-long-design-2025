<?php
/**
 * Project Solution Section
 */

// Get solution meta data
$solution_title = get_post_meta(get_the_ID(), '_solution_title', true);
$solution_intro = get_post_meta(get_the_ID(), '_solution_intro', true);
$solution_point_1_title = get_post_meta(get_the_ID(), '_solution_point_1_title', true);
$solution_point_1_description = get_post_meta(get_the_ID(), '_solution_point_1_description', true);

// Get multiple images for each solution point 1 
$solution_point_1_images = array(
    get_post_meta(get_the_ID(), '_solution_point_1_image', true),
    get_post_meta(get_the_ID(), '_solution_point_1_image_2', true),
    get_post_meta(get_the_ID(), '_solution_point_1_image_3', true)
);

$solution_point_2_title = get_post_meta(get_the_ID(), '_solution_point_2_title', true);
$solution_point_2_description = get_post_meta(get_the_ID(), '_solution_point_2_description', true);

// Get multiple images for each solution point 2
$solution_point_2_images = array(
    get_post_meta(get_the_ID(), '_solution_point_2_image', true),
    get_post_meta(get_the_ID(), '_solution_point_2_image_2', true),
    get_post_meta(get_the_ID(), '_solution_point_2_image_3', true)
);

// Filter out empty images
$solution_point_1_images = array_filter($solution_point_1_images);
$solution_point_2_images = array_filter($solution_point_2_images);

// Only show section if content exists
if ($solution_intro || $solution_point_1_title || $solution_point_2_title) :
?>

<!-- The Solution -->
<section class="project-solution py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold mb-4"><?php echo esc_html($solution_title ?: 'The Solution'); ?></h2>
                    <?php if ($solution_intro) : ?>
                    <div class="lead text-muted">
                        <?php echo wpautop($solution_intro); ?>
                    </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($solution_point_1_title) : ?>
                <!-- Solution Point 1 -->
                <div class="row align-items-center mb-5">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="solution-content">
                            <h4 class="fw-bold mb-3"><?php echo esc_html($solution_point_1_title); ?></h4>
                            <?php if ($solution_point_1_description) : ?>
                            <div class="text-muted mb-4">
                                <?php echo wpautop($solution_point_1_description); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="solution-image shadow rounded-3 p-4 bg-white overflow-hidden">
                            <?php if (!empty($solution_point_1_images)) : ?>
                                <?php if (count($solution_point_1_images) > 1) : ?>
                                    <!-- Carousel for multiple images -->
                                    <div id="solutionCarousel1" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner rounded-3">
                                            <?php foreach ($solution_point_1_images as $index => $image_id) : 
                                                $image_url = wp_get_attachment_image_url($image_id, 'large');
                                                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                                                if ($image_url) :
                                            ?>
                                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                                    <a href="<?php echo esc_url($image_url); ?>" 
                                                       data-lightbox="solution-point-1" 
                                                       data-title="<?php echo esc_attr($solution_point_1_title . ' - Image ' . ($index + 1)); ?>"
                                                       class="lightbox-trigger">
                                                        <img src="<?php echo esc_url($image_url); ?>" 
                                                             class="d-block w-100" 
                                                             alt="<?php echo esc_attr($image_alt ?: $solution_point_1_title . ' - Image ' . ($index + 1)); ?>"
                                                             style="height: 350px; object-fit: cover; object-position: top;">
                                                    </a>
                                                </div>
                                            <?php endif; endforeach; ?>
                                        </div>
                                        
                                        <!-- Carousel controls -->
                                        <button class="carousel-control-prev" type="button" data-bs-target="#solutionCarousel1" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#solutionCarousel1" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                        
                                        <!-- Carousel indicators -->
                                        <div class="carousel-indicators">
                                            <?php foreach ($solution_point_1_images as $index => $image_id) : ?>
                                                <button type="button" 
                                                        data-bs-target="#solutionCarousel1" 
                                                        data-bs-slide-to="<?php echo $index; ?>" 
                                                        class="<?php echo $index === 0 ? 'active' : ''; ?>" 
                                                        aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>" 
                                                        aria-label="Slide <?php echo $index + 1; ?>"></button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Hidden lightbox links for additional images -->
                                    <div style="display: none;">
                                        <?php foreach ($solution_point_1_images as $index => $image_id) : 
                                            if ($index === 0) continue; // Skip first image (already visible)
                                            $image_url = wp_get_attachment_image_url($image_id, 'large');
                                            if ($image_url) :
                                        ?>
                                            <a href="<?php echo esc_url($image_url); ?>" 
                                               data-lightbox="solution-point-1" 
                                               data-title="<?php echo esc_attr($solution_point_1_title . ' - Image ' . ($index + 1)); ?>"></a>
                                        <?php endif; endforeach; ?>
                                    </div>
                                    
                                <?php else : ?>
                                    <!-- Single image -->
                                    <?php 
                                    $image_url = wp_get_attachment_image_url($solution_point_1_images[0], 'large');
                                    $image_alt = get_post_meta($solution_point_1_images[0], '_wp_attachment_image_alt', true);
                                    ?>
                                    <a href="<?php echo esc_url($image_url); ?>" data-lightbox="solution-point-1" class="img-fluid rounded-3">
                                        <img src="<?php echo esc_url($image_url); ?>" 
                                             alt="<?php echo esc_attr($image_alt ?: $solution_point_1_title); ?>" 
                                             class="img-fluid rounded-3">
                                    </a>
                                <?php endif; ?>
                            <?php else : ?>
                                <div class="placeholder bg-light rounded-3 d-flex align-items-center justify-content-center" style="height: 300px;">
                                    <span class="text-muted">Solution Image</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($solution_point_2_title) : ?>
                <!-- Solution Point 2 -->
                <div class="row align-items-center">
                    <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                        <div class="solution-content">
                            <h4 class="fw-bold mb-3"><?php echo esc_html($solution_point_2_title); ?></h4>
                            <?php if ($solution_point_2_description) : ?>
                            <div class="text-muted mb-4">
                                <?php echo wpautop($solution_point_2_description); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <div class="solution-image shadow rounded-3 p-4 bg-white overflow-hidden">
                            <?php if (!empty($solution_point_2_images)) : ?>
                                <?php if (count($solution_point_2_images) > 1) : ?>
                                    <!-- Carousel for multiple images -->
                                    <div id="solutionCarousel2" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner rounded-3">
                                            <?php foreach ($solution_point_2_images as $index => $image_id) : 
                                                $image_url = wp_get_attachment_image_url($image_id, 'large');
                                                $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                                                if ($image_url) :
                                            ?>
                                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                                    <a href="<?php echo esc_url($image_url); ?>" 
                                                       data-lightbox="solution-point-2" 
                                                       data-title="<?php echo esc_attr($solution_point_2_title . ' - Image ' . ($index + 1)); ?>"
                                                       class="lightbox-trigger">
                                                        <img src="<?php echo esc_url($image_url); ?>" 
                                                             class="d-block w-100" 
                                                             alt="<?php echo esc_attr($image_alt ?: $solution_point_2_title . ' - Image ' . ($index + 1)); ?>"
                                                             style="height: 350px; object-fit: cover; object-position: top;">
                                                    </a>
                                                </div>
                                            <?php endif; endforeach; ?>
                                        </div>
                                        
                                        <!-- Carousel controls -->
                                        <button class="carousel-control-prev" type="button" data-bs-target="#solutionCarousel2" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#solutionCarousel2" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                        
                                        <!-- Carousel indicators -->
                                        <div class="carousel-indicators">
                                            <?php foreach ($solution_point_2_images as $index => $image_id) : ?>
                                                <button type="button" 
                                                        data-bs-target="#solutionCarousel2" 
                                                        data-bs-slide-to="<?php echo $index; ?>" 
                                                        class="<?php echo $index === 0 ? 'active' : ''; ?>" 
                                                        aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>" 
                                                        aria-label="Slide <?php echo $index + 1; ?>"></button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Hidden lightbox links for additional images -->
                                    <div style="display: none;">
                                        <?php foreach ($solution_point_2_images as $index => $image_id) : 
                                            if ($index === 0) continue; // Skip first image (already visible)
                                            $image_url = wp_get_attachment_image_url($image_id, 'large');
                                            if ($image_url) :
                                        ?>
                                            <a href="<?php echo esc_url($image_url); ?>" 
                                               data-lightbox="solution-point-2" 
                                               data-title="<?php echo esc_attr($solution_point_2_title . ' - Image ' . ($index + 1)); ?>"></a>
                                        <?php endif; endforeach; ?>
                                    </div>
                                    
                                <?php else : ?>
                                    <!-- Single image -->
                                    <?php 
                                    $image_url = wp_get_attachment_image_url($solution_point_2_images[0], 'large');
                                    $image_alt = get_post_meta($solution_point_2_images[0], '_wp_attachment_image_alt', true);
                                    ?>
                                    <a href="<?php echo esc_url($image_url); ?>" data-lightbox="solution-point-2" class="img-fluid rounded-3">
                                        <img src="<?php echo esc_url($image_url); ?>" 
                                             alt="<?php echo esc_attr($image_alt ?: $solution_point_2_title); ?>" 
                                             class="img-fluid rounded-3">
                                    </a>
                                <?php endif; ?>
                            <?php else : ?>
                                <div class="placeholder bg-light rounded-3 d-flex align-items-center justify-content-center" style="height: 300px;">
                                    <span class="text-muted">Solution Image</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>