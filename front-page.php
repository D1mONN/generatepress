<?php
/**
 * The template for displaying the front page.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div id="primary" <?php generate_do_element_classes( 'content' ); ?>>
		<main id="main" <?php generate_do_element_classes( 'main' ); ?>>
			<?php
			/**
			 * generate_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_before_main_content' );
			?>

			<div class="inside-article">
				<div class="entry-content">
					<!-- Investment Projects Section -->
					<section id="investment-projects" class="investment-portal-section">
						<h2><?php esc_html_e( 'Investment Projects', 'generatepress' ); ?></h2>
						<?php
						$projects_query = new WP_Query(
							array(
								'post_type'      => 'invest_project',
								'posts_per_page' => -1,
							)
						);

						if ( $projects_query->have_posts() ) :
							?>
							<div class="swiper-container">
								<div class="swiper-wrapper">
									<?php
									while ( $projects_query->have_posts() ) :
										$projects_query->the_post();
										?>
										<div class="swiper-slide">
											<div class="project-card">
												<?php if ( has_post_thumbnail() ) : ?>
													<div class="project-card-image">
														<?php the_post_thumbnail( 'medium_large' ); ?>
													</div>
												<?php endif; ?>
												<div class="project-card-content">
													<h3><?php the_title(); ?></h3>
													<p>
														<?php
														$amount = get_field( 'investment_amount' );
														if ( $amount ) {
															echo 'Investment: ' . esc_html( $amount );
														}
														?>
													</p>
												</div>
											</div>
										</div>
									<?php endwhile; ?>
								</div>
								<div class="swiper-pagination"></div>
								<div class="swiper-button-next"></div>
								<div class="swiper-button-prev"></div>
							</div>
							<?php
							wp_reset_postdata();
						else :
							echo '<p>' . esc_html__( 'No projects found.', 'generatepress' ) . '</p>';
						endif;
						?>
					</section>

					<!-- Land Plots Section -->
					<section id="land-plots" class="investment-portal-section">
						<h2><?php esc_html_e( 'Land Plots', 'generatepress' ); ?></h2>
						<?php
						$plots_query = new WP_Query(
							array(
								'post_type'      => 'land_plot',
								'posts_per_page' => 4,
							)
						);

						if ( $plots_query->have_posts() ) :
							?>
							<div class="land-plots-grid">
								<?php
								while ( $plots_query->have_posts() ) :
									$plots_query->the_post();
									get_template_part( 'template-parts/content', 'land-plot' );
								endwhile;
								?>
							</div>
							<?php
							if ( $plots_query->max_num_pages > 1 ) {
								echo '<button id="load-more-plots" data-page="1" data-max-pages="' . esc_attr( $plots_query->max_num_pages ) . '">' . esc_html__( 'Load More', 'generatepress' ) . '</button>';
							}
							wp_reset_postdata();
						else :
							echo '<p>' . esc_html__( 'No land plots found.', 'generatepress' ) . '</p>';
						endif;
						?>
					</section>
				</div>
			</div>

			<?php
			/**
			 * generate_after_main_content hook.
			 *
			 * @since 1.3.45
			 */
			do_action( 'generate_after_main_content' );
			?>
		</main>
	</div>

	<?php
	/**
	 * generate_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	do_action( 'generate_after_primary_content_area' );

	generate_construct_sidebars();

get_footer();
