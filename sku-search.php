<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main sds-search-results" role="main">

			<?php
				// do_action( 'storefront_page_before' );
			?>
			<h1 class="entry-title">Safety Data Sheets</h1>
			<div class="sds-search-container">
				<p>To search for any Falcon, Dust-Off or Century brand SDS (Safety Data Sheet) please enter the product Model # located on the back of the product package. To search for an SDS for any of our private label brands, just enter the brand name.</p>
				<p>If you have any difficulty finding an SDS, please e-mail us at <a href="mailto:msds@falconsafety.com">msds@falconsafety.com</a> <br>Thank you for your interest in our products!</p>
				<div class="sds-search-form-wrap"><?php echo do_shortcode('[sm_search_form]'); ?></div>
			</div>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php

					// An array of arguments
					$args = array( 'post_type' => 'sds', 'tax_query' => array( array( 'taxonomy' => 'post_tag', 'field' => 'slug', 'terms' => get_query_var('sku') ), ), 'posts_per_page' => '-1' );
					// The Query
					$the_query = new WP_Query( $args );

					// The Loop
					if ( $the_query->have_posts() ) {

						$s_term = get_query_var('sku');

						?>


						<h4>Search Results for: <em><?php echo get_query_var('sku'); ?></em></h4>

						<?php
						
						while ( $the_query->have_posts() ) : $the_query->the_post(); 
							// the_title();

							// $sds_title = the_title();

							$file = get_field('sds_pdf');

							/*$feat_image_url = wp_get_attachment_url( get_post_thumbnail_id() );
							$post_thumbnail_id = get_post_thumbnail_id();
							echo ($post_thumbnail_id);
							echo ($feat_image_url);
							wp_get_attachment_url( $file );*/

							if( $file ): 
								// vars
								$url = $file['url'];
								$title = $file['title'];
								$caption = $file['caption'];
								$sdsid = $file['id'];
								$alt = $file['description'];
								$icon =  $file['sizes']['thumbnail'];
								// echo ($image);
								// echo wp_get_attachment_image( $file );


								// icon
								// $icon = $file['icon'];
								$icon =  wp_get_attachment_image( $attachment->ID, 'full' );

								$thumbnail_url = wp_get_attachment_image_src( $sdsid, 'thumbnail', true );
								$thumbnail_url = $thumbnail_url[0];
								// echo ($thumbnail_url);
								// echo ( !empty($thumbnail_url) ) ? $thumbnail_url : '/wp-content/uploads/images/sds-thumb.jpg';

								?>
								<div class="sds-search-result">
									<a href="<?php echo $url; ?>" title="<?php echo $title; ?>" target="_blank">
										
										<img class="sds-pdf-thumb" src="<?php echo $thumbnail_url; ?>" alt="<?php echo $alt; ?>" />
										<p class="sds-title"><?php the_title(); ?></p>
									</a>
								</div>


							<?php endif;

																		
										

											/*// load selected file (from post)
											$file = get_field('sds_pdf'); 

											if( $file ): 
												
												// load selected thumbnail (from attachment)
												$thumbnail = get_field('sds_pdf', $file['ID']); 
												echo $thumbnail;
												
												?>
												
												<h2>Read more!</h2>
												<div class="file">
													<a href="<?php echo $file['url']; ?>">
														<?php if( $thumbnail ): ?>
															<img class="thumbnail" src="<?php echo $thumbnail['url']; ?>" alt="<?php echo $thumbnail['alt']; ?>" />
														<?php endif; ?>
														<span><?php echo $file['filename']; ?></span>
													</a>
												</div>
											<?php endif;*/
							
						endwhile;
						
					} else {
					        echo '<p>No SDS Found.</p>';
					}
					/* Restore original Post Data */
					wp_reset_postdata();



				?>

				</div>

				<?php


				/**
				 * Functions hooked in to storefront_page_after action
				 *
				 * @hooked storefront_display_comments - 10
				 */
				do_action( 'storefront_page_after' );

			// End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
do_action( 'storefront_sidebar' );
get_footer();
