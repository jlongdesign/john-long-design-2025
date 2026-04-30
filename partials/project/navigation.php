<?php
/**
 * Project Navigation Section
 */
?>

<!-- Navigation -->
<section class="project-navigation py-4 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <?php
                $prev_post = get_previous_post(false, '', 'project');
                if ($prev_post) :
                ?>
                <a href="<?php echo get_permalink($prev_post); ?>" class="text-decoration-none">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-chevron-left text-primary me-3"></i>
                        <div>
                            <small class="text-muted d-block">Previous Project</small>
                            <strong><?php echo get_the_title($prev_post); ?></strong>
                        </div>
                    </div>
                </a>
                <?php endif; ?>
            </div>
            <div class="col-md-6 text-md-end">
                <?php
                $next_post = get_next_post(false, '', 'project');
                if ($next_post) :
                ?>
                <a href="<?php echo get_permalink($next_post); ?>" class="text-decoration-none">
                    <div class="d-flex align-items-center justify-content-md-end">
                        <div class="text-md-end me-3">
                            <small class="text-muted d-block">Next Project</small>
                            <strong><?php echo get_the_title($next_post); ?></strong>
                        </div>
                        <i class="fas fa-chevron-right text-primary"></i>
                    </div>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
