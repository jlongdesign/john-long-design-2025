<?php
/**
 * Project Overview Section
 */

$project_overview = get_post_meta(get_the_ID(), '_project_overview', true);

// Only show section if content exists
if ($project_overview) :
?>

<!-- Project Overview -->
<section class="project-overview py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2 class="display-5 fw-bold mb-4">Project Overview</h2>
                <div class="lead content-area">
                    <?php echo wpautop(get_post_meta(get_the_ID(), '_project_overview', true) ?: 'A brief summary of the project goes here.'); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>