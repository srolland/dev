<?php
/*
Template Name: HIO - Show (S01E02)
*/
get_header(); ?>
<?php /* include theme options */ include( TEMPLATEPATH . '/functions/get-options.php' ); ?>
			
			<style>
			
				#content-container {
					
					background: url( <?php bloginfo('template_directory'); ?>/_img/hio-show/hio_show_content_bg.jpg ) center 240px fixed!important;
/* 					background-position: center top!important; */
/* 					background-color: #ffab00!important; */
					
				}
				
				#single-column-left {
					width: 620px;
					
				}
				
				.entry-header {
					margin-bottom: 0!important;
					margin-top: 10px;
				}
				
				.hio-header-box {
		
				}
				
				.hio-header-logo-box {
					width: 174px;
					height: 66px;
					float: left;
				}
				
				.hio-header-intro-box {
					width: 420px;
					background: white;
					float: right;
/* 					font-weight: bold; */
					font-size: 12px;
					color: #000;
					padding-top: 5px;
					line-height: 18px;
				}
				
				.entry-content {
					margin-bottom: 10px!important;
					
				}
				
				.entry-content h2 {
					
					font-style: 14px;
					color: #2e447e;
					font-weight: bold;
					
				}
				
				
				
				.entry-content .entry-video-content {
					width: 620px;
					height: 349px;
					background-color: #000;
					
				}
				
				
				.hio-footer-header-box {
					font-size: 12px;
					font-weight: bold;
					color: #000;
					border-bottom: 1px solid #000;
					margin-bottom: 10px;
					text-transform: uppercase;
				}
				
				.hio-footer-host-box {
					width: 620px;
					color: #000;
					float: left;
					margin-bottom: 15px;
					
				}
				
				.hio-footer-host-image-box {
					width: 100px;
					height: 100px;
					border: 1px solid #000;
					float: left;
					
				}
				
				.hio-footer-host-info-box {
					width: 510px;
					float: right;
					font-size: 12px;
				}
				
				
				.clear_it {
					font-size: 0px;
					line-height: 0px;
					height: 0;
					border: 0px none;
					margin: 0;
					padding: 0;
					clear: both;
					
				}
				
				
				#foot-notes {
					display: none;
					
				}
				
			</style>
			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
				<!--BEGIN .hentry -->
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<?php if ( function_exists('yoast_breadcrumb') ) : ?> <p class="breadcrumb"><?php yoast_breadcrumb(); ?></p><?php endif; ?>
<!--                     		<div class="entry-meta entry-header"> -->
<!-- 								<span class="published"><?php the_time( get_option('date_format') ); ?></span> -->
<!-- 								<span class="meta-sep">&middot;</span> -->
<!-- 								<span class="comment-count"><?php comments_popup_link(__('No comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></span><br /> -->
							<!--END .entry-meta entry-header -->
<!-- 							</div> -->
<!-- 					<h1 class="entry-title single-entry-title"><?php the_title(); ?></h1> -->
					
					<!-- BEGIN #single-columns -->
					<div id="single-columns" class="clearfix">
					
						<!-- BEGIN #single-column-left-->
						<div id="single-column-left">
						
							<!--BEGIN .entry-meta .entry-header-->
							<div class="entry-meta entry-header">
								
								<div class="hio-header-box">
									<div class="hio-header-logo-box">
										<img src="<?php bloginfo('template_directory'); ?>/_img/hio-show/hio_show_logo.png" alt="hio_show_logo" width="174" height="66" />
									</div>
									<div class="hio-header-intro-box">
										Welcome to the Hockey Inside/Out Show.  Host Stu Cowan and his guests engage in spirited, yet good natured, debates centered around the NHL, more specifically the Montreal Canadiens.
									</div>
								</div>
								
								<div class="clear_it"></div>
							<!--END .entry-meta entry-header -->
							</div>
							
	
							                            
							<!--BEGIN .entry-content -->
							<div class="entry-content">
								<?php the_content(); ?>
                            
                            <!--END .entry-content -->
                            </div>
                            
                            
                            <!--BEGIN .entry-meta .entry-footer-->
							<div class="entry-meta entry-footer">
								<div class="hio-footer-box">
									
									<div class="hio-footer-host-box">
										<div class="hio-footer-header-box">
											Stu Cowan - Host
										</div>
										<div class="hio-footer-host-image-box">
											<img src="<?php bloginfo('template_directory'); ?>/_img/hio-show/Stu_Cowan.jpeg" alt="Stu Cowan"></div>
										<div class="hio-footer-host-info-box">
											<p>
												Montrealer Stu has been part of The Gazette sports department for over 25 years. Apart from overseeing the sports department, he writes a Saturday column, oversees <a href="http://staging.hockeyinsideout.com" target="_blank">hockeyinsideout.com</a> and blogs about sports at <a href="http://montrealgazette.com/stuonsports" target="_blank">montrealgazette.com/stuonsports</a>.
											</p>
										</div>
										<div class="clear_it"></div>
									</div>
									

									
									
									<div class="hio-footer-host-box" >
										<div class="hio-footer-header-box">
											Dave Stubbs - GAZETTE COLUMNIST
										</div>
										<div class="hio-footer-host-image-box">
											<img src="<?php bloginfo('template_directory'); ?>/_img/hio-show/Dave_Stubbs.jpg" alt="Stu Cowan"></div>
										<div class="hio-footer-host-info-box">
											<p>
												
Dave has been profiling people in the world of sports for over three decades. He is a Gazette columnist and sports feature writer who blogs news and his views on all things Canadiens at <a href="http://staging.hockeyinsideout.com" target="_blank">hockeyinsideout.com</a>.
												
											</p>
										</div>
										<div class="clear_it"></div>
									</div>
									
									
									<div class="hio-footer-host-box" >
										<div class="hio-footer-header-box">
											Jacques Demers - Guest
										</div>
										<div class="hio-footer-host-image-box">
											<img src="<?php bloginfo('template_directory'); ?>/_img/hio-show/Jacques_Demers.jpg" alt="Stu Cowan"></div>
										<div class="hio-footer-host-info-box">
											<p>
												
Jacques Demers is the last man to coach the Canadiens to a Stanley Cup championship in 1993. He also coached the Quebec Nordiques, St. Louis Blues, Detroit Red Wings and Tampa Bay Lightning, and has worked in sports media. In 2009, he was nominated by Prime Minister Stephen Harper to fill a Canadian Senate seat.
												
											</p>
										</div>
										<div class="clear_it"></div>
									</div>
									
									
								</div>
							<!--END .entry-meta entry-footer -->	
							</div>	
								
						
						<!-- END #single-column-left-->
						</div>
					
					
					<!-- END #single-columns -->
					</div>
                
                <!--END .hentry-->  
				</div>

				<?php comments_template('', true); ?>
				
				<!--BEGIN .navigation .single-page-navigation -->
				<div class="navigation single-page-navigation">
					<!--
<div class="nav-previous"><?php previous_post_link('&larr; %link') ?></div>
					<div class="nav-next"><?php next_post_link('%link &rarr;') ?></div>
-->
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