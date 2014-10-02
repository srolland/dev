<?php
/*
Template Name: HIO - Show (Archive)
*/
get_header(); ?>
<?php /* include theme options */ include( TEMPLATEPATH . '/functions/get-options.php' ); ?>
			
			<style>
			
				#content-container {
/* 					background: #FFF!important; */
					/* background: url( <?php bloginfo('template_directory'); ?>/_img/hio-show/hio_show_content_bg.jpg ) center 240px fixed!important; */
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
					float: right;
/* 					font-weight: bold; */
					font-size: 12px;
					color: #000;
					padding-top: 5px;
					line-height: 18px;
				}
				
				.entry-content .entry-meta {
					margin: 0!important;
					padding: 0!important;
					text-transform: uppercase;
				}
				
				
				
				.entry-content {
					margin-bottom: 10px!important;
					
				}
				
				.show_archive_box .entry-content {
					margin-bottom: 10px!important;
					width: 290px;					
				}
				.entry-content h2 {
					
					font-style: 14px;
					color: #2e447e;
					font-weight: bold;
					margin: 0!important;
					padding: 0!important;
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
				
				
				
				.previous_show_box {
					border-bottom: 1px solid #d80200;
					padding: 0!important;
					margin: 25px 0 15px 0;
				}
				
				
				.previous_show_content {
					background-color: #d80200;
					color: #FFF;
					margin: 0!important;
					padding: 4px 10px;
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
								<a href="/show/welcome-to-knuckles-korner">
								<img src="http://staging.hockeyinsideout.com/wp-content/uploads/2013/10/nilan-corner.jpg" width="620" height="349"></a>
								
								<div class="entry-meta"></div>
								
								<h2>Nilan back on HIO Show for Episode 3</h2>
                            
								<p>Hockey Night in Canada has Don Cherry and the HIO Show has Chris “Knuckles” Nilan back as a guest this week to discuss Lars Eller’s controversial comments about the Edmonton Oilers being like a “junior team”, some advice for P.K. Subban, and his thoughts about the new helmet rule for fighting. [<a href="/show/welcome-to-knuckles-korner">watch now</a>]</p>
                            
                            
                            <!--END .entry-content -->
                            </div>
                            
                            
 
						
						
						
						<div class="previous_show_box">
							<span class="previous_show_content">Previous Shows</span>
						</div>
						
						
						<!-- Archives START -->
						<div class="show_archive_box">
							
								<div class="entry-content" style="float:right;">
								<a href="/show/season-premiere">
								<img src="http://staging.hockeyinsideout.com/wp-content/uploads/2013/10/show1.jpg" width="290" height="162"></a>
								
								<div class="entry-meta">
								October 9, 2013
								</div>
								
								<h2>Season premiere with Hickey and Todd</h2>
                            
								<p>In the first episode of our now weekly HIO Show, Canadiens beat writer Pat Hickey and Monday Morning QB Jack Todd join sports editor Stu Cowan to discuss the Habs’ start to the season. [<a href="/show/season-premiere">watch now</a>]</p>

                            </div> 
							
							
							<!--BEGIN .entry-content -->
							<div class="entry-content">
								<a href="/show/nilan-drops-the-gloves-for-hio-show">
								<img src="http://staging.hockeyinsideout.com/wp-content/uploads/2013/10/nylan-show.jpg" width="290" height="162"></a>
								
								<div class="entry-meta">
								October 16, 2013
								</div>
								
								<h2>Former Hab joins Stubbs, Cowan for Episode 2</h2>
                            
								<p>In Episode 2 of our weekly HIO Show, Gazette columnist Dave Stubbs and former Canadien Chris Nilan join sports editor Stu Cowan to discuss the latest news about the Canadiens – and Stubbs’s bowtie. [<a href="/show/nilan-drops-the-gloves-for-hio-show">watch now</a>]</p>
                            
                            
                            <!--END .entry-content -->
                            </div>
					
                            
                            
                            
							
                            
                    
						
						
						
						
						</div>
						
						
						
						
						
						
						<!-- END #single-column-left-->
						</div>
						
						

					<!-- END #single-columns -->
					</div>
                
                <!--END .hentry-->  
				</div>

				<?php //comments_template('', true); ?>
				
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