<?php get_header(); ?>

<!-- Hero Section -->
<section class="hero-section position-relative overflow-hidden" id="hero">
    <div class="container px-0">
        <div class="row g-0 align-items-center hero-row">
            <div class="col-lg-6 hero-content p-5">
                <div class="hero-text">
                    <h1 class="display-3 fw-bold text-dark mb-2">
                        <?php echo esc_html(get_theme_mod('hero_title', 'John Long')); ?><br/>
                    </h1>
                    <p class="display-6 text-orange fw-semibold mb-3">
                        <?php echo esc_html(get_theme_mod('hero_subtitle', 'Lead Product Designer')); ?>
                    </p>
                    <p class="fs-5 text-muted mb-4">
                        <?php echo esc_html(get_theme_mod('hero_description', 'I help businesses create meaningful digital experiences through user-centered design and strategic thinking.')); ?>
                    </p>
                    <!-- <div class="hero-buttons">
                        <a href="#projects" class="btn btn-primary btn-lg me-3 mb-3 mb-md-0 ">View My Work</a>
                        <a href="#contact" class="btn btn-outline-primary btn-lg">Let's Talk</a>
                    </div> -->
                </div>
            </div>
            <div class="col-lg-6 hero-image d-flex align-items-center justify-content-center d-none d-lg-block">
                <?php 
                $hero_image_id = get_theme_mod('hero_image');
                if ($hero_image_id) {
                    echo wp_get_attachment_image($hero_image_id, 'full', false, array('class' => 'img-fluid h-100 w-100 object-fit-cover no-transform-sm'));
                } else {
                    echo '<div class="hero-placeholder bg-gradient-primary d-flex align-items-center justify-content-center h-100">
                            <div class="text-center text-white">
                                <i class="fas fa-palette fa-5x mb-3"></i>
                                <h3>Your Hero Image</h3>
                                <p>Add your featured image in the customizer</p>
                            </div>
                          </div>';
                }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Featured Projects Section -->
<section class="featured-projects py-5" id="projects">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-4 fw-bold mb-4"></span>Featured <span style="color: #ff6600;">/</span> Projects</h2>
                <p class="lead text-muted">Explore some of my recent work and the stories behind them</p>
            </div>
        </div>
        
        <div class="row g-4">
            <?php
            $featured_projects = new WP_Query(array(
                'post_type' => 'project',
                'posts_per_page' => 3,
                'meta_query' => array(
                    array(
                        'key' => '_project_featured',
                        'value' => '1',
                        'compare' => '='
                    )
                )
            ));

            if ($featured_projects->have_posts()) :
                while ($featured_projects->have_posts()) : $featured_projects->the_post();
            ?>
            <div class="col-lg-6 col-md-6">
                <div class="project-card h-100 border-0 overflow-hidden rounded-3">
                    <div class="project-image position-relative">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('project-thumbnail', array('class' => 'card-img-top')); ?>
                            </a>
                        <?php endif; ?>
                        <div class="project-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                            <a href="<?php the_permalink(); ?>" class="btn btn-light btn-sm">View Case Study</a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="card-title fw-bold">
                            <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark"><?php the_title(); ?></a>
                        </h5>
                        <p class="card-text text-muted"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                        <div class="project-meta">
                            <?php $client = get_post_meta(get_the_ID(), '_project_client', true); ?>
                            <?php if ($client) : ?>
                                <small class="text-primary fw-semibold">Client: <?php echo esc_html($client); ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                endwhile;
                wp_reset_postdata();
            else :
            ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No featured projects yet</h4>
                <p class="text-muted">Add some projects and mark them as featured to display them here.</p>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-5">
            <a href="<?php echo esc_url(get_post_type_archive_link('project')); ?>" class="btn btn-primary btn-lg">View All Projects</a>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section py-5 bg-light" id="about">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <?php
                // Get about content from homepage meta
                $about_title = get_post_meta(get_the_ID(), '_about_title', true) ?: 'About Me';
                $about_intro = get_post_meta(get_the_ID(), '_about_intro', true) ?: 'I\'m a passionate UX designer with over 8 years of experience creating digital experiences that bridge the gap between user needs and business goals.';
                $about_description = get_post_meta(get_the_ID(), '_about_description', true) ?: 'My approach combines strategic thinking with creative problem-solving, always keeping the user at the center of every design decision. I believe great design is invisible – it just works.';
                $about_skills = get_post_meta(get_the_ID(), '_about_skills', true);
                
                // Default skills if none set
                if (empty($about_skills)) {
                    $about_skills = array('User Research', 'UX Design', 'UI Design', 'Prototyping', 'Design Systems', 'Usability Testing');
                }
                ?>
                
                <h2 class="display-4 fw-bold mb-4"><?php echo esc_html($about_title); ?></h2>
                
                <?php if ($about_intro) : ?>
                <div class="lead mb-4">
                    <?php echo wpautop($about_intro); ?>
                </div>
                <?php endif; ?>
                
                <?php if ($about_description) : ?>
                <div class="mb-4">
                    <?php echo wpautop($about_description); ?>
                </div>
                <?php endif; ?>
                
                <?php if (!empty($about_skills)) : ?>
                <div class="skills-list">
                    <?php foreach ($about_skills as $skill) : ?>
                        <span class="badge bg-primary me-2 mb-2 p-2"><?php echo esc_html(trim($skill)); ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-4">
                <div class="about-image">
                    <?php 
                    $about_image_id = get_post_meta(get_the_ID(), '_about_image', true);
                    if ($about_image_id) {
                        echo wp_get_attachment_image($about_image_id, 'large', false, array('class' => 'img-fluid rounded-3 shadow', 'alt' => 'About ' . get_bloginfo('name')));
                    } else {
                        // Keep your existing placeholder SVG
                        echo '<img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTAwIiBoZWlnaHQ9IjUwMCIgdmlld0JveD0iMCAwIDUwMCA1MDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI1MDAiIGhlaWdodD0iNTAwIiBmaWxsPSIjRjhGOUZBIi8+CjxjaXJjbGUgY3g9IjI1MCIgY3k9IjI1MCIgcj0iMTAwIiBmaWxsPSIjNjM2NkYxIi8+Cjx0ZXh0IHg9IjI1MCIgeT0iMzIwIiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBmaWxsPSIjNkI3Mjg4IiBmb250LWZhbWlseT0ic2Fucy1zZXJpZiIgZm9udC1zaXplPSIxOCI+QWJvdXQgUGhvdG88L3RleHQ+Cjwvc3ZnPgo=" alt="About Photo" class="img-fluid rounded-3 shadow">';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section py-5" id="testimonials">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-4 fw-bold mb-4">What Clients Say</h2>
                <p class="lead text-muted">Don't just take my word for it – here's what my clients have to say about working together</p>
            </div>
        </div>
        
        <div class="row g-5">
            <?php
            // Get testimonials from homepage meta
            $homepage_id = get_option('page_on_front');
            $testimonials = get_post_meta($homepage_id, '_homepage_testimonials', true);
            
            if (!empty($testimonials) && is_array($testimonials)) :
                foreach ($testimonials as $testimonial) :
                    if (empty($testimonial['name']) && empty($testimonial['content'])) continue;
            ?>
            <div class="col-lg-6 col-md-6">
                <div class="testimonial-card bg-white p-4 rounded-3 shadow-sm h-100">
                    <div class="rating mb-3">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <i class="fas fa-star <?php echo $i <= $testimonial['rating'] ? 'text-warning' : 'text-muted'; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <blockquote class="mb-4">
                        <p class="text-muted">"<?php echo esc_html($testimonial['content']); ?>"</p>
                    </blockquote>
                    <div class="testimonial-author d-flex align-items-center">
                        <div class="author-avatar me-3">
                            <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div class="author-info">
                            <h6 class="mb-0 fw-bold"><?php echo esc_html($testimonial['name']); ?></h6>
                            <small class="text-muted">
                                <?php echo esc_html($testimonial['position']); ?>
                                <?php if (!empty($testimonial['company'])) : ?>
                                    at <?php echo esc_html($testimonial['company']); ?>
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;
            else :
            ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No testimonials yet</h4>
                <p class="text-muted">Add testimonials in the page editor below.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Resume Download Section -->
<section class="resume-section py-5 bg-primary text-white">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold mb-4 text-white">Ready to Work Together?</h2>
                <p class="lead mb-4">
                    Download my resume to see my full experience and let's discuss how I can help bring your next project to life.
                </p>
                <?php 
                $resume_id = get_post_meta(get_the_ID(), '_resume_file', true);
                if ($resume_id) {
                    $resume_url = wp_get_attachment_url($resume_id);
                    $resume_filename = basename(get_attached_file($resume_id));
                    ?>
                    <a href="<?php echo esc_url($resume_url); ?>" 
                       class="btn btn-light btn-lg" 
                       download="<?php echo esc_attr($resume_filename); ?>"
                       target="_blank">
                        <i class="fas fa-download me-2"></i>Download Resume
                    </a>
                <?php } else { ?>
                    <!-- Fallback if no resume is uploaded -->
                    <button class="btn btn-light btn-lg" disabled>
                        <i class="fas fa-download me-2"></i>Resume Coming Soon
                    </button>
                    <p class="mt-3 mb-0">
                        <small>Resume will be available for download soon. In the meantime, feel free to contact me directly!</small>
                    </p>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section py-5" id="contact">
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="display-4 fw-bold mb-4">Let's Work Together</h2>
                <p class="lead text-muted">Ready to bring your next project to life? I'd love to hear about your ideas and how we can collaborate.</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <?php if (isset($_GET['contact']) && $_GET['contact'] == 'success') : ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        Thank you for your message! I'll get back to you soon.
                    </div>
                <?php elseif (isset($_GET['contact']) && $_GET['contact'] == 'error') : ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Sorry, there was an error sending your message. Please try again.
                    </div>
                <?php elseif (isset($_GET['contact']) && $_GET['contact'] == 'spam') : ?>
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-shield-alt me-2"></i>
                        Your message was flagged as spam. Please try again with a different message.
                    </div>
                <?php elseif (isset($_GET['contact']) && $_GET['contact'] == 'rate_limit') : ?>
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-clock me-2"></i>
                        Too many messages submitted recently. Please wait before trying again.
                    </div>
                <?php endif; ?>
                
                <!-- Load reCAPTCHA script -->
                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                
                <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post" class="contact-form">
                    <input type="hidden" name="action" value="jld_contact_form">
                    <input type="hidden" name="form_timestamp" value="<?php echo time(); ?>">
                    <?php wp_nonce_field('jld_contact_form', 'contact_nonce'); ?>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="contact_name" class="form-label">Name *</label>
                            <input type="text" class="form-control" id="contact_name" name="contact_name" required maxlength="100">
                        </div>
                        <div class="col-md-6">
                            <label for="contact_email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="contact_email" name="contact_email" required maxlength="255">
                        </div>
                        <div class="col-12">
                            <label for="contact_subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="contact_subject" name="contact_subject" maxlength="200" placeholder="What would you like to discuss?">
                        </div>
                        <div class="col-12">
                            <label for="contact_message" class="form-label">Message *</label>
                            <textarea class="form-control" id="contact_message" name="contact_message" rows="6" required maxlength="2000" placeholder="Tell me about your project or how I can help..."></textarea>
                            <div class="form-text">Maximum 2000 characters</div>
                        </div>
                        
                        <!-- reCAPTCHA -->
                        <div class="col-12 text-center mb-3">
                            <div class="g-recaptcha d-inline-block" data-sitekey="6Le0ffMrAAAAAJcxfmoVlxloUeejVkp_lEaSR8kC"></div>
                            <div class="form-text mt-2">Protected by reCAPTCHA</div>
                        </div>
                        
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                Send Message
                            </button>
                        </div>
                    </div>

                    <!-- Honeypot field (hidden) -->
                    <div style="position: absolute; left: -9999px; opacity: 0;">
                        <label for="website">Website (leave blank)</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>
                </form>
                
                <!-- Alternative contact methods -->
                <div class="row mt-5 pt-4 border-top">
                    <div class="col-12 text-center">
                        <h5 class="mb-3">Prefer to reach out directly?</h5>
                        <div class="contact-alternatives">
                            <a href="mailto:<?php echo antispambot(get_theme_mod('contact_email', get_bloginfo('admin_email'))); ?>" class="btn btn-outline-primary me-3 mb-2">
                                <i class="fas fa-envelope me-2"></i>
                                Email Me
                            </a>
                            <?php if (get_theme_mod('linkedin_url')) : ?>
                            <a href="<?php echo esc_url(get_theme_mod('linkedin_url')); ?>" target="_blank" class="btn btn-outline-primary me-3 mb-2">
                                <i class="fab fa-linkedin me-2"></i>
                                LinkedIn
                            </a>
                            <?php endif; ?>
                            <?php if (get_theme_mod('phone_number')) : ?>
                            <a href="tel:<?php echo esc_attr(str_replace(array(' ', '-', '(', ')'), '', get_theme_mod('phone_number'))); ?>" class="btn btn-outline-primary mb-2">
                                <i class="fas fa-phone me-2"></i>
                                Call Me
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
