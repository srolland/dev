<?php get_header(); ?>
<?php /* include theme options */ include( TEMPLATEPATH . '/functions/get-options.php' ); ?>
			
			
			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
				<!--BEGIN .hentry -->
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<?php if ( function_exists('yoast_breadcrumb') ) : ?> <p class="breadcrumb"><?php yoast_breadcrumb(); ?></p><?php endif; ?>
                    <div class="entry-meta entry-header">
								<span class="published"><?php the_time( get_option('date_format') ); ?></span>
								<span class="meta-sep">&middot;</span>
								<span class="comment-count"><?php comments_popup_link(__('No comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></span><br />
							<!--END .entry-meta entry-header -->
							</div>
					<h1 class="entry-title single-entry-title"><?php the_title(); ?></h1>
					
					<!-- BEGIN #single-columns -->
					<div id="single-columns" class="clearfix">
					
									<!-- BEGIN #top-sharing-tool-box-->
						<div id="top-sharing-tool-box" class="clearfix">
						<?php if ($tz_sharing_enable == "true" && 'AA' == 'BB' ) { /* Display 468x60 banner if checked in theme options */ ?>
							<ul class="share">
								<?php if ($tz_enable_twitter == "true") { /* Display Twitter link if checked in theme options */ ?>
								<li class="tweet"><a href="http://twitter.com/home/?status=<?php the_title(); ?>&nbsp;-&nbsp;<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Tweet this post</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_fb == "true") { /* Display Facebook link if checked in theme options */ ?>
								<li class="fb"><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>?t=<?php the_title(); ?>" title="Post to Facebook" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Post to Facebook</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_digg == "true") { /* Display Digg link if checked in theme options */ ?>
								<li class="digg"><a href="http://digg.com/submit?url=<?php the_permalink();?>&amp;title=<?php the_title(); ?>&amp;thumbnails=1" title="Digg this!">Digg this!</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_reddit == "true") { /* Display Reddit link if checked in theme options */ ?>
								<li class="reddit"><a href="http://www.reddit.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" title="Share on Reddit">Share on Reddit</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_del == "true") { /* Display Deliciouos link if checked in theme options */ ?>
								<li class="del"><a href="http://del.icio.us/post?url=<?php the_permalink();?>&amp;title=<?php the_title(); ?>" title="Add To Delicious">Add to Delicious</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_stumble == "true") { /* Display Stumble link if checked in theme options */ ?>
								<li class="stumble"><a href="http://www.stumbleupon.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" title="Stumble this">Stumble this</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_google == "true") { /* Display Google + link if checked in theme options */ ?>
								<li class="gbuzz"><a href="https://plus.google.com/share?url=<?php the_permalink();?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Google +</a></li>
  
						  		<?php } ?>
								
								<?php if ($tz_enable_ybuzz == "true") { /* Display Yahoo Buzz link if checked in theme options */ ?>
								<li class="ybuzz"><a href="http://buzz.yahoo.com/submit/?submitUrl=<?php the_permalink(); ?>&amp;submitHeadline=<?php the_title(); ?>" title="Yahoo Buzz">Yahoo Buzz</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_techno == "true") { /* Display Technorati link if checked in theme options */ ?>
								<li class="techno"><a href="http://technorati.com/signup/?f=favorites&amp;Url=<?php the_permalink(); ?>" title="Post to Technorati">Post to Technorati</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_linkedin == "true") { /* Display Linkedin link if checked in theme options */ ?>
								<li class="linkedin"><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>&amp;source="  title="Share on Linkedin">Share on Linkedin</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_email == "true") { /* Display email link if checked in theme options */ ?>
								<li class="email"><a href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>">Email a friend</a></li>
								<?php } ?>
								
							</ul>
						<?php } ?>	
						
						<ul class="rss">
						<?php
						foreach((get_the_category()) as $category) { // Get all categories of that post
						
							$tz_slug = $category->category_nicename; 
							$tz_url = get_bloginfo('url');
							$tz_catname = $category->cat_name;
							
							// Display feed links for each category
							echo '<li><a href="'.$tz_url.'/category/'.$tz_slug.'/feed">'.$tz_catname.'</a></li>';
						} 
						?>
						</ul>
									
						<!-- END #top-sharing-tool-box -->
						</div>
					
						<!-- BEGIN #single-column-left-->
						<div id="single-column-left">
						
							<!--BEGIN .entry-meta .entry-header-->
							<div class="entry-meta entry-header">
								<span class="author"><?php _e('Posted by', 'framework') ?> <?php the_author_posts_link(); ?></span>
							<!--END .entry-meta entry-header -->
							</div>
							
							<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) { /* if post has post thumbnail */ ?>
							<div class="post-thumb">
								<?php the_post_thumbnail('lead-image'); /* post thumbnail settings configured in functions.php */ ?>
								<?php //the_post_thumbnail('pbp-large'); /* post thumbnail settings configured in functions.php */ ?>
								
							</div>
							<?php } ?>
							                            
							<!--BEGIN .entry-content -->
							<div class="entry-content">
								<?php 
									
									$qqp_in_the_game_id = get_post_meta( $post->ID, 'qqp_in_the_game_id', true );
									if ( !empty( $qqp_in_the_game_id ) ) {
										$qqp_in_the_game = get_post( $qqp_in_the_game_id );
										
										$scribblelive_id = get_post_meta( $qqp_in_the_game->ID, 'scribblelive_id', true );
										
										$concent_pre_game_title = get_post_meta( $qqp_in_the_game->ID, 'concent_pre_game_title', true );
										$concentpregamecontent = get_post_meta( $qqp_in_the_game->ID, 'concentpregamecontent', true );
										$concent_p1_title = get_post_meta( $qqp_in_the_game->ID, 'concent_p1_title', true );
										$concentp1content = get_post_meta( $qqp_in_the_game->ID, 'concentp1content', true );
										$concent_p2_title = get_post_meta( $qqp_in_the_game->ID, 'concent_p2_title', true );
										$concentp2content = get_post_meta( $qqp_in_the_game->ID, 'concentp2content', true );
										$concent_p3_title = get_post_meta( $qqp_in_the_game->ID, 'concent_p3_title', true );
										$concentp3content = get_post_meta( $qqp_in_the_game->ID, 'concentp3content', true );
										$concent_overtime_title = get_post_meta( $qqp_in_the_game->ID, 'concent_overtime_title', true );
										$concentovertimecontent = get_post_meta( $qqp_in_the_game->ID, 'concentovertimecontent', true );
										$concent_post_game_title = get_post_meta( $qqp_in_the_game->ID, 'concent_post_game_title', true );
										$concentpostgamecontent = get_post_meta( $qqp_in_the_game->ID, 'concentpostgamecontent', true );


										
										if ( !empty( $concent_post_game_title ) ) { echo '<h2 title="Post Game" class="expend">' . $concent_post_game_title . '</h2>'; }
										if ( !empty( $concentpostgamecontent ) ) { echo '<div>' . wpautop( $concentpostgamecontent ) . '</div>'; }
					
										if ( !empty( $concent_overtime_title ) ) { echo '<h2 title="Overtime" class="expend">' . $concent_overtime_title . '</h2>'; }
										if ( !empty( $concentovertimecontent ) ) { echo '<div>' . wpautop( $concentovertimecontent ) . '</div>'; }
					
										if ( !empty( $concent_p3_title ) ) { echo '<h2 title="3rd Period" class="expend">' . $concent_p3_title . '</h2>'; }
										if ( !empty( $concentp3content ) ) { echo '<div>' . wpautop( $concentp3content ) . '</div>'; }
					
										if ( !empty( $concent_p2_title ) ) { echo '<h2 title="2nd Period" class="expend">' . $concent_p2_title . '</h2>'; }
										if ( !empty( $concentp2content ) ) { echo '<div>' . wpautop( $concentp2content ) . '</div>'; }
										
										if ( !empty( $concent_p1_title ) ) { echo '<h2 title="1st Period" class="expend">' . $concent_p1_title . '</h2>'; }
										if ( !empty( $concentp1content ) ) { echo '<div>' . wpautop( $concentp1content ) . '</div>'; }
										
										if ( !empty( $concent_pre_game_title ) ) { echo '<h2 title="Pre Game" class="expend">' . $concent_pre_game_title . '</h2>'; }
										if ( !empty( $concentpregamecontent ) ) { echo '<div>' . wpautop( $concentpregamecontent ) . '</div>'; }



										
										$permalink = get_permalink( $qqp_in_the_game->ID );
										
										echo '<a href="' . $permalink . '">';
										echo '<img src="/wp-content/themes/deadline/_img/HIO_pbp-300.jpg" width="300" height="100">';
										echo '</a>';
										
										
										echo '<a href="/show" style="float:right;">';
										echo '<img src="http://staging.hockeyinsideout.com/wp-content/uploads/2013/03/HIO_final2.jpg" width="300" height="100">';
										echo '</a>';
										
										
										
										
									} else {
										
										the_content();
										
									}
									
									if ( !empty( $scribblelive_id ) ) {
										echo "<iframe src='http://embed.scribblelive.com/Embed/v5.aspx?Id=" . $scribblelive_id . "&ThemeId=13872' width='618' height='400' frameborder='0' style='border: 1px solid #000'></iframe>";
										
									} else {
										if ( get_post_custom_values( 'LiveblogEmbedCode' ) ){ 
											$liveblogembed = get_post_custom_values( 'LiveblogEmbedCode' );  
											echo $liveblogembed[0];
										} 
									}
													
									
								?>
								
								
							
								
								<script type="text/javascript">
									jQuery( document ).ready( function () {
										
										var is_first_expend = true;
										jQuery( 'h2.expend' ).each( function() {

											//console.log( this )
											
											
											
											
											var $this = jQuery( this );
											
											var expend_btn = jQuery( '<div>' )
																.addClass( 'expend_header_toggle' )
																.text( '- Hide' )
																.toggle( function() {
																	jQuery( this ).text( '+ Show' )
																	$this.slideUp();
																	$this.next().slideUp();
																	
																	
																}, function () {
																	jQuery( this ).text( '- Hide' )
																	$this.slideDown();
																	$this.next().slideDown();
																	
																	
																})
											
											var header_html = jQuery( '<div>' )
																.addClass( 'expend_header' )
																.text( $this.attr( 'title' ) )
																.append(
																	expend_btn
																)
																.click( function () {
																	expend_btn.trigger( 'click' );
																})
																
											$this.before( header_html );					
																
											if ( !is_first_expend ) {
												expend_btn.trigger( 'click' );
											}
											is_first_expend = false;
											
											

										});
										
										
										
										
										
										
									});
								</script>
								
								
								<style>
									
									.expend_header {
										margin: 10px 0;
										color: #DA0000;
										font-weight: bold;
										font-size: 11px;
										background: url(/wp-content/themes/deadline/images/bg-dots.png) left bottom repeat-x;
										padding: 0 0 10px 0;
										margin: 0 0 10px 0;
										cursor: pointer;
									}
									
									.expend_header_toggle {
										
										float: right;
										font-weight: normal;
									}
									
									
								</style>
								
<?php //var_dump(get_post_custom($post->ID));
	//	$ooyala_meta =  get_post_meta($post->ID, '_ooyala_id', true);  
		
		//$ooyala_id = $ooyala_meta['name'];
		
		?>

<!--Kaltura Video player-->
<!--
<?php if (is_category('Show') || in_category('Show')) { ?>
<?php echo '<div style="width:600px;">
  <div id="myPlayer">
  </div>
</div>' ?>
<script type="text/javascript">

var ooyala_id = <?php echo $ooyala_id; ?>;    
	    
      $(function () {
 
                var params = {
                    videoId: '',
                    referenceId: ooyala_id,
                    playListId:'1_1rhyhiwy',
                    targetId: 'myPlayer'
                };
 
var url = 'http://app.canada.com/Video/video.svc/loader/?';
for (var key in params) { url += key + '=' + escape(params[key]) + '&'; }
var pv = document.createElement('script'); pv.type = 'text/javascript'; pv.async = true; pv.src = url.slice(0, -1);
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(pv, s);
})();

    </script>
    <?php } ?>-->
<!--End of Kaltura Video player-->

                         
                            <!--END .entry-content -->
                            </div>
							
							<?php if /* if the author bio is checked in admin options then show and author bio box */ ($tz_author_bio == "true") { ?>
							<!--BEGIN .author-bio-->
							<div class="author-bio">
								<h3 class="widget-title author-title"><?php _e('About the author', 'framework') ?></h3>
								<div class="author-content clearfix">
									<?php echo get_avatar( get_the_author_email(), '75' ); ?>
									<div class="author-description"><?php the_author_meta("description"); ?></div>
								</div>
							<!--END .author-bio-->
							</div>
							<?php } ?>
							
							<?php if ( !$qqp_in_the_game_id ) { ?>
							<?php include( TEMPLATEPATH . '/includes/related-posts.php' ); ?>
							<?php } ?>
						
						<!-- END #single-column-left-->
						</div>
						
						<!-- BEGIN #single-column-right-->
						<div id="single-column-right">
						<?php if ($tz_sharing_enable == "true") { /* Display 468x60 banner if checked in theme options */ ?>
							<ul class="share">
								<?php if ($tz_enable_twitter == "true") { /* Display Twitter link if checked in theme options */ ?>
								<li class="tweet"><a href="http://twitter.com/home/?status=<?php the_title(); ?>&nbsp;-&nbsp;<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Tweet this post</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_fb == "true") { /* Display Facebook link if checked in theme options */ ?>
								<li class="fb"><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>?t=<?php the_title(); ?>" title="Post to Facebook" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Post to Facebook</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_digg == "true") { /* Display Digg link if checked in theme options */ ?>
								<li class="digg"><a href="http://digg.com/submit?url=<?php the_permalink();?>&amp;title=<?php the_title(); ?>&amp;thumbnails=1" title="Digg this!">Digg this!</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_reddit == "true") { /* Display Reddit link if checked in theme options */ ?>
								<li class="reddit"><a href="http://www.reddit.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" title="Share on Reddit">Share on Reddit</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_del == "true") { /* Display Deliciouos link if checked in theme options */ ?>
								<li class="del"><a href="http://del.icio.us/post?url=<?php the_permalink();?>&amp;title=<?php the_title(); ?>" title="Add To Delicious">Add to Delicious</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_stumble == "true") { /* Display Stumble link if checked in theme options */ ?>
								<li class="stumble"><a href="http://www.stumbleupon.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" title="Stumble this">Stumble this</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_google == "true") { /* Display Google + link if checked in theme options */ ?>
								<li class="gbuzz"><a href="https://plus.google.com/share?url=<?php the_permalink();?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">Google +</a></li>
  
						  		<?php } ?>
								
								<?php if ($tz_enable_ybuzz == "true") { /* Display Yahoo Buzz link if checked in theme options */ ?>
								<li class="ybuzz"><a href="http://buzz.yahoo.com/submit/?submitUrl=<?php the_permalink(); ?>&amp;submitHeadline=<?php the_title(); ?>" title="Yahoo Buzz">Yahoo Buzz</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_techno == "true") { /* Display Technorati link if checked in theme options */ ?>
								<li class="techno"><a href="http://technorati.com/signup/?f=favorites&amp;Url=<?php the_permalink(); ?>" title="Post to Technorati">Post to Technorati</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_linkedin == "true") { /* Display Linkedin link if checked in theme options */ ?>
								<li class="linkedin"><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>&amp;source="  title="Share on Linkedin">Share on Linkedin</a></li>
								<?php } ?>
								
								<?php if ($tz_enable_email == "true") { /* Display email link if checked in theme options */ ?>
								<li class="email"><a href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>">Email a friend</a></li>
								<?php } ?>
								
							</ul>
						<?php } ?>	
						
						<ul class="rss">
						<?php
						foreach((get_the_category()) as $category) { // Get all categories of that post
						
							$tz_slug = $category->category_nicename; 
							$tz_url = get_bloginfo('url');
							$tz_catname = $category->cat_name;
							
							// Display feed links for each category
							echo '<li><a href="'.$tz_url.'/category/'.$tz_slug.'/feed">'.$tz_catname.'</a></li>';
						} 
						?>
						</ul>
									
						<!-- END #single-column-right-->
						</div>
					
					
					<!-- END #single-columns -->
					</div>
                
                <!--END .hentry-->  
				</div>

				<?php comments_template('', true); ?>
				
				<!--BEGIN .navigation .single-page-navigation -->
				<div class="navigation single-page-navigation">
					<div class="nav-previous"><?php previous_post_link('&larr; %link') ?></div>
					<div class="nav-next"><?php next_post_link('%link &rarr;') ?></div>
				<!--END .navigation .single-page-navigation -->
				</div>

				<?php endwhile; else: ?>

				<!--BEGIN #post-0-->
				<div id="post-0" <?php post_class() ?>>
				
					<h1 class="entry-title"><?php _e('Error 404 - Not Found', 'framework') ?></h1>
				
					<!--BEGIN .entry-content-->
					<div class="entry-content">
						<p><?php _e("Sorry, but you are looking for something that isn't here.", "framework") ?></p>
						<?php get_search_form(); ?>
					<!--END .entry-content-->
					</div>
				
				<!--END #post-0-->
				</div>

			<?php endif; ?>
			<!--END #primary .hfeed-->
			</div>

<?php include( TEMPLATEPATH . '/sidebar-page.php' ); ?>

<?php get_footer(); ?>
