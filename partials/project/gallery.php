<?php
/**
 * Project Gallery Partial
 *
 * Displays a gallery of images for a single portfolio project.
 * Reads image IDs saved by the Project Gallery meta box.
 */

$raw_ids      = get_post_meta( get_the_ID(), '_project_gallery_ids', true );
$gallery_ids  = ! empty( $raw_ids ) ? array_filter( array_map( 'absint', explode( ',', $raw_ids ) ) ) : [];

if ( empty( $gallery_ids ) ) {
    return;
}
?>

<section class="project-gallery container py-4" aria-label="Project Gallery">

    <div class="text-center mb-4">
        <h2 class="display-5 fw-bold mb-4"><?php _e( 'Project Gallery', 'john-long-design' ); ?></h2>
        <p class="lead text-muted">
            <?php _e( 'Click on an image to view it in full size.', 'john-long-design' ); ?>
        </p>
    </div>

    <div class="project-gallery__grid">
        <?php foreach ( $gallery_ids as $index => $image_id ) :

            $image_large   = wp_get_attachment_image_url( $image_id, 'large' );
            $image_alt     = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
            $image_caption = wp_get_attachment_caption( $image_id );
        ?>

            <figure class="project-gallery__item border border-1 rounded-3" data-index="<?php echo esc_attr( $index ); ?>">
                <a
                    class="project-gallery__link glightbox"
                    href="<?php echo esc_url( $image_large ); ?>"
                    aria-label="<?php echo esc_attr( $image_alt ? $image_alt : __( 'View image', 'john-long-design' ) ); ?>"
                    data-gallery="project-gallery"
                    data-description="<?php echo esc_attr( $image_caption ); ?>"
                    data-gallery-index="<?php echo esc_attr( $index ); ?>"
                >
                    <?php echo wp_get_attachment_image(
                        $image_id,
                        'medium_large',
                        false,
                        [
                            'class'   => 'project-gallery__image',
                            'alt'     => esc_attr( $image_alt ),
                            'loading' => $index < 4 ? 'eager' : 'lazy',
                        ]
                    ); ?>
                </a>

                <?php if ( $image_caption ) : ?>
                    <figcaption class="project-gallery__caption">
                        <?php echo esc_html( $image_caption ); ?>
                    </figcaption>
                <?php endif; ?>
            </figure>

        <?php endforeach; ?>
    </div><!-- .project-gallery__grid -->

</section><!-- .project-gallery -->