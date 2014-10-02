<?php
global $wp_query;
$post_id = get_the_ID();
$title = get_the_title();
$url = get_permalink();
?>

			<article id="post-<?php echo $post_id; ?>" >
				
				<div class="post-content clearfix">
									
					<?php if ( (function_exists('has_post_thumbnail')) && ( has_post_thumbnail() )  ) { /* if post has post thumbnail */ ?>
									<div class="post-thumb">
										<a href="<?php echo $url; ?>" rel="bookmark" title="<?php echo $title; ?>"><?php the_post_thumbnail('pbp-large'); /* post thumbnail settings configured in functions.php */ ?></a>
									</div>
									<?php } ?>
										
														
										<header>
						
											<h1 class="post-title">
												
													<a href="<?php echo $url; ?>" title="<?php echo $title; ?>" rel="bookmark"> <?php echo $title; ?> </a>
						
											</h1>
											<?php the_excerpt();	?>
										</header>
						
								</div><!-- .post-content -->
						
							</article><!-- #post-<?php echo $post_id; ?> -->