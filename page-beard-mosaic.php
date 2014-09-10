<?php
/*
Template Name: Beard Mosaic
*/

get_header(); ?>

			<!--BEGIN #primary .hfeed-->
			<div id="primary" class="hfeed">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<!--BEGIN .hentry-->
				<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<h1 class="entry-title"><?php the_title(); ?></h1>
                    <?php if ( current_user_can( 'edit_post', $post->ID ) ): ?>
                    
                    <!--BEGIN .entry-meta .entry-header-->
					<div class="entry-meta entry-header">
						<?php edit_post_link( __('edit', 'framework'), '<span class="edit-post">[', ']</span>' ); ?>
					<!--END .entry-meta .entry-header-->
                    </div>
                    <?php endif; ?>

					<!--BEGIN .entry-content -->
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'framework').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						
						
						
						<div id="pics"></div>
					<a href="#" id="more" style="clear:both;">Load more</a>
					 
									
						
						
						<div class="notifications-wrapper">
							<div class="notifications"></div>
						</div>
						
						
									<script type="text/javascript"> 
						
						
						
						
						
						
						//var jPics=new Array(<?php foreach($pics as $pic) { echo "\"".$pic."\",";} ?>"end");
						var jPics;
						var waypoint = 0;
						
						function writPics () {
							//pic_count = 0;
							nextPage = jPics.slice(waypoint,(waypoint+10));
							jQuery.each(nextPage, function(i) { 
								if (this != "end"){
									
									//notify('Loading more pics...');
									$('#pics').append('<a target="blank" class="ttb" rel="gallery1" href="' + this.file + '"><img src="'+ this.thumb +'" style="margin: 0 10px 20px 0;"/></a>');
								}
								else {
									$("#more").hide();
									notify('All pics loaded!');
								}
															
							});
							waypoint = waypoint + 10;
							
						}
						
						
						
					 </script>		
						
						<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/waypoints.min.js"></script>
<!-- <script src="<?php bloginfo('template_directory'); ?>/js/waypoints-infinite.min.js"></script> -->
<!-- Add jQuery library -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>


<!-- Add fancyBox -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/js/fancybox/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.4"></script>

<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.5"></script>

<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>


<style type="text/css">
.notifications-wrapper {
  position: fixed;
  z-index: 2;
  height: 0;
  overflow: visible;
  left: 0;
  right: 0;
  top: 45px; }

.notifications {
  width: 320px;
  margin: 0 auto;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3); }
  .notifications > p {
    height: 32px;
    line-height: 32px;
    background: #e2eaf2;
    color: #626a72;
    text-align: center;
    margin: 0;
    border-top: 1px solid #c5d5e5; }
    
   #more {} 
</style>

<script type="text/javascript">
$(document).ready(function( event) {
	
	
	
	
	 $(".ttb").fancybox({
    	openEffect : 'none',
    	closeEffect	: 'none'
    	});
	
	
	var notify = function(message) {
      var $message = $('<p style="display:none;">' + message + '</p>');

      $('.notifications').append($message);
      $message.slideDown(300, function() {
        window.setTimeout(function() {
          $message.slideUp(300, function() {
            $message.remove();
          });
        }, 2000);
      });
    };

    
jQuery.ajax( {
	url      : 'http://myplayoffbeard.hockeyinsideout.com/status.php?get_name',
	dataType : 'jsonp',
	success  : function ( data ) {
		
		jPics = data;
		writPics();
		
		//console.log('aaaaaaaaaaaaaaaaaa')
		
	}
});


	
$('.entry-content').waypoint(function(direction) {
		writPics();
		notify('Loading more pics...');
}, { offset: 'bottom-in-view' });
	
});
 
 $("#more").click(function(event){
	 
	 writPics();
	 event.preventDefault();
	 
 });
 
</script>
						
						
					<!--END .entry-content -->
					</div>

				<!--END .hentry-->
				</div>
				
				<?php //comments_template('', true); ?>

				<?php endwhile; endif; ?>
			
			<!--END #primary .hfeed-->
			</div>
			
<?php get_sidebar(); ?>

<?php get_footer(); ?>