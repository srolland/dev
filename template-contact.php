<?php
/*
Template Name: Contact
*/
?>

<?php 
if(isset($_POST['submitted'])) {
		if(trim($_POST['contactName']) === '') {
			$nameError = 'Please enter your name.';
			$hasError = true;
		} else {
			$name = trim($_POST['contactName']);
		}
		
		if(trim($_POST['email']) === '')  {
			$emailError = 'Please enter your email address.';
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
			$emailError = 'You entered an invalid email address.';
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}
			
		if(trim($_POST['comments']) === '') {
			$commentError = 'Please enter a message.';
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}
			
		if(!isset($hasError)) {
			$emailTo = get_option('tz_email');
			if (!isset($emailTo) || ($emailTo == '') ){
				$emailTo = get_option('admin_email');
			}
			$subject = '[Contact Form] From '.$name;
			$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
			$headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
			
			mail($emailTo, $subject, $body, $headers);
			//mail('jeanbaptistejung@gmail.com', $subject, $body, $headers);
			$emailSent = true;
		}
	
} ?>
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

				<?php if(isset($emailSent) && $emailSent == true) { ?>

					<div class="thanks">
						<p>Thanks, your email was sent successfully.</p>
					</div>

				<?php } else { ?>

					<?php the_content(); ?>
		
					<?php if(isset($hasError) || isset($captchaError)) { ?>
						<p class="error">Sorry, an error occured.<p>
					<?php } ?>
	
					<form action="<?php the_permalink(); ?>" id="contactForm" method="post">
						<ul class="contactform">
							<li><label for="contactName">Name:</label>
								<div class="input-container"><input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="required requiredField" /></div>
								<?php if($nameError != '') { ?>
									<span class="error"><?=$nameError;?></span> 
								<?php } ?>
							</li>
				
							<li><label for="email">Email:</label>
								<div class="input-container"><input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="required requiredField email" /></div>
								<?php if($emailError != '') { ?>
									<span class="error"><?=$emailError;?></span>
								<?php } ?>
							</li>
				
							<li class="textarea"><label for="commentsText">Message:</label>
								<div class="textarea-container"><textarea name="comments" id="commentsText" rows="20" cols="30" class="required requiredField"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea></div>
								<?php if($commentError != '') { ?>
									<span class="error"><?=$commentError;?></span> 
								<?php } ?>
							</li>
				
							<li class="buttons">
								<input type="hidden" name="submitted" id="submitted" value="true" />
								<button type="submit">Send email</button>
							</li>
						</ul>
					</form>
				<?php } ?>
				</div><!-- .entry-content -->	
				<!--END .hentry-->
				</div>
				
				<?php endwhile; endif; ?>
			
			<!--END #primary .hfeed-->
			</div>
			
<?php get_sidebar(); ?>

<?php get_footer(); ?>