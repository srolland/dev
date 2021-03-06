<?php
/*
Template Name: In The Game
*/
?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0" />
<title><?php

	global $page, $paged;
	wp_title( '|', true, 'right' );

	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		echo " | $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		echo ' | ' . sprintf( __( 'Page %s', 'qqp_theme' ), max( $paged, $page ) );
	}

?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<script>
    var badIE = false;
</script>

<!--[if lt IE 9]>
<script type="text/javascript">badIE = true;</script>
<![endif]-->

<script>
if (badIE == true){
    alert('If you are using Internet Explorer 7 or 8, some functions on this page may not work properly. Please upgrade your browser to get the full experience.');
}
</script>
<?php

	wp_head();
?>
	<script type="text/javascript">
	//<![CDATA[
		var qqp_data = Array();
		<?php
			if( is_user_logged_in() ) {
				global $current_user;
		    	get_currentuserinfo();
		      
				$user_js_data = $current_user->data;
				unset( $user_js_data->user_pass );
				echo "qqp_data['user'] = " . json_encode( $user_js_data ) . "; ";
			}
		?>
	//]]>
	</script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>
	
</head>
<?php 
	$extra_body_class = '';
	
	$curr_post_type = get_post_type();
	
	if ( $curr_post_type == 'qqp_live' ) {
		$extra_body_class .= ' fixed';
	} else {
		$extra_body_class .= ' home';
	}	
?>

<body <?php body_class( $extra_body_class ); ?>>
<div class="in_the_game-header_box">
	<div class="in_the_game-header">
		<a href="<?php echo site_url(); ?>" class="in_the_game-header_logo_hio"><img src="<?php bloginfo('template_directory'); ?>/_img/HIO-header-logo.png" alt="HIO" width="199" height="42"></a>
		<a href="http://www.videotron.com/residential#" class="in_the_game-header_logo_sponsor" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/_img/sponsor_logo_pbp.jpg" alt="Videotron-header-logo" width="212" height="36"></a>
	</div>
	<div class="clear_it"></div>
</div>
	
<div class="content_box">
	<div class="in-the-game_help_overlay">
		<img src="<?php bloginfo('template_directory'); ?>/_img/explaination-screen.png" alt="Help" width="1024" height="1021">
	</div>
	
	<?php 
	
		$onetwosee_date = get_post_meta( $post->ID, 'onetwosee_date', true );
		$scribblelive_id = get_post_meta( $post->ID, 'scribblelive_id', true );
		
		$comments_post_id = get_post_meta( $post->ID, 'comments_post_id', true );
		
		if ( !$comments_post_id && empty( $comments_post_id ) ) {
			$comments_post_id = $post->ID;
		}
		
		$onetwosee_url = get_post_meta( $post->ID, 'onetwosee_url', true );
		$scribblelive_url = get_post_meta( $post->ID, 'scribblelive_url', true );
					
	?>
	
	<script type="text/javascript">
	//<![CDATA[
		jQuery(document).ready(function(){
		
			jQuery( '#qqp_pings_comments_box' ).qqp_ping({
				ajaxurl: qqp_pings_js.ajaxurl,
				_qqp_ping_nonce: qqp_pings_js._qqp_ping_nonce,
				post_id: '<?php echo $comments_post_id; ?>',
				comments_open: <?php echo is_user_logged_in() ? 'true' : 'false'; ?>,
				comment_depth: <?php echo get_option( 'thread_comments_depth' ); ?>,
				btn_scroll_top: jQuery( '.qqp_in_the_game_comment_box_stage .scroll_to_top_btn' ),
				ping_status_box: jQuery( '.qqp_in_the_game_comment_box_stage .ping_status_box' )
				
			});
			
			jQuery( '.qqp_in_the_game_comment_box_stage .scroll_to_top_btn' ).click( function(){
				_gaq.push(['_trackEvent', 'click',  'scroll to top btn' , 'http://staging.hockeyinsideout.com/in-the-game/Scroll-to-top-btn']);
			});
			
			jQuery( '.qqp_in_the_game_comment_box_stage .form_submit_btn' ).click( function(){
				_gaq.push(['_trackEvent', 'click',  'post comment btn' , 'http://staging.hockeyinsideout.com/in-the-game/Post-comment-btn']);
			});
			
			jQuery( '.qqp_in_the_game_comment_box_stage .form_autosend_box' ).click( function(){
				_gaq.push(['_trackEvent', 'click',  'post auto send btn' , 'http://staging.hockeyinsideout.com/in-the-game/Post-auto-send-btn']);
			});
			
			jQuery( '.qqp_in_the_game_comment_box_stage .form_close_btn' ).click( function(){
				_gaq.push(['_trackEvent', 'click',  'cancel comment btn' , 'http://staging.hockeyinsideout.com/in-the-game/Cancel-comment-btn']);
			});
			
			qqp_first_visit = getCookie( 'in_the_game_test_cookie' );
			
			if ( qqp_first_visit != null && qqp_first_visit == "Yes" )  {
				jQuery( '.in-the-game_help_overlay' ).hide();
			} else {
				setCookie( 'in_the_game_test_cookie', 'Yes', 5 );
				jQuery( '.in-the-game_help_overlay' ).show();
			}
			
			//setCookie( 'in_the_game_test_cookie', 'No', 5 );
			
			jQuery( '.in-the-game_help_overlay' ).click(function() {
				jQuery( this ).hide();
			});
			
			jQuery( '.show_help_btn' ).click(function() {
				jQuery( '.in-the-game_help_overlay' ).show();
			});
			
		});
	//]]>
	</script>
	<?php if ( $onetwosee_date && !empty( $onetwosee_date ) ) { ?>
		<div class="onetowsee_content">
<!-- 			<iframe src="http://nhl.onetwosee.com/broadcaster/montrealgazette/team/mtl/date/<?php echo $onetwosee_date; ?>" width="996" height="520" frameborder="0"></iframe> -->
				<!-- <iframe src="http://nhl.test.onetwosee.com/broadcaster/montrealgazette/team/mtl/date/<?php echo $onetwosee_date; ?>" width="996" height="620" frameborder="0"></iframe> -->
				
				<iframe src="http://montrealgazette.onetwosee.com/<?php echo $onetwosee_date; ?>" width="996" height="700" frameborder="0"></iframe>
				
		</div>
	<?php } else { ?>

		<?php if ( $onetwosee_url && !empty( $onetwosee_url ) ) { ?>
			<div class="onetowsee_content">
				<iframe src="<?php echo $onetwosee_url; ?>" width="996" height="700" frameborder="0"></iframe>
			</div>
		<?php } ?>
		
	<?php } ?>
	
	<!-- VIDEOTRON BANNER + HIO AD -->
	<!-- TEMPORARY Ads Tags -->
	<script language="javascript1.1" src="http://www.canada.com/js/thirdpartyads/canwest_default_variables.js"></script>
<script language="javascript" type="text/javascript" src="http://www.canada.com/js/thirdpartyads/habsinsideout_variables.js"></script>

	<div class="sponsor_pbp" style=" float:left; margin:20px 15px 18px 14px; width:728px; height:90px;"> 
	<!-- Start of leaderboard -->
										<script>
                                                ad_tile=ad_tile+1;
                                                document.write('\<SCRIPT language=\"JavaScript1.1\" SRC=\"http:\/\/ad.ca.doubleclick.net\/N3081\/adj\/'+ad_adsite+ad_path+';'+ad_loc.leaderboard+ad_sz.leaderboard+'tile='+ad_tile+';'+ad_dcopt.leaderboard+ad_nk+ad_pr+ad_ck+ad_sck+ad_page+ad_cnt+ad_kv+ad_kw+ad_ord+'?\">\<\/SCRIPT>');
                                        </script>
                                        <noscript>
                                                <aTARGET="_top"HREF="http://ad.ca.doubleclick.net/N3081/jump/mg_habsio.com/noscript;loc=theTop;loc=top;sz=468x60,728x90;tile=1;dcopt=ist;ord=47159745?">
                                                <IMGALIGN="TOP"BORDER="0"VSPACE="0"HSPACE="0"WIDTH="468"HEIGHT="60"SRC="http://ad.ca.doubleclick.net/N3081/ad/mg_habsio.com/noscript;loc=theTop;loc=top;sz=468x60,728x90;tile=1;dcopt=ist;ord=47159745?"></a>
                                        </noscript><!-- End of leaderboard -->
                                        </div>
                                        <a href="http://staging.hockeyinsideout.com/show"><img style="margin-top:20px;" src="/wp-content/themes/deadline/images/hio_show_pbp.jpg" alt="HIO Show" width="253" height="90"></a>

		<div class="hio_content">
			<div class="qqp_in_the_game_comment_box_stage">
				<div class="qqp_in_the_game_comment_box_header">
					<span class="title">LIVE COMMENTS</span>
					<span class="ping_status_label">Comments will reload in:</span> <span class="ping_status_box">loading</span>
					<a class="scroll_to_top_btn"></a>
				</div>
				<div class="qqp_pings_comments_box_inner_box">
					<div class="qqp_pings_comments_box_inner_box_inner">
						<div id="qqp_pings_comments_box"></div>
					</div>
				</div>
			</div>	
		
			<div class="hio_iframe_box">
				<div class="hio_iframe_header">
					<span class="title">MIKE BOONE'S</span> LIVE PLAY-BY-PLAY
				</div>
			<?php if ( $scribblelive_id && !empty( $scribblelive_id ) ) { ?>
				<iframe src="http://embed.scribblelive.com/Embed/v5.aspx?Id=<?php echo $scribblelive_id; ?>&ThemeId=13872" width="408" height="445" frameborder="0"></iframe>
			<?php } else { ?>
	
				<?php if ( $scribblelive_url && !empty( $scribblelive_url ) ) { ?>
					<iframe src="<?php echo $scribblelive_url; ?>" width="408" height="445" frameborder="0"></iframe>
				<?php } ?>
			<?php } ?>
			</div>
			
		</div>
		
		<a class="show_help_btn"></a>
		<a class="feedback_btn" href="mailto:hockeyinsideout@montrealgazette.com">Feedback</a>
			<div class="clear_it"></div>
		
</div>		
		
	<div class="in_the_game-footer_box">
		
		<div id="footer">

<!--BEGIN footer nav -->
	<div id="footer_nav">
		<a href="/" title="Home" rel="">Home</a> | 
		<a href="/news/" title="News" rel="">News</a> | 
		<a href="/boone/" title="Boone" rel="">Boone's Live Blog</a> | 
		<a href="/photos/curent-season" title="Photos" rel="">Photos</a> | 
		<a href="/videos/" title="Videos" rel="">Videos</a> | 
		<a href="/puckcast/" title="Puckcast" rel="">Puckcast</a> | 
		<a href="/about/" title="About" rel="">About</a> | 
<!-- 		<a href="#" title="In The Game" rel="">In The Game</a> -->

	</div>
<!--END footer nav -->

	<!-- BEGIN #foot-inner -->
	<div id="foot-inner" class="clearfix">
						
	<div id="copy">
		<div id="network_links" class="clearfix">
			<a href="http://www.montrealgazette.com/" title="Montreal Gazette - Breaking News, Quebec, Opinion, Multimedia &amp; More">
				<img src="/wp-content/themes/deadline/images/_footer/footer_logo_gzt.png" alt="Montreal Gazette" width="114" height="37"></a>
			<a href="http://westislandgazette.com" title="West Island Gazette">
				<img src="/wp-content/themes/deadline/images/_footer/footer_logo_wig.png" alt="West Island Gazette" width="131" height="37"></a>
			<!--
<a href="http://staging.hockeyinsideout.com" title="Hockey Inside/Out">
				<img src="http://homefront.montrealgazette.com/wp-content/themes/deadline/images/_footer/footer_logo_hio.png" alt="Hockey Inside/Out" width="73" height="37"></a>
-->
			<!--
<a href="http://homefront.montrealgazette.com" title="Montreal Gazette Homefront">
				<img src="http://homefront.montrealgazette.com/wp-content/themes/deadline/images/footer/footer_logo_hf.png" alt="Montreal Gazette Homefront" width="141" height="37"></a>
-->
			<a href="http://www.urbanexpressions.ca" title="Urban Expressions - Celebrating Montreal Lifestyle">
				<img src="/wp-content/themes/deadline/images/_footer/footer_logo_ue.png" alt="Urban Expressions" width="64" height="37"></a>
			<a href="http://offislandgazette.com" title="Off Island Gazette">
				<img src="/wp-content/themes/deadline/images/_footer/footer_logo_oig.png" alt="Off Island Gazette" width="102" height="37"></a>
		</div>
	
		<p id="copy">

<a href="http://staging.hockeyinsideout.com">Hockey Inside/Out</a>: Absolutely everything about the Montreal Canadiens For editorial inquiries, contact Gazette sports editor <a href="mailto:scowan@montrealgazette.com">Stu Cowan</a>. For advertising inquiries, please contact your <a href="mailto:gazadv@montrealgazette.com">Gazette sales representative</a>. &copy; <?php echo date( 'Y' , time() ); ?> The Gazette, a division of Postmedia Network Inc. All rights reserved. Unauthorized distribution, transmission or republication strictly prohibited. Terms and Conditions Privacy Statement

</p>
	</div>
	<!-- END #foot-inner -->
	</div>
<!-- END #footer -->
</div>
			
	</div>	
		
	<style>
	
		body {
			/* background-image: url(<?php echo get_bloginfo( 'template_url' ); ?>/_img/sponsor_bg.png); */
			background-position: center -3px;
			background-color: #FFF;
			background-repeat: no-repeat;
		}
		
		.in-the-game_help_overlay {
			position: absolute;
			z-index: 999;
			width: 1024px;
			height: 1021px;
		}
		
		.in_the_game-header_box {
			background-color: #ee2225;
			margin: 0;
			padding: 0;
			height: 52px;
		}
		
		.in_the_game-header {
			width:1024px;
			margin: 0 auto;
		}
		
		.in_the_game-header_logo_hio {
			display: block;
			float: left;
			margin: 4px 2px 0 8px;
			padding: 0;
		}
		
		.in_the_game-header_logo_hio img {
			margin: 0;
			padding: 0;
		}

		.in_the_game-header_logo_sponsor {
			
			float: right;
			margin: 10px 13px 0 0px;
			padding: 0;
		}
		
		.in_the_game-header_logo_sponsor img {
			margin: 0;
			padding: 0;
		}
		
		.in_the_game-footer_box a {
			color: #DA0000;	
		}
		
		.content_box {
			width: 1024px;
			margin:  0 auto 20px auto;
			padding: 0 0 1px 0;
			background-image: url(<?php echo get_bloginfo( 'template_url' ); ?>/_img/content_bg.png);
		}
	
	.onetowsee_content {
		width: 996px;
		height: 700px;
		margin:  0 auto;	
	}
	
	.onetowsee_content iframe {
		width: 996px;
		height: 700px;
		margin:  0;	
		padding: 0;
		border: 0px none;
		overflow: hidden;
/* 		background: red; */
	}
	
	.hio_content {
		width: 996px;
		height: 470px;
		margin:  15px auto;
	}
	
	.hio_iframe_box {
		float: right;
		width: 408px;
		background: #fff;
		height: 470px;
		margin: 0;
		padding: 0;
	}
	
	.hio_iframe_header {
		background: #000;
		height: 25px;
		line-height: 25px;
		padding: 0 6px;
		color: #fff;
		font-size: 12px;
	}
	
	.hio_iframe_header span {
		font-weight: bold;
		font-size: 14px;
	}
	
	.form_autosend_btn {
		margin-top: -5px;	
	}
	
	.qqp_in_the_game_comment_box_stage {
		float: left;
		width: 560px;
		height: 470px;
		overflow: hidden;
		background: #fff;
		margin: 0;
/* 		border: 1px solid #eee; */
	}
	
	.qqp_in_the_game_comment_box_header {
		background: #000;
		height: 33px;
		line-height: 25px;
		padding: 0 6px;
		color: #fff;
	}
	
	.qqp_in_the_game_comment_box_header .ping_status_label {
		background: #000;
		padding: 0 0 0 20px;
		color: #fff;
		font-size: 10px;
		font-weight: normal;
	}
	
	.qqp_in_the_game_comment_box_header .ping_status_box {
		background: #000;
		padding: 0;
		color: #fff;
		font-size: 10px;
		font-weight: normal;
	}
	
	.qqp_in_the_game_comment_box_header a {
		background: #000;
		line-height: 25px;
		padding: 0;
		color: #fff;
		display: block;
		float: right;
		margin: 0;
	}
	
	.qqp_in_the_game_comment_box_header a.scroll_to_top_btn {
		background-image: url(<?php echo get_bloginfo( 'template_url' ); ?>/_img/icon_scroll_up.png);
		background-position: center center;
		background-repeat: no-repeat;
		width: 18px;
		height: 18px;
		cursor: pointer;
		margin-top: 5px;
	}
	
	.qqp_in_the_game_comment_box_header a.scroll_to_top_btn.new {
		background-image: url(<?php echo get_bloginfo( 'template_url' ); ?>/_img/icon_scroll_up-new.png);
	}
	
	.qqp_in_the_game_comment_box_header span {
		font-weight: bold;
		font-size: 14px;
	}
	
	.qqp_pings_comments_box_inner_box {
		overflow: scroll;
/* 		width: 800px; */
		height: 470px;
	}
	
	.qqp_pings_comments_box_inner_box_inner {
		padding: 0;
		margin: 0;
		margin-bottom: 33px;
	}
	
	a.show_help_btn {
		background-image: url(<?php echo get_bloginfo( 'template_url' ); ?>/_img/i-white.png);
		background-position: center center;
		background-repeat: no-repeat;
		width: 18px;
		height: 18px;
		cursor: pointer;
		margin-top: -5px;
		margin-bottom: 10px;
		margin-right: 15px;
		float: right;
		clear: both;
	}	
	
	a.feedback_btn {
		color: #FFF;
		background-position: center center;
		background-repeat: no-repeat;
		height: 18px;
		cursor: pointer;
		margin-top: -5px;
		margin-bottom: 10px;
		margin-right: 15px;
		float: right;
/* 		clear: both; */
	}	
	
		#qqp_pings_comments_box {
			
			padding: 5px;
/* 			width: 593px; */
/* 			border: 1px solid #eee; */
			background: #FFF;
		}
		
		#qqp_pings_comments_box ul {
			list-style: none;
			margin: 0;
		}
		
		#qqp_pings_comments_box ul ul {
			margin: 10px 0 0 50px;
			padding: 5px 0 0 0;
		}
		
		#qqp_pings_comments_box li {
			padding: 5px 0 5px 5px;
			margin: 0;
		}
		
		#qqp_pings_comments_box li.comment:nth-child(2n) {background: #F2F2F2}
		
		#qqp_pings_comments_box li.comment:nth-child(2n-1) {background: #FFF}
		
		#qqp_pings_comments_box li.comment {
			clear: both;
			border-top: 1px solid #eee;
			padding: 5px 0 5px 5px;	
		}
		
		#qqp_pings_comments_box li.comment .comment_col_1 {
			float: left;
			width: 42px;
			height: 42px;
			margin-right: -42px;
		}
		
		#qqp_pings_comments_box li.comment .comment_col_1 img {
			width: 42px;
			height: 42px;
		}
/* 	Target reply img */
		#qqp_pings_comments_box ul ul li.comment .comment_col_1 { }
		#qqp_pings_comments_box ul ul li.comment .comment_col_1 img { }
		
		#qqp_pings_comments_box li.comment .comment_col_2 {
			padding-left: 47px;
		}
		
		#qqp_pings_comments_box li.comment .comment_col_2 .comment_meta_box {
			font-size: 11px;
			margin-bottom: 15px;
		}
		
		#qqp_pings_comments_box li.comment .comment_col_2 .comment_meta_box span {
			font-weight: bold;
			font-size: 10px;	
		}
		
		#qqp_pings_comments_box li.comment .comment_col_2 .comment_content {
			margin-bottom: 0px;
		}
		
		#qqp_pings_comments_box li.comment .comment_col_2 .comment_content p {
			margin-bottom: 1em;
			line-height: 1.3em;
			font-size: 14px;
			word-break: break-all;
			clear: none;
			word-break:break-all;
			word-wrap: break-word;
		}
		
		#qqp_pings_comments_box li.comment .comment_col_2 .comment_content p:last-child {
			margin-bottom: 0;
		}
		
		#qqp_pings_comments_box li.comment .comment_ctrl_box {
			clear: both;
/* 			background: #eee; */
			margin: 7px 0 0 47px;
			padding: 0;
			font-size: 11px;
		}
		
		#qqp_pings_comments_box li.comment .comment_ctrl_box a {
			display: inline-block;
			padding: 4px 15px 4px 0;
			color: #2d4583;
			cursor: pointer;
		}
		
		.form_box {
/* 			border: 1px solid black; */
			padding: 0 0 5px 0;
			margin: 0;
/* 			background: #eee; */
/* 			height: 75px; */
		}
		
		ul .form_box {
/* 			border: 1px solid black; */
			padding: 0;
			margin-left: 47px;
			background: none;
		}
		
		.form_box.logged_in {
			height: 75px;
		}
		
		.form_box .form_col_no_form {
			padding: 5px 0;
			margin: 0;
			font-size: 12px;
		}
		
		.form_box .form_col_no_form {
			text-align: right;
		}
		
		ul .form_box .form_col_no_form {
			text-align: left;
		}
		
		.form_box .form_col_1 {
			padding: 0;
			margin: 0;
/* 			margin-right: 90px; */
			border: 1px solid #eee;
			background-color: #FFF;
		}
		
		.form_box .form_col_1 textarea {
			width: 100%;
			height: 45px;
			background: #fff;
			margin: 0;
			padding: 0;
			border: none;
			-moz-appearance:none;
			outline:none
		}
		
		.form_box .form_col_1 textarea:focus {
			border: none;
			-moz-appearance:none;
			outline:none
		}
		
		.form_box .form_col_1.error {
			border: 1px solid #da0000;
		}
		
		.form_box .form_col_2 {
			padding: 0;
			margin: 5px 0 0 0;
			text-align: right;
		}
		
		.form_box .form_col_2 a {
			padding: 3px 10px;
			margin: 0 0 0 5px;
			border: 1px solid #000;
			float: right;
			background: #2d4583;
			width: 50px;
			display: block;
			text-align: center;
			font-size: 11px;
			line-height: 14px;
			font-weight: bold;
			color: #fff;
			cursor: pointer;
		}
		
		.form_box .form_col_2 a:hover {
			color: #fff;
		}

		.form_box .form_col_2 .form_close_btn {
			background: none;
			border: none;
			color: #2d4583;
			font-weight: normal;
			margin-top: 2px;
			/* display: none; */
		}
		
		.form_box .form_col_2 .form_close_btn:hover {
			background: none;
			border: none;
			color: #da0000;
			/* display: none; */
		}
		
		ul .form_box .form_col_2 .form_close_btn {
/* 			display: block; */
		}
		
		.form_box .form_col_2 label {
			padding: 3px 0 3px 10px;
			margin: 2px 0 0 5px;
			float: right;
			display: block;
			text-align: center;
			font-size: 11px;
			line-height: 14px;
			font-weight: normal;
			color: #2d4583;
			cursor: pointer;
		}
		
		.disabled {
			
			background: #9198a8!important;
			border: 1px solid #666!important;
		}
		
		.clear_it {
			clear: both;
			line-height: 0px;
			font-size: 0px;
			border: none;
			padding: 0;
			margin: 0;	
		}
			
	</style>

<?php wp_footer(); ?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-17214408-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<!-- SiteCatalyst code version: H.17.
Copyright 1997-2008 Omniture, Inc. More info available at
http://www.omniture.com -->
<script language='JavaScript' type='text/javascript' src='http://a123.g.akamai.net/f/123/12465/1h/www.canada.com/js/account_habsinsideout_s_code.js'></script>
<script language='JavaScript' type='text/javascript' src='http://a123.g.akamai.net/f/123/12465/1h/www.canada.com/js/global_canwest_s_code.js'></script>
<script language='JavaScript' type='text/javascript' src='http://a123.g.akamai.net/f/123/12465/1h/www.canada.com/js/local_habsinsideout_s_code.js'></script>

<script language="JavaScript" type="text/javascript"><!--
/* You may give each page an identifying name, server, and channel on the next lines. */
s.pageType="" // If 404 page, "errorPage". Else, "".
s.prop4="Non-Registered" //If you can detect Canada.com login status on your site, "Registered" or "Non-Registered". If you can not detect, always "Non-Registered".
s.prop5=s.prop4 + ': ' + s.pageName
s.prop11="" // If a search results page, populate with the search term(s) in lower case. If not a search results page, remove. For example, "bubonic plague"
s.prop12="" // If a search results page, populate with the number of search results. If number of search results = 0, populate with "zero". If not a search results page, remove. For example, possible values include "1", "100" or "zero".
s.prop37="" // If DART served ads are on the page, pass in the DART ad site value. Example, http://www.canada.com/topics/entertainment/movie-guide/index.html, "ccn_entertainment.com" (found in source code). If you can not detect, remove.
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code)//--></script>
<script language="JavaScript" type="text/javascript"><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
//--></script><noscript><a href="http://www.omniture.com" title="Web Analytics"><img
src="http://canwest.112.2o7.net/b/ss/canwestglobal,canwest/1/H.17--NS/0"
height="1" width="1" border="0" alt="" /></a></noscript><!--/DO NOT REMOVE/-->
<!-- End SiteCatalyst code version: H.17. -->

</body>
</html>