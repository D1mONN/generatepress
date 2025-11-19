<?php
/**
 * The template for displaying a single land plot.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div class="land-plot-card">
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="land-plot-card-image">
			<?php the_post_thumbnail( 'medium_large' ); ?>
		</div>
	<?php endif; ?>
	<div class="land-plot-card-content">
		<h3><?php the_title(); ?></h3>
		<p>
			<?php
			$area = get_field( 'area_hectares' );
			if ( $area ) {
				echo 'Area: ' . esc_html( $area ) . ' ha';
			}
			?>
		</p>
	</div>
</div>
