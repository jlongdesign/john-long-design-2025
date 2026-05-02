</main>

<footer class="site-footer bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h5 class="text-white">Connect With Me</h5>
                <div class="social-links">
                    <a href="https://www.linkedin.com/in/johnmlong/" class="text-white me-3"><i class="fab fa-linkedin"></i></a>
                    <!-- <a href="#" class="text-white me-3"><i class="fab fa-dribbble"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-behance"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-twitter"></i></a> -->
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <h5 class="text-white">Quick Links</h5>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_class' => 'list-unstyled',
                    'container' => false,
                    'walker' => new class extends Walker_Nav_Menu {
                        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                            $output .= '<li class="mb-2">';
                            $output .= '<a href="' . esc_attr($item->url) . '" class="text-light text-decoration-none">';
                            $output .= apply_filters('the_title', $item->title, $item->ID);
                            $output .= '</a>';
                        }
                        function end_el(&$output, $item, $depth = 0, $args = null) {
                            $output .= '</li>';
                        }
                    }
                ));
                ?>
            </div>
            <div class="col-lg-4 mb-4">
                <h5 class="text-white">Let's Work Together</h5>
                <p class="text-light">Ready to create something amazing? Let's discuss your next project.</p>
                <!-- <a href="#contact" class="btn btn-outline-light">Get In Touch</a> -->
            </div>
        </div>
        <hr class="my-4 border-light">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-light mb-3 mb-md-0 text-center text-md-start">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-end">
                <p class="text-light mb-0 text-center text-md-end">Crafted with ❤️ and lots of coffee</p>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
