<?php
/**
 * Meta Boxes and Custom Fields
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add meta boxes
 */
function jld_add_meta_boxes() {
    // Homepage meta boxes
    add_meta_box(
        'homepage_about',
        'About Section',
        'jld_homepage_about_callback',
        'page',
        'normal',
        'high'
    );

    // Project meta boxes
    add_meta_box(
        'project_details',
        'Project Details',
        'jld_project_details_callback',
        'project',
        'normal',
        'high'
    );

    // Testimonial meta boxes
    add_meta_box(
        'testimonial_details',
        'Testimonial Details',
        'jld_testimonial_details_callback',
        'testimonial',
        'normal',
        'high'
    );
    
    // Homepage testimonials
    add_meta_box(
        'homepage_testimonials',
        'Homepage Testimonials',
        'jld_homepage_testimonials_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'jld_add_meta_boxes');

/**
 * Homepage about section callback
 */
function jld_homepage_about_callback($post) {
    // Only show on homepage
    $homepage_id = get_option('page_on_front');
    if ($post->ID != $homepage_id) {
        echo '<p>This meta box only appears on the homepage.</p>';
        return;
    }
    
    wp_nonce_field('jld_save_homepage_meta', 'jld_homepage_meta_nonce');
    
    // Get existing values
    $about_title = get_post_meta($post->ID, '_about_title', true) ?: 'About Me';
    $about_intro = get_post_meta($post->ID, '_about_intro', true) ?: '';
    $about_description = get_post_meta($post->ID, '_about_description', true) ?: '';
    $about_image = get_post_meta($post->ID, '_about_image', true) ?: '';
    $about_skills = get_post_meta($post->ID, '_about_skills', true) ?: array();
    
    // Convert skills array to string for easier editing
    $skills_string = is_array($about_skills) ? implode(', ', $about_skills) : $about_skills;
    ?>
    
    <style>
    .about-meta-section {
        margin: 20px 0;
        padding: 15px;
        border: 1px solid #ccd0d4;
        background: #f9f9f9;
        border-radius: 4px;
    }
    .about-meta-section h3 {
        margin-top: 0;
        color: #23282d;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    .field-description {
        font-style: italic;
        color: #666;
        font-size: 12px;
        margin-top: 5px;
    }
    </style>

    <div class="about-meta-section">
        <h3>About Section Content</h3>
        <table class="form-table">
            <tr>
                <td><label for="about_title">Section Title:</label></td>
                <td>
                    <input type="text" 
                           id="about_title" 
                           name="about_title" 
                           value="<?php echo esc_attr($about_title); ?>" 
                           class="regular-text" 
                           placeholder="e.g., About Me, My Story, Who I Am" />
                    <p class="field-description">The main heading for the about section</p>
                </td>
            </tr>
            <tr>
                <td><label for="about_intro">Introduction (Lead Text):</label></td>
                <td>
                    <?php wp_editor($about_intro, 'about_intro', array(
                        'textarea_name' => 'about_intro',
                        'media_buttons' => false,
                        'textarea_rows' => 4,
                        'teeny' => false,
                        'quicktags' => true,
                        'tinymce' => array(
                            'toolbar1' => 'bold italic underline | link unlink | removeformat',
                            'toolbar2' => '',
                            'menubar' => false,
                            'statusbar' => false,
                        )
                    )); ?>
                    <p class="field-description">
                        <strong>Example:</strong> "I'm a passionate UX designer with over 8 years of experience creating digital experiences that bridge the gap between user needs and business goals."
                    </p>
                </td>
            </tr>
            <tr>
                <td><label for="about_description">Main Description:</label></td>
                <td>
                    <?php wp_editor($about_description, 'about_description', array(
                        'textarea_name' => 'about_description',
                        'media_buttons' => false,
                        'textarea_rows' => 6,
                        'teeny' => false,
                        'quicktags' => true,
                        'tinymce' => array(
                            'toolbar1' => 'bold italic underline | bullist numlist | link unlink | removeformat',
                            'toolbar2' => '',
                            'menubar' => false,
                            'statusbar' => false,
                        )
                    )); ?>
                    <p class="field-description">
                        <strong>Example:</strong> "My approach combines strategic thinking with creative problem-solving, always keeping the user at the center of every design decision. I believe great design is invisible – it just works."
                    </p>
                </td>
            </tr>
            <tr>
                <td><label for="about_skills">Skills (comma-separated):</label></td>
                <td>
                    <textarea id="about_skills" 
                              name="about_skills" 
                              class="large-text" 
                              rows="3" 
                              placeholder="User Research, UX Design, UI Design, Prototyping, Design Systems, Usability Testing"><?php echo esc_textarea($skills_string); ?></textarea>
                    <p class="field-description">Enter skills separated by commas. These will appear as badges below your description.</p>
                </td>
            </tr>
            <tr>
                <td><label for="about_image">About Image:</label></td>
                <td>
                    <input type="hidden" id="about_image" name="about_image" value="<?php echo esc_attr($about_image); ?>" />
                    <button type="button" class="button upload-image-button" data-target="about_image">Select Image</button>
                    <button type="button" class="button remove-image-button" data-target="about_image" style="margin-left: 10px;">Remove Image</button>
                    <div class="image-preview" style="margin-top: 10px;">
                        <?php if ($about_image) : ?>
                            <img src="<?php echo wp_get_attachment_image_url($about_image, 'medium'); ?>" style="max-width: 300px; height: auto;" />
                        <?php endif; ?>
                    </div>
                    <p class="field-description">Professional photo or image that represents you (optional - will show placeholder if empty)</p>
                </td>
            </tr>
            <tr>
                <td><label for="resume_file">Resume File:</label></td>
                <td>
                    <input type="hidden" id="resume_file" name="resume_file" value="<?php echo esc_attr(get_post_meta($post->ID, '_resume_file', true)); ?>" />
                    <button type="button" class="button upload-resume-button" data-target="resume_file">Select Resume</button>
                    <button type="button" class="button remove-resume-button" data-target="resume_file" style="margin-left: 10px;">Remove Resume</button>
                    <div class="resume-preview" style="margin-top: 10px;">
                        <?php 
                        $resume_id = get_post_meta($post->ID, '_resume_file', true);
                        if ($resume_id) {
                            $resume_url = wp_get_attachment_url($resume_id);
                            $resume_filename = basename(get_attached_file($resume_id));
                            echo '<p><strong>Current Resume:</strong> <a href="' . esc_url($resume_url) . '" target="_blank">' . esc_html($resume_filename) . '</a></p>';
                        }
                        ?>
                    </div>
                    <p class="field-description">Upload your resume as PDF file. This will be available for download on your homepage.</p>
                </td>
            </tr>
        </table>
    </div>

    <script>
        jQuery(document).ready(function($) {
            // Image uploader
            $('.upload-image-button').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var targetInput = button.data('target');
                var imagePreview = button.siblings('.image-preview');
                
                var mediaUploader = wp.media({
                    title: 'Select About Image',
                    button: { text: 'Use This Image' },
                    multiple: false,
                    library: { type: 'image' }
                });
                
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#' + targetInput).val(attachment.id);
                    if (attachment.sizes && attachment.sizes.medium) {
                        imagePreview.html('<img src="' + attachment.sizes.medium.url + '" style="max-width: 300px; height: auto;" />');
                    } else {
                        imagePreview.html('<img src="' + attachment.url + '" style="max-width: 300px; height: auto;" />');
                    }
                });
                
                mediaUploader.open();
            });
            
            // Resume uploader - ADD THIS SECTION
            $('.upload-resume-button').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var targetInput = button.data('target');
                var resumePreview = button.siblings('.resume-preview');
                
                var mediaUploader = wp.media({
                    title: 'Select Resume File',
                    button: { text: 'Use This File' },
                    multiple: false,
                    library: { type: 'application/pdf' }
                });
                
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#' + targetInput).val(attachment.id);
                    resumePreview.html('<p><strong>Selected Resume:</strong> <a href="' + attachment.url + '" target="_blank">' + attachment.filename + '</a></p>');
                });
                
                mediaUploader.open();
            });
            
            // Remove image
            $('.remove-image-button').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var targetInput = button.data('target');
                var imagePreview = button.siblings('.image-preview');
                
                $('#' + targetInput).val('');
                imagePreview.html('');
            });
            
            // Remove resume - ADD THIS SECTION
            $('.remove-resume-button').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var targetInput = button.data('target');
                var resumePreview = button.siblings('.resume-preview');
                
                $('#' + targetInput).val('');
                resumePreview.html('');
            });
        });
        </script>
    <?php
}

/**
 * Project details callback
 */
function jld_project_details_callback($post) {
    wp_nonce_field('jld_save_project_meta', 'jld_project_meta_nonce');
    
    // Get all existing meta values
    $project_client = get_post_meta($post->ID, '_project_client', true);
    $project_role = get_post_meta($post->ID, '_project_role', true);
    $project_duration = get_post_meta($post->ID, '_project_duration', true);
    $project_url = get_post_meta($post->ID, '_project_url', true);
    $project_overview = get_post_meta($post->ID, '_project_overview', true);
    
    // Problem fields
    $problem_intro = get_post_meta($post->ID, '_problem_intro', true);
    $problem_point_1_title = get_post_meta($post->ID, '_problem_point_1_title', true);
    $problem_point_1_description = get_post_meta($post->ID, '_problem_point_1_description', true);
    $problem_point_2_title = get_post_meta($post->ID, '_problem_point_2_title', true);
    $problem_point_2_description = get_post_meta($post->ID, '_problem_point_2_description', true);
    
    // Research fields
    $research_intro = get_post_meta($post->ID, '_research_intro', true);
    $research_user_interviews_title = get_post_meta($post->ID, '_research_user_interviews_title', true);
    $research_user_interviews_description = get_post_meta($post->ID, '_research_user_interviews_description', true);
    $research_market_analysis_title = get_post_meta($post->ID, '_research_market_analysis_title', true);
    $research_market_analysis_description = get_post_meta($post->ID, '_research_market_analysis_description', true);
    $research_usability_testing_title = get_post_meta($post->ID, '_research_usability_testing_title', true);
    $research_usability_testing_description = get_post_meta($post->ID, '_research_usability_testing_description', true);
    
    // Key insights fields
    $key_insights_intro = get_post_meta($post->ID, '_key_insights_intro', true);
    $key_insight_1_title = get_post_meta($post->ID, '_key_insight_1_title', true);
    $key_insight_1_description = get_post_meta($post->ID, '_key_insight_1_description', true);
    $key_insight_2_title = get_post_meta($post->ID, '_key_insight_2_title', true);
    $key_insight_2_description = get_post_meta($post->ID, '_key_insight_2_description', true);
    
    // Solution fields
    $solution_title = get_post_meta($post->ID, '_solution_title', true);
    $solution_intro = get_post_meta($post->ID, '_solution_intro', true);
    $solution_point_1_title = get_post_meta($post->ID, '_solution_point_1_title', true);
    $solution_point_1_description = get_post_meta($post->ID, '_solution_point_1_description', true);
    $solution_point_1_image = get_post_meta($post->ID, '_solution_point_1_image', true);
    $solution_point_1_image_2 = get_post_meta($post->ID, '_solution_point_1_image_2', true);
    $solution_point_1_image_3 = get_post_meta($post->ID, '_solution_point_1_image_3', true);
    $solution_point_2_title = get_post_meta($post->ID, '_solution_point_2_title', true);
    $solution_point_2_description = get_post_meta($post->ID, '_solution_point_2_description', true);
    $solution_point_2_image = get_post_meta($post->ID, '_solution_point_2_image', true);
    $solution_point_2_image_2 = get_post_meta($post->ID, '_solution_point_2_image_2', true);
    $solution_point_2_image_3 = get_post_meta($post->ID, '_solution_point_2_image_3', true);

    // Results fields
    $results_title = get_post_meta($post->ID, '_results_title', true);
    $results_intro = get_post_meta($post->ID, '_results_intro', true);
    $results_point_1_percentage = get_post_meta($post->ID, '_results_point_1_percentage', true);
    $results_point_1_title = get_post_meta($post->ID, '_results_point_1_title', true);
    $results_point_1_description = get_post_meta($post->ID, '_results_point_1_description', true);
    $results_point_2_percentage = get_post_meta($post->ID, '_results_point_2_percentage', true);
    $results_point_2_title = get_post_meta($post->ID, '_results_point_2_title', true);
    $results_point_2_description = get_post_meta($post->ID, '_results_point_2_description', true);
    $results_point_3_percentage = get_post_meta($post->ID, '_results_point_3_percentage', true);
    $results_point_3_title = get_post_meta($post->ID, '_results_point_3_title', true);
    $results_point_3_description = get_post_meta($post->ID, '_results_point_3_description', true);
    $results_point_4_percentage = get_post_meta($post->ID, '_results_point_4_percentage', true);
    $results_point_4_title = get_post_meta($post->ID, '_results_point_4_title', true);
    $results_point_4_description = get_post_meta($post->ID, '_results_point_4_description', true);
    
    // Testimonial fields
    $testimonial_quote = get_post_meta($post->ID, '_testimonial_quote', true);
    $testimonial_author_name = get_post_meta($post->ID, '_testimonial_author_name', true);
    $testimonial_author_title = get_post_meta($post->ID, '_testimonial_author_title', true);

    ?>
    <style>
    .meta-section {
        margin: 20px 0;
        padding: 15px;
        border: 1px solid #ccd0d4;
        background: #f9f9f9;
        border-radius: 4px;
    }
    .meta-section h3 {
        margin-top: 0;
        color: #23282d;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }
    .field-description {
        font-style: italic;
        color: #666;
        font-size: 12px;
        margin-top: 5px;
    }
    </style>

    <!-- Project Details Form -->
    <div class="meta-section">
        <h3>Basic Project Information</h3>
        <table class="form-table">
            <tr>
                <td><label for="project_client">Client:</label></td>
                <td>
                    <input type="text" 
                           id="project_client" 
                           name="project_client" 
                           value="<?php echo esc_attr($project_client); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Apple, Nike, Local Restaurant Group" />
                    <p class="field-description">The company or organization you worked with</p>
                </td>
            </tr>
            <tr>
                <td><label for="project_role">Role:</label></td>
                <td>
                    <input type="text" 
                           id="project_role" 
                           name="project_role" 
                           value="<?php echo esc_attr($project_role); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Lead UI/UX Designer, Product Designer, Design Consultant" />
                    <p class="field-description">Your primary role or title on this project</p>
                </td>
            </tr>
            <tr>
                <td><label for="project_duration">Duration:</label></td>
                <td>
                    <input type="text" 
                           id="project_duration" 
                           name="project_duration" 
                           value="<?php echo esc_attr($project_duration); ?>" 
                           class="regular-text" 
                           placeholder="e.g., 3 months, 6 weeks, Jan 2024 - Mar 2024" />
                    <p class="field-description">How long the project took from start to finish</p>
                </td>
            </tr>
            <tr>
                <td><label for="project_url">Project URL:</label></td>
                <td>
                    <input type="url" 
                           id="project_url" 
                           name="project_url" 
                           value="<?php echo esc_attr($project_url); ?>" 
                           class="regular-text" 
                           placeholder="https://example.com" />
                    <p class="field-description">Link to the live website or prototype (optional)</p>
                </td>
            </tr>
            <tr>
                <td><label for="project_featured">Featured Project:</label></td>
                <td>
                    <label for="project_featured">
                        <input type="checkbox" 
                            id="project_featured" 
                            name="project_featured" 
                            value="1" 
                            <?php checked(get_post_meta($post->ID, '_project_featured', true), '1'); ?> />
                        Mark as featured project for homepage
                    </label>
                    <p class="field-description">Featured projects appear on the homepage (up to 3 will be displayed)</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Project Overview Form-->
    <div class="meta-section">
        <h3>Project Overview</h3>
        <table class="form-table">
            <tr>
                <td><label for="project_overview">Project Overview:</label></td>
                <td>
                    <?php wp_editor($project_overview, 'project_overview', array(
                        'textarea_name' => 'project_overview',
                        'media_buttons' => true,
                        'textarea_rows' => 8,
                        'teeny' => false,
                        'quicktags' => true,
                        'tinymce' => array(
                            'toolbar1' => 'formatselect bold italic underline | alignleft aligncenter alignright | bullist numlist | link unlink | removeformat',
                            'toolbar2' => '',
                            'menubar' => false,
                            'statusbar' => false,
                        )
                    )); ?>
                    <p class="field-description">
                        <strong>Example:</strong> "I redesigned the mobile app experience for a leading e-commerce platform, focusing on improving the checkout process and reducing cart abandonment. The project involved extensive user research, prototyping, and A/B testing to create a more intuitive shopping experience."
                    </p>
                </td>
            </tr>
        </table>
    </div>

    <!-- The Problem Form -->
    <div class="meta-section">
        <h3>The Problem</h3>
        <table class="form-table">
            <tr>
                <td><label for="problem_intro">Problem Introduction:</label></td>
                <td>
                    <?php wp_editor($problem_intro, 'problem_intro', array(
                        'textarea_name' => 'problem_intro',
                        'media_buttons' => false,
                        'textarea_rows' => 6,
                        'teeny' => true,
                        'quicktags' => true,
                        'tinymce' => array(
                            'toolbar1' => 'formatselect bold italic underline | alignleft aligncenter alignright | bullist numlist | link unlink | removeformat',
                            'toolbar2' => '',
                            'menubar' => false,
                            'statusbar' => false,
                        )
                    )); ?>
                    <p class="field-description">
                        <strong>Example:</strong> "Users were experiencing significant friction during checkout, with a 68% cart abandonment rate. The existing mobile interface was cluttered and confusing, making it difficult for customers to complete purchases."
                    </p>
                </td>
            </tr>
            <tr>
                <td><label for="problem_point_1_title">Problem Point 1 Title:</label></td>
                <td>
                    <input type="text" 
                           id="problem_point_1_title" 
                           name="problem_point_1_title" 
                           value="<?php echo esc_attr($problem_point_1_title); ?>" 
                           class="regular-text" 
                           placeholder="e.g., High Cart Abandonment Rate" />
                    <p class="field-description">First key problem identified</p>
                </td>
            </tr>
            <tr>
                <td><label for="problem_point_1_description">Problem Point 1 Description:</label></td>
                <td>
                    <?php wp_editor($problem_point_1_description, 'problem_point_1_description', array(
                        'textarea_name' => 'problem_point_1_description',
                        'media_buttons' => false,
                        'textarea_rows' => 4,
                        'teeny' => true,
                        'quicktags' => true,
                        'tinymce' => array(
                            'toolbar1' => 'formatselect bold italic underline | alignleft aligncenter alignright | bullist numlist | link unlink | removeformat',
                            'toolbar2' => '',
                            'menubar' => false,
                            'statusbar' => false,
                        )
                    )); ?>
                    <p class="field-description">
                        <strong>Example:</strong> "68% of users abandoned their cart before completing checkout, primarily due to a confusing multi-step process and unclear error messaging."
                    </p>
                </td>
            </tr>
            <tr>
                <td><label for="problem_point_2_title">Problem Point 2 Title:</label></td>
                <td>
                    <input type="text" 
                           id="problem_point_2_title" 
                           name="problem_point_2_title" 
                           value="<?php echo esc_attr($problem_point_2_title); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Poor Mobile Experience" />
                    <p class="field-description">Second key problem identified</p>
                </td>
            </tr>
            <tr>
                <td><label for="problem_point_2_description">Problem Point 2 Description:</label></td>
                <td>
                    <?php wp_editor($problem_point_2_description, 'problem_point_2_description', array(
                        'textarea_name' => 'problem_point_2_description',
                        'media_buttons' => false,
                        'textarea_rows' => 4,
                        'teeny' => true,
                        'quicktags' => true,
                        'tinymce' => array(
                            'toolbar1' => 'formatselect bold italic underline | alignleft aligncenter alignright | bullist numlist | link unlink | removeformat',
                            'toolbar2' => '',
                            'menubar' => false,
                            'statusbar' => false,
                        )
                    )); ?>
                    <p class="field-description">
                        <strong>Example:</strong> "The mobile interface wasn't optimized for touch interactions, with buttons too small and forms difficult to fill out on mobile devices."
                    </p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Research and Discovery Form -->
    <div class="meta-section">
        <h3>Research & Discovery</h3>
        <table class="form-table">
            <tr>
                <td><label for="research_intro">Research Introduction:</label></td>
                <td>
                    <?php wp_editor($research_intro, 'research_intro', array(
                        'textarea_name' => 'research_intro',
                        'media_buttons' => false,
                        'textarea_rows' => 6,
                        'teeny' => true,
                        'quicktags' => true,
                        'tinymce' => array(
                            'toolbar1' => 'formatselect bold italic underline | alignleft aligncenter alignright | bullist numlist | link unlink | removeformat',
                            'toolbar2' => '',
                            'menubar' => false,
                            'statusbar' => false,
                        )
                    )); ?>
                    <p class="field-description">
                        <strong>Example:</strong> "To understand the root causes of user frustration, I conducted comprehensive research including user interviews, analytics review, and competitive analysis."
                    </p>
                </td>
            </tr>
            <tr>
                <td><label for="research_user_interviews_title">User Interviews Title:</label></td>
                <td>
                    <input type="text" 
                           id="research_user_interviews_title" 
                           name="research_user_interviews_title" 
                           value="<?php echo esc_attr($research_user_interviews_title); ?>" 
                           class="regular-text" 
                           placeholder="e.g., User Interviews & Pain Points" />
                </td>
            </tr>
            <tr>
                <td><label for="research_user_interviews_description">User Interviews Description:</label></td>
                <td>
                    <?php wp_editor($research_user_interviews_description, 'research_user_interviews_description', array(
                        'textarea_name' => 'research_user_interviews_description',
                        'media_buttons' => false,
                        'textarea_rows' => 4,
                        'teeny' => true,
                        'quicktags' => true,
                        'tinymce' => array(
                            'toolbar1' => 'formatselect bold italic underline | alignleft aligncenter alignright | bullist numlist | link unlink | removeformat',
                            'toolbar2' => '',
                            'menubar' => false,
                            'statusbar' => false,
                        )
                    )); ?>
                    <p class="field-description">
                        <strong>Example:</strong> "Interviewed 12 existing customers to understand their shopping journey and identify specific friction points during checkout."
                    </p>
                </td>
            </tr>
            <tr>
                <td><label for="research_market_analysis_title">Market Analysis Title:</label></td>
                <td>
                    <input type="text" 
                           id="research_market_analysis_title" 
                           name="research_market_analysis_title" 
                           value="<?php echo esc_attr($research_market_analysis_title); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Competitive Analysis" />
                </td>
            </tr>
            <tr>
                <td><label for="research_market_analysis_description">Market Analysis Description:</label></td>
                <td>
                    <?php wp_editor($research_market_analysis_description, 'research_market_analysis_description', array(
                        'textarea_name' => 'research_market_analysis_description',
                        'media_buttons' => false,
                        'textarea_rows' => 4,
                        'teeny' => true,
                        'quicktags' => true,
                        'tinymce' => array(
                            'toolbar1' => 'formatselect bold italic underline | alignleft aligncenter alignright | bullist numlist | link unlink | removeformat',
                            'toolbar2' => '',
                            'menubar' => false,
                            'statusbar' => false,
                        )
                    )); ?>
                    <p class="field-description">
                        <strong>Example:</strong> "Analyzed checkout flows from 5 leading e-commerce platforms to identify best practices and industry standards."
                    </p>
                </td>
            </tr>
            <tr>
                <td><label for="research_usability_testing_title">Usability Testing Title:</label></td>
                <td>
                    <input type="text" 
                           id="research_usability_testing_title" 
                           name="research_usability_testing_title" 
                           value="<?php echo esc_attr($research_usability_testing_title); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Current State Usability Testing" />
                </td>
            </tr>
            <tr>
                <td><label for="research_usability_testing_description">Usability Testing Description:</label></td>
                <td>
                    <?php wp_editor($research_usability_testing_description, 'research_usability_testing_description', array(
                        'textarea_name' => 'research_usability_testing_description',
                        'media_buttons' => false,
                        'textarea_rows' => 4,
                        'teeny' => true,
                        'quicktags' => true,
                        'tinymce' => array(
                            'toolbar1' => 'formatselect bold italic underline | alignleft aligncenter alignright | bullist numlist | link unlink | removeformat',
                            'toolbar2' => '',
                            'menubar' => false,
                            'statusbar' => false,
                        )
                    )); ?>
                    <p class="field-description">
                        <strong>Example:</strong> "Conducted moderated usability tests with 8 participants to observe their behavior and identify specific points of confusion."
                    </p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Solution Section Form -->
    <div class="meta-section">
        <h3>The Solution</h3>
        <table class="form-table">
            <tr>
                <td><label for="solution_title">Solution Title:</label></td>
                <td>
                    <input type="text" 
                           id="solution_title" 
                           name="solution_title" 
                           value="<?php echo esc_attr($solution_title); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Streamlined Checkout Experience" />
                    <p class="field-description">Optional: Custom title for the solution section (defaults to "The Solution")</p>
                </td>
            </tr>
            <tr>
                <td><label for="solution_intro">Solution Introduction:</label></td>
                <td>
                    <?php wp_editor($solution_intro, 'solution_intro', array(
                        'textarea_name' => 'solution_intro',
                        'media_buttons' => false,
                        'textarea_rows' => 4,
                        'teeny' => true,
                        'quicktags' => true,
                        'tinymce' => array(
                            'toolbar1' => 'formatselect bold italic underline | alignleft aligncenter alignright | bullist numlist | link unlink | removeformat',
                            'toolbar2' => '',
                            'menubar' => false,
                            'statusbar' => false,
                        )
                    )); ?>
                    <p class="field-description">
                        <strong>Example:</strong> "I redesigned the checkout flow with a focus on simplicity and mobile-first design, reducing steps from 5 to 3 and implementing clear progress indicators."
                    </p>
                </td>
            </tr>
            <tr>
                <td><label for="solution_point_1_title">Solution Point 1 Title:</label></td>
                <td>
                    <input type="text" 
                           id="solution_point_1_title" 
                           name="solution_point_1_title" 
                           value="<?php echo esc_attr($solution_point_1_title); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Simplified Checkout Flow" />
                </td>
            </tr>
            <tr>
                <td><label for="solution_point_1_description">Solution Point 1 Description:</label></td>
                <td>
                    <?php wp_editor($solution_point_1_description, 'solution_point_1_description', array(
                        'textarea_name' => 'solution_point_1_description',
                        'media_buttons' => false,
                        'textarea_rows' => 4,
                        'teeny' => true,
                        'quicktags' => true,
                        'tinymce' => array(
                            'toolbar1' => 'formatselect bold italic underline | alignleft aligncenter alignright | bullist numlist | link unlink | removeformat',
                            'toolbar2' => '',
                            'menubar' => false,
                            'statusbar' => false,
                        )
                    )); ?>
                    <p class="field-description">
                        <strong>Example:</strong> "Consolidated the 5-step checkout into 3 clear steps: Cart Review, Shipping & Payment, and Confirmation. Added a progress bar to show users exactly where they are in the process."
                    </p>
                </td>
            </tr>
            <tr>
                <td><label for="solution_point_1_image">Solution Point 1 Image:</label></td>
                <td>
                    <input type="hidden" id="solution_point_1_image" name="solution_point_1_image" value="<?php echo esc_attr($solution_point_1_image); ?>" />
                    <button type="button" class="button upload-image-button" data-target="solution_point_1_image">Select Image</button>
                    <button type="button" class="button remove-image-button" data-target="solution_point_1_image" style="margin-left: 10px;">Remove Image</button>
                    <div class="image-preview" style="margin-top: 10px;">
                        <?php if ($solution_point_1_image) : ?>
                            <img src="<?php echo wp_get_attachment_image_url($solution_point_1_image, 'medium'); ?>" style="max-width: 300px; height: auto;" />
                        <?php endif; ?>
                    </div>
                    <p class="field-description">Primary image showing this solution (wireframes, mockups, final design)</p>
                </td>
            </tr>
            <tr>
                <td><label for="solution_point_1_image_2">Solution Point 1 Image 2:</label></td>
                    <td>
                        <input type="hidden" id="solution_point_1_image_2" name="solution_point_1_image_2" value="<?php echo esc_attr($solution_point_1_image_2); ?>" />
                        <button type="button" class="button upload-image-button" data-target="solution_point_1_image_2">Select Image</button>
                        <button type="button" class="button remove-image-button" data-target="solution_point_1_image_2" style="margin-left: 10px;">Remove Image</button>
                        <div class="image-preview" style="margin-top: 10px;">
                            <?php if ($solution_point_1_image_2) : ?>
                                <img src="<?php echo wp_get_attachment_image_url($solution_point_1_image_2, 'medium'); ?>" style="max-width: 300px; height: auto;" />
                            <?php endif; ?>
                        </div>
                        <p class="field-description">Optional: Additional image for carousel (process steps, before/after, etc.)</p>
                    </td>
            </tr>
            <tr>
                <td><label for="solution_point_1_image_3">Solution Point 1 Image 3:</label></td>
                <td>
                    <input type="hidden" id="solution_point_1_image_3" name="solution_point_1_image_3" value="<?php echo esc_attr($solution_point_1_image_3); ?>" />
                    <button type="button" class="button upload-image-button" data-target="solution_point_1_image_3">Select Image</button>
                    <button type="button" class="button remove-image-button" data-target="solution_point_1_image_3" style="margin-left: 10px;">Remove Image</button>
                    <div class="image-preview" style="margin-top: 10px;">
                        <?php if ($solution_point_1_image_3) : ?>
                            <img src="<?php echo wp_get_attachment_image_url($solution_point_1_image_3, 'medium'); ?>" style="max-width: 300px; height: auto;" />
                        <?php endif; ?>
                    </div>
                    <p class="field-description">Optional: Third image for carousel</p>
                </td>
            </tr>
            <tr>
                <td><label for="solution_point_2_title">Solution Point 2 Title:</label></td>
                <td>
                    <input type="text" 
                           id="solution_point_2_title" 
                           name="solution_point_2_title" 
                           value="<?php echo esc_attr($solution_point_2_title); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Mobile-First Design" />
                </td>
            </tr>
            <tr>
                <td><label for="solution_point_2_description">Solution Point 2 Description:</label></td>
                <td>
                    <?php wp_editor($solution_point_2_description, 'solution_point_2_description', array(
                        'textarea_name' => 'solution_point_2_description',
                        'media_buttons' => false,
                        'textarea_rows' => 4,
                        'teeny' => true,
                        'quicktags' => true,
                        'tinymce' => array(
                            'toolbar1' => 'formatselect bold italic underline | alignleft aligncenter alignright | bullist numlist | link unlink | removeformat',
                            'toolbar2' => '',
                            'menubar' => false,
                            'statusbar' => false,
                        )
                    )); ?>
                    <p class="field-description">
                        <strong>Example:</strong> "Redesigned all touch targets to meet accessibility guidelines, improved form field spacing, and implemented smart defaults to reduce typing on mobile devices."
                    </p>
                </td>
            </tr>
            <tr>
                <td><label for="solution_point_2_image">Solution Point 2 Image:</label></td>
                <td>
                    <input type="hidden" id="solution_point_2_image" name="solution_point_2_image" value="<?php echo esc_attr($solution_point_2_image); ?>" />
                    <button type="button" class="button upload-image-button" data-target="solution_point_2_image">Select Image</button>
                    <button type="button" class="button remove-image-button" data-target="solution_point_2_image" style="margin-left: 10px;">Remove Image</button>
                    <div class="image-preview" style="margin-top: 10px;">
                        <?php if ($solution_point_2_image) : ?>
                            <img src="<?php echo wp_get_attachment_image_url($solution_point_2_image, 'medium'); ?>" style="max-width: 300px; height: auto;" />
                        <?php endif; ?>
                    </div>
                    <p class="field-description">Primary image for solution point 2</p>
                </td>
            </tr>
            <tr>
                <td><label for="solution_point_2_image_2">Solution Point 2 Image 2:</label></td>
                <td>
                    <input type="hidden" id="solution_point_2_image_2" name="solution_point_2_image_2" value="<?php echo esc_attr($solution_point_2_image_2); ?>" />
                    <button type="button" class="button upload-image-button" data-target="solution_point_2_image_2">Select Image</button>
                    <button type="button" class="button remove-image-button" data-target="solution_point_2_image_2" style="margin-left: 10px;">Remove Image</button>
                    <div class="image-preview" style="margin-top: 10px;">
                        <?php if ($solution_point_2_image_2) : ?>
                            <img src="<?php echo wp_get_attachment_image_url($solution_point_2_image_2, 'medium'); ?>" style="max-width: 300px; height: auto;" />
                        <?php endif; ?>
                    </div>
                    <p class="field-description">Optional: Second image for carousel</p>
                </td>
            </tr>
            <tr>
                <td><label for="solution_point_2_image_3">Solution Point 2 Image 3:</label></td>
                <td>
                    <input type="hidden" id="solution_point_2_image_3" name="solution_point_2_image_3" value="<?php echo esc_attr($solution_point_2_image_3); ?>" />
                    <button type="button" class="button upload-image-button" data-target="solution_point_2_image_3">Select Image</button>
                    <button type="button" class="button remove-image-button" data-target="solution_point_2_image_3" style="margin-left: 10px;">Remove Image</button>
                    <div class="image-preview" style="margin-top: 10px;">
                        <?php if ($solution_point_2_image_3) : ?>
                            <img src="<?php echo wp_get_attachment_image_url($solution_point_2_image_3, 'medium'); ?>" style="max-width: 300px; height: auto;" />
                        <?php endif; ?>
                    </div>
                    <p class="field-description">Optional: Third image for carousel</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Results Section -->
    <div class="meta-section">
        <h3>Results & Impact</h3>
        <table class="form-table">
            <tr>
                <td><label for="results_title">Results Title:</label></td>
                <td>
                    <input type="text" 
                           id="results_title" 
                           name="results_title" 
                           value="<?php echo esc_attr($results_title); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Impact & Results" />
                    <p class="field-description">Optional: Custom title for results section (defaults to "Results")</p>
                </td>
            </tr>
            <tr>
                <td><label for="results_intro">Results Introduction:</label></td>
                <td>
                    <?php wp_editor($results_intro, 'results_intro', array(
                        'textarea_name' => 'results_intro',
                        'media_buttons' => false,
                        'textarea_rows' => 4,
                        'teeny' => true,
                        'quicktags' => true,
                        'tinymce' => array(
                            'toolbar1' => 'formatselect bold italic underline | alignleft aligncenter alignright | bullist numlist | link unlink | removeformat',
                            'toolbar2' => '',
                            'menubar' => false,
                            'statusbar' => false,
                        )
                    )); ?>
                    <p class="field-description">
                        <strong>Example:</strong> "The redesigned checkout experience launched successfully, resulting in significant improvements across all key metrics within the first 3 months."
                    </p>
                </td>
            </tr>
            <tr>
                <td><label for="results_point_1_percentage">Result Point 1 Percentage:</label></td>
                <td>
                    <input type="text" 
                           id="results_point_1_percentage" 
                           name="results_point_1_percentage" 
                           value="<?php echo esc_attr($results_point_1_percentage); ?>" 
                           class="regular-text" 
                           placeholder="e.g., 45%" />
                    <p class="field-description">The number/percentage for this metric (e.g., "45%", "2.3x", "$2M")</p>
                </td>
            </tr>
            <tr>
                <td><label for="results_point_1_title">Result Point 1 Title:</label></td>
                <td>
                    <input type="text" 
                           id="results_point_1_title" 
                           name="results_point_1_title" 
                           value="<?php echo esc_attr($results_point_1_title); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Increase in Conversion Rate" />
                </td>
            </tr>
            <tr>
                <td><label for="results_point_1_description">Result Point 1 Description:</label></td>
                <td>
                    <input type="text" 
                           id="results_point_1_description" 
                           name="results_point_1_description" 
                           value="<?php echo esc_attr($results_point_1_description); ?>" 
                           class="regular-text" 
                           placeholder="e.g., From 2.1% to 3.05% within 3 months" />
                    <p class="field-description">Brief explanation or context for this result</p>
                </td>
            </tr>
            <tr>
                <td><label for="results_point_2_percentage">Result Point 2 Percentage:</label></td>
                <td>
                    <input type="text" 
                           id="results_point_2_percentage" 
                           name="results_point_2_percentage" 
                           value="<?php echo esc_attr($results_point_2_percentage); ?>" 
                           class="regular-text" 
                           placeholder="e.g., 32%" />
                </td>
            </tr>
            <tr>
                <td><label for="results_point_2_title">Result Point 2 Title:</label></td>
                <td>
                    <input type="text" 
                           id="results_point_2_title" 
                           name="results_point_2_title" 
                           value="<?php echo esc_attr($results_point_2_title); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Reduction in Cart Abandonment" />
                </td>
            </tr>
            <tr>
                <td><label for="results_point_2_description">Result Point 2 Description:</label></td>
                <td>
                    <input type="text" 
                           id="results_point_2_description" 
                           name="results_point_2_description" 
                           value="<?php echo esc_attr($results_point_2_description); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Down from 68% to 46% abandonment rate" />
                </td>
            </tr>
            <tr>
                <td><label for="results_point_3_percentage">Result Point 3 Percentage:</label></td>
                <td>
                    <input type="text" 
                           id="results_point_3_percentage" 
                           name="results_point_3_percentage" 
                           value="<?php echo esc_attr($results_point_3_percentage); ?>" 
                           class="regular-text" 
                           placeholder="e.g., 60%" />
                </td>
            </tr>
            <tr>
                <td><label for="results_point_3_title">Result Point 3 Title:</label></td>
                <td>
                    <input type="text" 
                           id="results_point_3_title" 
                           name="results_point_3_title" 
                           value="<?php echo esc_attr($results_point_3_title); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Faster Checkout Completion" />
                </td>
            </tr>
            <tr>
                <td><label for="results_point_3_description">Result Point 3 Description:</label></td>
                <td>
                    <input type="text" 
                           id="results_point_3_description" 
                           name="results_point_3_description" 
                           value="<?php echo esc_attr($results_point_3_description); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Average completion time reduced from 4.2 to 2.5 minutes" />
                </td>
            </tr>
            <tr>
                <td><label for="results_point_4_percentage">Result Point 4 Percentage:</label></td>
                <td>
                    <input type="text" 
                           id="results_point_4_percentage" 
                           name="results_point_4_percentage" 
                           value="<?php echo esc_attr($results_point_4_percentage); ?>" 
                           class="regular-text" 
                           placeholder="e.g., 95%" />
                </td>
            </tr>
            <tr>
                <td><label for="results_point_4_title">Result Point 4 Title:</label></td>
                <td>
                    <input type="text" 
                           id="results_point_4_title" 
                           name="results_point_4_title" 
                           value="<?php echo esc_attr($results_point_4_title); ?>" 
                           class="regular-text" 
                           placeholder="e.g., User Satisfaction Score" />
                </td>
            </tr>
            <tr>
                <td><label for="results_point_4_description">Result Point 4 Description:</label></td>
                <td>
                    <input type="text" 
                           id="results_point_4_description" 
                           name="results_point_4_description" 
                           value="<?php echo esc_attr($results_point_4_description); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Post-launch user satisfaction increased to 4.8/5 stars" />
                </td>
            </tr>
        </table>
    </div>

    <!-- Testimonial Section -->
    <div class="meta-section">
        <h3>Project Testimonial</h3>
        <table class="form-table">
            <tr>
                <td><label for="testimonial_quote">Testimonial Quote:</label></td>
                <td>
                    <?php wp_editor($testimonial_quote, 'testimonial_quote', array(
                        'textarea_name' => 'testimonial_quote',
                        'media_buttons' => false,
                        'textarea_rows' => 6,
                        'teeny' => true,
                        'quicktags' => true,
                        'tinymce' => array(
                            'toolbar1' => 'formatselect bold italic underline | alignleft aligncenter alignright | bullist numlist | link unlink | removeformat',
                            'toolbar2' => '',
                            'menubar' => false,
                            'statusbar' => false,
                        )
                    )); ?>
                    <p class="field-description">
                        <strong>Example:</strong> "John's redesign exceeded our expectations. The new checkout flow is intuitive and has dramatically improved our conversion rates. His attention to detail and user-centered approach made all the difference."
                    </p>
                </td>
            </tr>
            <tr>
                <td><label for="testimonial_author_name">Author Name:</label></td>
                <td>
                    <input type="text" 
                           id="testimonial_author_name" 
                           name="testimonial_author_name" 
                           value="<?php echo esc_attr($testimonial_author_name); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Sarah Johnson" />
                </td>
            </tr>
            <tr>
                <td><label for="testimonial_author_title">Author Title/Company:</label></td>
                <td>
                    <input type="text" 
                           id="testimonial_author_title" 
                           name="testimonial_author_title" 
                           value="<?php echo esc_attr($testimonial_author_title); ?>" 
                           class="regular-text" 
                           placeholder="e.g., Product Manager, E-commerce Company" />
                </td>
            </tr>
        </table>
    </div>  

    <!-- Media Uploader Script -->
    <script>
        jQuery(document).ready(function($) {
            // Image uploader
            $('.upload-image-button').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var targetInput = button.data('target');
                var imagePreview = button.siblings('.image-preview');
                
                var mediaUploader = wp.media({
                    title: 'Select About Image',
                    button: { text: 'Use This Image' },
                    multiple: false,
                    library: { type: 'image' }
                });
                
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#' + targetInput).val(attachment.id);
                    if (attachment.sizes && attachment.sizes.medium) {
                        imagePreview.html('<img src="' + attachment.sizes.medium.url + '" style="max-width: 300px; height: auto;" />');
                    } else {
                        imagePreview.html('<img src="' + attachment.url + '" style="max-width: 300px; height: auto;" />');
                    }
                });
                
                mediaUploader.open();
            });
            
            // Resume uploader
            $('.upload-resume-button').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var targetInput = button.data('target');
                var resumePreview = button.siblings('.resume-preview');
                
                var mediaUploader = wp.media({
                    title: 'Select Resume File',
                    button: { text: 'Use This File' },
                    multiple: false,
                    library: { type: 'application/pdf' }
                });
                
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();
                    $('#' + targetInput).val(attachment.id);
                    resumePreview.html('<p><strong>Selected Resume:</strong> <a href="' + attachment.url + '" target="_blank">' + attachment.filename + '</a></p>');
                });
                
                mediaUploader.open();
            });
            
            // Remove image
            $('.remove-image-button').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var targetInput = button.data('target');
                var imagePreview = button.siblings('.image-preview');
                
                $('#' + targetInput).val('');
                imagePreview.html('');
            });
            
            // Remove resume
            $('.remove-resume-button').click(function(e) {
                e.preventDefault();
                var button = $(this);
                var targetInput = button.data('target');
                var resumePreview = button.siblings('.resume-preview');
                
                $('#' + targetInput).val('');
                resumePreview.html('');
            });
        });
        </script>

    <?php
}


/**
 * Save meta data
 */
function jld_save_meta_data($post_id) {
    // Don't save on autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check if user has permissions to edit the post
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Handle PROJECT meta data
    if (isset($_POST['jld_project_meta_nonce']) && wp_verify_nonce($_POST['jld_project_meta_nonce'], 'jld_save_project_meta')) {
        if (get_post_type($post_id) == 'project') {
            $project_fields = array(
                'project_client',
                'project_role', 
                'project_duration',
                'project_url', 
                'project_featured',
                'project_overview',
                'problem_intro',
                'problem_point_1_title',
                'problem_point_1_description',
                'problem_point_2_title',
                'problem_point_2_description',
                'research_intro',
                'research_user_interviews_title',
                'research_user_interviews_description',
                'research_market_analysis_title',
                'research_market_analysis_description',
                'research_usability_testing_title',
                'research_usability_testing_description',
                'key_insights_intro',          // MISSING: Added key insights fields
                'key_insight_1_title',         // MISSING: Added
                'key_insight_1_description',   // MISSING: Added
                'key_insight_2_title',         // MISSING: Added
                'key_insight_2_description',   // MISSING: Added
                'solution_title',
                'solution_intro',
                'solution_point_1_title',
                'solution_point_1_description',
                'solution_point_1_image',
                'solution_point_1_image_2',
                'solution_point_1_image_3',
                'solution_point_2_title',
                'solution_point_2_description',
                'solution_point_2_image',
                'solution_point_2_image_2',
                'solution_point_2_image_3',
                'results_title',
                'results_intro',
                'results_point_1_percentage',
                'results_point_1_title',
                'results_point_1_description',
                'results_point_2_percentage',
                'results_point_2_title',
                'results_point_2_description',
                'results_point_3_percentage',
                'results_point_3_title',
                'results_point_3_description',
                'results_point_4_percentage',
                'results_point_4_title',
                'results_point_4_description',
                'testimonial_quote',
                'testimonial_author_name',
                'testimonial_author_title'
            );
            
            // Define which fields are images
            $image_fields = array(
                'solution_point_1_image',
                'solution_point_1_image_2',
                'solution_point_1_image_3',
                'solution_point_2_image',
                'solution_point_2_image_2',
                'solution_point_2_image_3'
            );
            
            // Define which fields allow HTML
            $html_fields = array(
                'project_overview', 
                'problem_intro', 
                'problem_point_1_description', 
                'problem_point_2_description',
                'research_intro',
                'research_user_interviews_description',
                'research_market_analysis_description',
                'research_usability_testing_description',
                'key_insights_intro',              // MISSING: Added to HTML fields
                'key_insight_1_description',       // MISSING: Added to HTML fields
                'key_insight_2_description',       // MISSING: Added to HTML fields
                'solution_intro', 
                'solution_point_1_description',
                'solution_point_2_description',
                'results_intro',
                'testimonial_quote'
            );
            
            foreach ($project_fields as $field) {
                if (isset($_POST[$field])) {
                    if (in_array($field, $html_fields)) {
                        update_post_meta($post_id, '_' . $field, wp_kses_post($_POST[$field]));
                    } elseif (in_array($field, $image_fields)) {
                        update_post_meta($post_id, '_' . $field, intval($_POST[$field]));
                    } elseif ($field === 'project_url') {
                        update_post_meta($post_id, '_' . $field, esc_url_raw($_POST[$field]));
                    } else {
                        update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
                    }
                }
            }
        }
    }

    // Handle HOMEPAGE meta data - MOVED OUTSIDE PROJECT NONCE CHECK
    if (isset($_POST['jld_homepage_meta_nonce']) && wp_verify_nonce($_POST['jld_homepage_meta_nonce'], 'jld_save_homepage_meta')) {
        // Only save about fields on pages (homepage uses page post type)
        if (get_post_type($post_id) == 'page') {
            $about_fields = array(
                'about_title',
                'about_intro', 
                'about_description',
                'about_skills',
                'about_image',
                'resume_file'
            );
            
            foreach ($about_fields as $field) {
                if (isset($_POST[$field])) {
                    if ($field === 'about_skills') {
                        // Convert comma-separated string to array
                        $skills = array_map('trim', explode(',', $_POST[$field]));
                        $skills = array_filter($skills); // Remove empty values
                        update_post_meta($post_id, '_' . $field, $skills);
                    } elseif (in_array($field, array('about_intro', 'about_description'))) {
                        // These fields allow HTML
                        update_post_meta($post_id, '_' . $field, wp_kses_post($_POST[$field]));
                    } elseif (in_array($field, array('about_image', 'resume_file'))) {  // UPDATE THIS LINE
                        // Image and file fields
                        update_post_meta($post_id, '_' . $field, intval($_POST[$field]));
                    } else {
                        // Simple text fields
                        update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
                    }
                }
            }
        }
    }

    // Handle HOMEPAGE TESTIMONIALS meta data
    if (isset($_POST['jld_homepage_testimonials_nonce']) && wp_verify_nonce($_POST['jld_homepage_testimonials_nonce'], 'jld_save_homepage_testimonials')) {
        if (get_post_type($post_id) == 'page') {
            if (isset($_POST['testimonials']) && is_array($_POST['testimonials'])) {
                $testimonials = array();
                
                foreach ($_POST['testimonials'] as $testimonial) {
                    // Only save testimonials that have content
                    if (!empty($testimonial['name']) && !empty($testimonial['content'])) {
                        $testimonials[] = array(
                            'name' => sanitize_text_field($testimonial['name']),
                            'position' => sanitize_text_field($testimonial['position']),
                            'company' => sanitize_text_field($testimonial['company']),
                            'content' => sanitize_textarea_field($testimonial['content']),
                            'rating' => intval($testimonial['rating'])
                        );
                    }
                }
                
                update_post_meta($post_id, '_homepage_testimonials', $testimonials);
            }
        }
    }
}
add_action('save_post', 'jld_save_meta_data');

// Add placeholder functions for other meta boxes to prevent errors
function jld_testimonial_details_callback($post) {
    echo '<p>Testimonial details coming soon...</p>';
}

function jld_homepage_testimonials_callback($post) {
    // Only show on homepage
    $homepage_id = get_option('page_on_front');
    if ($post->ID != $homepage_id) {
        echo '<p>This meta box only appears on the homepage.</p>';
        return;
    }
    
    wp_nonce_field('jld_save_homepage_testimonials', 'jld_homepage_testimonials_nonce');
    
    // Get existing testimonials
    $testimonials = get_post_meta($post->ID, '_homepage_testimonials', true);
    if (!is_array($testimonials)) {
        $testimonials = array();
    }
    
    // Ensure we have at least 3 empty testimonials for editing
    while (count($testimonials) < 3) {
        $testimonials[] = array(
            'name' => '',
            'position' => '',
            'company' => '',
            'content' => '',
            'rating' => 5
        );
    }
    ?>
    
    <style>
    .testimonials-meta-section {
        margin: 20px 0;
        padding: 15px;
        border: 1px solid #ccd0d4;
        background: #f9f9f9;
        border-radius: 4px;
    }
    .testimonial-item {
        margin-bottom: 30px;
        padding: 20px;
        border: 1px solid #ddd;
        background: white;
        border-radius: 4px;
    }
    .testimonial-item h4 {
        margin-top: 0;
        color: #23282d;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }
    .field-description {
        font-style: italic;
        color: #666;
        font-size: 12px;
        margin-top: 5px;
    }
    .rating-input {
        display: flex;
        gap: 5px;
        align-items: center;
    }
    .rating-input input[type="radio"] {
        margin: 0 2px;
    }
    </style>

    <div class="testimonials-meta-section">
        <h3>Homepage Testimonials</h3>
        <p>Add up to 3 testimonials to display on your homepage. Leave fields empty to hide unused testimonials.</p>
        
        <?php foreach ($testimonials as $index => $testimonial) : ?>
        <div class="testimonial-item">
            <h4>Testimonial <?php echo $index + 1; ?></h4>
            
            <table class="form-table">
                <tr>
                    <td style="width: 150px;"><label for="testimonial_<?php echo $index; ?>_name">Client Name:</label></td>
                    <td>
                        <input type="text" 
                               id="testimonial_<?php echo $index; ?>_name" 
                               name="testimonials[<?php echo $index; ?>][name]" 
                               value="<?php echo esc_attr($testimonial['name']); ?>" 
                               class="regular-text" 
                               placeholder="e.g., Sarah Johnson" />
                        <p class="field-description">The client's full name</p>
                    </td>
                </tr>
                <tr>
                    <td><label for="testimonial_<?php echo $index; ?>_position">Position:</label></td>
                    <td>
                        <input type="text" 
                               id="testimonial_<?php echo $index; ?>_position" 
                               name="testimonials[<?php echo $index; ?>][position]" 
                               value="<?php echo esc_attr($testimonial['position']); ?>" 
                               class="regular-text" 
                               placeholder="e.g., Product Manager" />
                        <p class="field-description">Their job title or role</p>
                    </td>
                </tr>
                <tr>
                    <td><label for="testimonial_<?php echo $index; ?>_company">Company:</label></td>
                    <td>
                        <input type="text" 
                               id="testimonial_<?php echo $index; ?>_company" 
                               name="testimonials[<?php echo $index; ?>][company]" 
                               value="<?php echo esc_attr($testimonial['company']); ?>" 
                               class="regular-text" 
                               placeholder="e.g., Apple, Nike, Startup Inc" />
                        <p class="field-description">Company name (optional)</p>
                    </td>
                </tr>
                <tr>
                    <td><label for="testimonial_<?php echo $index; ?>_rating">Rating:</label></td>
                    <td>
                        <div class="rating-input">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <label>
                                    <input type="radio" 
                                           name="testimonials[<?php echo $index; ?>][rating]" 
                                           value="<?php echo $i; ?>" 
                                           <?php checked($testimonial['rating'], $i); ?> />
                                    <?php echo $i; ?> star<?php echo $i > 1 ? 's' : ''; ?>
                                </label>
                            <?php endfor; ?>
                        </div>
                        <p class="field-description">Star rating (1-5 stars)</p>
                    </td>
                </tr>
                <tr>
                    <td><label for="testimonial_<?php echo $index; ?>_content">Testimonial:</label></td>
                    <td>
                        <textarea id="testimonial_<?php echo $index; ?>_content" 
                                  name="testimonials[<?php echo $index; ?>][content]" 
                                  class="large-text" 
                                  rows="4" 
                                  placeholder="John's design work exceeded our expectations. His user-centered approach and attention to detail resulted in a 40% increase in user engagement."><?php echo esc_textarea($testimonial['content']); ?></textarea>
                        <p class="field-description">
                            <strong>Example:</strong> "John's redesign of our checkout process was incredible. The new flow reduced cart abandonment by 35% and our customers love how intuitive it is now."
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <?php endforeach; ?>
        
        <p><strong>Tip:</strong> Great testimonials include specific results or benefits. Mention metrics, improvements, or positive outcomes when possible.</p>
    </div>
    <?php
}
?>