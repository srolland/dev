<?php
/*
Template Name: Playoff Beard Image
*/
?>
<?php get_header(); ?>

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
					
					<?php 
						
						if ( isset(  $_GET['_id'] ) && !empty( $_GET['_id'] ) ) {
							
							$url = "http://myplayoffbeard.hockeyinsideout.com/_files/" . $_GET['_id'] . ".png";
							$response = get_headers($url, 1);
							$file_exists = (strpos($response[0], "404") === false);
						
						
							if ( !$file_exists ) {
								//header( 'Location: /' ) ;
								//die( 'no file' );	
							} else {
								$img = "http://myplayoffbeard.hockeyinsideout.com/_files/" . $_GET['_id'] . ".png";
							}
						} else {
							//header( 'Location: /' ) ;
							//die( 'no file id' );
						}						
					?>
					<?php if ( $img ) { ?>
					<img class="image_main_img" width="600" height="600" src="<?php echo $img; ?>">
					<?php } else { ?>
							<p style="color:#da0000;">Invalid image code.</p>
					<?php }?>
										
					<p><a href="/myplayoffbeard" style="font-size:16px;">Grow your own playoff beard! ></a></p>					
											
					<!--END .entry-content -->
					</div>
										
				<!--END .hentry-->
				</div>
				

				<?php endwhile; endif; ?>
			
			<!--END #primary .hfeed-->
			</div>
			
<?php get_sidebar(); ?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/waypoints.min.js"></script>
<!-- <script src="<?php bloginfo('template_directory'); ?>/js/waypoints-infinite.min.js"></script> -->


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
</style>

<script type="text/javascript">
$(document).ready(function( event) {

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


	writPics();
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


<?php get_footer(); ?>