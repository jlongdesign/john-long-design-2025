<?php
/**
 * Architectural divider line partial.
 *
 * Usage:
 *   Left-aligned (default):
 *     get_template_part('partials/divider-arch');
 *
 *   Centered variant:
 *     get_template_part('partials/divider-arch', null, ['center' => true]);
 *
 *   Or use the HTML classes directly:
 *     <div class="divider-arch" aria-hidden="true"></div>
 *     <div class="divider-arch divider-arch--center" aria-hidden="true"><span class="divider-arch__accent"></span></div>
 */

$args   = isset( $args ) ? $args : [];
$center = ! empty( $args['center'] );
?>

<?php if ( $center ) : ?>
<div class="divider-arch divider-arch--center" aria-hidden="true">
    <span class="divider-arch__accent"></span>
</div>
<?php else : ?>
<div class="divider-arch" aria-hidden="true"></div>
<?php endif; ?>
