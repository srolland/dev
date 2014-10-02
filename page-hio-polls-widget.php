<?php
/*
Template Name: Latest Polls Widget
*/
?>				
<html xmlns="http://www.w3.org/1999/xhtml">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<head>
				<style type="text/css">
					body { margin:0; }
					#latest-poll-widget {width:280px; height:80px; padding:10px; margin:0; background-color:#f5f5f5; }
					#latest-poll-widget p {color:#222; margin:0 0 8px 0; text-indent:-1em; padding-left:1em; font-size:11px; font-family:Georgia, "Times New Roman", Times, serif; line-height:18px;}
					#latest-poll-widget a.hio-link {display:block; width:200px; height:22px; margin: 8px auto; background: url('<?php bloginfo('template_directory'); ?>/images/btn_bg.gif') repeat-x right top; text-transform:uppercase; text-decoration:none; color:#FFF; font: bold 10px/22px arial, sans-serif; padding: 0 8px; text-align:center; }
				</style>
 </head>
 <body>               
                <!--[if IE ]>
                	<style type="text/css">
                    	#latest-poll-widget {width:300px; padding:10px; margin:0; background-color:#f5f5f5; height:100px;}
                        #latest-poll-widget a.hio-link {width:222px; margin: 0 33px;}
                    </style>
                <![endif]-->
                
                
				<div id="latest-poll-widget">
				<?php /* show the latest poll  */
					$poll_question = $wpdb->get_row("SELECT pollq_id, pollq_question FROM $wpdb->pollsq WHERE pollq_active = 1 ORDER BY pollq_timestamp DESC LIMIT 1");
					echo "<p><strong>" . $poll_question -> pollq_question . "</strong></p>";
				?>
                
                <a href="http://staging.hockeyinsideout.com?utm_source=MG-sports&utm_medium=text-link&utm_campaign=hio-poll-widget#poll-widget" class="hio-link" target="_blank">Click here to vote in our Poll</a>
         </div>
    </body>
</html>