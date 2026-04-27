<?php
/**
 * Project Gallery Meta Box
 *
 * Adds a media manager meta box to the project post type
 * for managing gallery images.
 */

/**
 * Register the meta box
 */
function jld_register_project_gallery_metabox() {
    add_meta_box(
        'project_gallery',
        __( 'Project Gallery', 'john-long-design' ),
        'jld_render_project_gallery_metabox',
        'project', // Change this to your portfolio post type slug
        'normal',
        'low'
    );
}
add_action( 'add_meta_boxes', 'jld_register_project_gallery_metabox' );


/**
 * Render the meta box HTML
 */
function jld_render_project_gallery_metabox( $post ) {
    wp_nonce_field( 'jld_project_gallery_save', 'jld_project_gallery_nonce' );

    $gallery_ids = get_post_meta( $post->ID, '_project_gallery_ids', true );
    $gallery_ids = ! empty( $gallery_ids ) ? explode( ',', $gallery_ids ) : [];
    ?>

    <div class="jld-gallery-metabox">
        <p class="description">
            <?php _e( 'Add images to the project gallery. Drag to reorder.', 'john-long-design' ); ?>
        </p>

        <ul class="jld-gallery-metabox__list" id="jld-gallery-list">
            <?php foreach ( $gallery_ids as $image_id ) :
                $image_id = absint( $image_id );
                if ( ! $image_id ) continue;
                $thumb = wp_get_attachment_image_url( $image_id, 'thumbnail' );
                $alt   = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
            ?>
                <li class="jld-gallery-metabox__item" data-id="<?php echo esc_attr( $image_id ); ?>">
                    <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
                    <button type="button" class="jld-gallery-metabox__remove" aria-label="<?php esc_attr_e( 'Remove image', 'john-long-design' ); ?>">&times;</button>
                </li>
            <?php endforeach; ?>
        </ul>

        <input
            type="hidden"
            id="jld-gallery-ids"
            name="jld_project_gallery_ids"
            value="<?php echo esc_attr( implode( ',', $gallery_ids ) ); ?>"
        >

        <button type="button" class="button button-primary" id="jld-gallery-add">
            <?php _e( 'Add / Edit Images', 'john-long-design' ); ?>
        </button>
    </div>

    <style>
        .jld-gallery-metabox { padding: 8px 0; }
        .jld-gallery-metabox__list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 12px 0;
            padding: 0;
            list-style: none;
            min-height: 80px;
        }
        .jld-gallery-metabox__item {
            position: relative;
            width: 80px;
            height: 80px;
            cursor: grab;
        }
        .jld-gallery-metabox__item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 3px;
            border: 1px solid #ddd;
        }
        .jld-gallery-metabox__remove {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: none;
            background: #cc0000;
            color: #fff;
            font-size: 14px;
            line-height: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
    </style>

    <script>
        jQuery( function( $ ) {
            const frame = wp.media({
                title: '<?php echo esc_js( __( 'Select Gallery Images', 'john-long-design' ) ); ?>',
                button: { text: '<?php echo esc_js( __( 'Add to Gallery', 'john-long-design' ) ); ?>' },
                multiple: true
            });

            // Open media frame
            $( '#jld-gallery-add' ).on( 'click', function() {
                frame.open();
            });

            // When images are selected
            frame.on( 'select', function() {
                const attachments = frame.state().get( 'selection' ).toJSON();
                attachments.forEach( function( attachment ) {
                    const id    = attachment.id;
                    const thumb = attachment.sizes.thumbnail
                        ? attachment.sizes.thumbnail.url
                        : attachment.url;
                    const alt   = attachment.alt || '';

                    // Avoid duplicates
                    if ( $( '#jld-gallery-list [data-id="' + id + '"]' ).length ) return;

                    $( '#jld-gallery-list' ).append(
                        `<li class="jld-gallery-metabox__item" data-id="${id}">
                            <img src="${thumb}" alt="${alt}">
                            <button type="button" class="jld-gallery-metabox__remove" aria-label="Remove image">&times;</button>
                        </li>`
                    );
                });
                updateIds();
            });

            // Remove image
            $( '#jld-gallery-list' ).on( 'click', '.jld-gallery-metabox__remove', function() {
                $( this ).closest( 'li' ).remove();
                updateIds();
            });

            // Drag to reorder
            $( '#jld-gallery-list' ).sortable({
                update: updateIds
            });

            // Sync hidden input
            function updateIds() {
                const ids = $( '#jld-gallery-list .jld-gallery-metabox__item' )
                    .map( function() { return $( this ).data( 'id' ); } )
                    .get()
                    .join( ',' );
                $( '#jld-gallery-ids' ).val( ids );
            }
        });
    </script>

    <?php
}


/**
 * Enqueue media scripts on the project edit screen
 */
function jld_enqueue_project_gallery_scripts( $hook ) {
    global $post;

    if ( ! in_array( $hook, [ 'post.php', 'post-new.php' ] ) ) return;
    if ( ! isset( $post ) || $post->post_type !== 'project' ) return; // Match your post type slug

    wp_enqueue_media();
    wp_enqueue_script( 'jquery-ui-sortable' );
}
add_action( 'admin_enqueue_scripts', 'jld_enqueue_project_gallery_scripts' );


/**
 * Save the gallery image IDs
 */
function jld_save_project_gallery( $post_id ) {
    // Verify nonce
    if (
        ! isset( $_POST['jld_project_gallery_nonce'] ) ||
        ! wp_verify_nonce( $_POST['jld_project_gallery_nonce'], 'jld_project_gallery_save' )
    ) {
        return;
    }

    // Bail on autosave or if user can't edit
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    if ( isset( $_POST['jld_project_gallery_ids'] ) ) {
        $raw_ids     = sanitize_text_field( $_POST['jld_project_gallery_ids'] );
        $gallery_ids = array_filter( array_map( 'absint', explode( ',', $raw_ids ) ) );
        update_post_meta( $post_id, '_project_gallery_ids', implode( ',', $gallery_ids ) );
    } else {
        delete_post_meta( $post_id, '_project_gallery_ids' );
    }
}
add_action( 'save_post', 'jld_save_project_gallery' );