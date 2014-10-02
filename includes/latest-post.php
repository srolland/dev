<!-- BEGIN #latest-post -->
				<div id="latest-post" class="rounded clearfix">
				
					<div id="mainSlider" class="flexslider">
						<ul class="slides">
					
					<?php /* Query the latest News Posts  */	 
					
						$query = new WP_Query( 'posts_per_page=4' ); ?>
								
					
				<!-- slider placeholder 1 begins -->        
				               
				 	<?php if ( $query->have_posts() ) { 
				        
				        	 while ($query->have_posts()) : $query->the_post(); 
						?>
							<li>
								<?php get_template_part( 'content', 'rotator' ); ?>
							</li>
							
						<?php 
						
							endwhile; 
							
							}//end have_posts if ?>
						
				        
				<!-- slider placeholder 1 ends -->	
						
						</ul>	
					</div>
									
									
									
									
				
				<!-- END #latest-post -->
				</div>
				