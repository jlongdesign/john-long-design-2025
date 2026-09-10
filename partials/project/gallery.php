<?php
/**
 * Project Gallery Partial
 *
 * Displays a gallery of images for a single portfolio project.
 * Reads image IDs saved by the Project Gallery meta box.
 */

$raw_ids      = get_post_meta( get_the_ID(), '_project_gallery_ids', true );
$gallery_ids  = ! empty( $raw_ids ) ? array_filter( array_map( 'absint', explode( ',', $raw_ids ) ) ) : [];

$devices_raw = get_post_meta( get_the_ID(), '_project_gallery_devices', true );
$devices     = $devices_raw ? json_decode( $devices_raw, true ) : [];
if ( ! is_array( $devices ) ) {
    $devices = [];
}

if ( empty( $gallery_ids ) ) {
    return;
}
?>

<section class="project-gallery container py-4" aria-label="Project Gallery">

    <div class="text-center mb-4">
        <h2 class="display-5 fw-bold mb-4"><?php _e( 'Project Gallery', 'john-long-design' ); ?></h2>
        <p class="lead text-muted">
            <?php _e( 'Click a desktop screenshot to view it full size, or scroll within a mobile frame to see more.', 'john-long-design' ); ?>
        </p>
    </div>

    <div class="project-gallery__grid">
        <?php foreach ( $gallery_ids as $index => $image_id ) :

            $image_full    = wp_get_attachment_image_url( $image_id, 'full' );
            $image_alt     = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
            $image_caption = wp_get_attachment_caption( $image_id );

            // Use the manually assigned device type, falling back to aspect ratio for unset images.
            if ( isset( $devices[ $image_id ] ) ) {
                $device = 'mobile' === $devices[ $image_id ] ? 'mobile' : 'desktop';
            } else {
                $image_meta = wp_get_attachment_metadata( $image_id );
                $img_width  = ! empty( $image_meta['width'] ) ? (int) $image_meta['width'] : 0;
                $img_height = ! empty( $image_meta['height'] ) ? (int) $image_meta['height'] : 0;
                $device     = ( $img_height > $img_width ) ? 'mobile' : 'desktop';
            }
        ?>

            <figure class="project-gallery__item project-gallery__item--<?php echo esc_attr( $device ); ?>" data-index="<?php echo esc_attr( $index ); ?>">
                <div class="device-frame device-frame--<?php echo esc_attr( $device ); ?>">

                    <?php if ( 'desktop' === $device ) : ?>
                        <div class="device-frame__bar">
                            <span class="device-frame__dot device-frame__dot--red"></span>
                            <span class="device-frame__dot device-frame__dot--yellow"></span>
                            <span class="device-frame__dot device-frame__dot--green"></span>
                            <span class="device-frame__address"><?php echo esc_html( get_the_title() ); ?></span>
                        </div>
                    <?php else : ?>
                        <div class="device-frame__notch"></div>
                        <div class="device-frame__mobile-bar p-2">
                            <span class="device-frame__address"><?php echo esc_html( get_the_title() ); ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="device-frame__screen">
                        <?php
                        $image_tag = wp_get_attachment_image(
                            $image_id,
                            'full',
                            false,
                            [
                                'class'   => 'project-gallery__image',
                                'alt'     => esc_attr( $image_alt ),
                                'loading' => $index < 4 ? 'eager' : 'lazy',
                                // Override WP's default viewport-based guess with the frame's actual rendered width.
                                'sizes'   => 'mobile' === $device ? '280px' : '(max-width: 768px) 90vw, 720px',
                            ]
                        );
                        ?>
                        <?php if ( 'mobile' === $device ) : ?>
                            <?php echo $image_tag; ?>
                        <?php else : ?>
                            <a
                                class="project-gallery__link glightbox"
                                href="<?php echo esc_url( $image_full ); ?>"
                                aria-label="<?php echo esc_attr( $image_alt ? $image_alt : __( 'View image', 'john-long-design' ) ); ?>"
                                data-gallery="project-gallery"
                                data-description="<?php echo esc_attr( $image_caption ); ?>"
                                data-gallery-index="<?php echo esc_attr( $index ); ?>"
                            >
                                <?php echo $image_tag; ?>
                            </a>
                        <?php endif; ?>
                    </div><!-- .device-frame__screen -->

                    <?php if ( 'mobile' === $device ) : ?>
                        <div class="device-frame__home-indicator"></div>
                    <?php endif; ?>

                </div><!-- .device-frame -->

                <p class="project-gallery__scroll-hint">
                    <span class="project-gallery__scroll-icon" aria-hidden="true">&#8597;</span>
                    <?php _e( 'Scroll to see more', 'john-long-design' ); ?>
                </p>

                <?php if ( $image_caption ) : ?>
                    <figcaption class="project-gallery__caption">
                        <?php echo esc_html( $image_caption ); ?>
                    </figcaption>
                <?php endif; ?>
            </figure>

        <?php endforeach; ?>
    </div><!-- .project-gallery__grid -->

</section><!-- .project-gallery -->