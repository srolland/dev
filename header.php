<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php include( TEMPLATEPATH . '/functions/get-options.php' ); /* include theme options */ ?>

<!-- BEGIN html -->
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<!-- An AWESEM design (http://www.awesem.co.uk) - Proudly powered by WordPress (http://wordpress.org) -->

<!-- BEGIN head -->
<head profile="http://gmpg.org/xfn/11">
	
	<!-- TEMPORARY Ads Tags -->
	<script language="javascript1.1" src="http://www.canada.com/js/thirdpartyads/canwest_default_variables.js"></script>
<script language="javascript" type="text/javascript" src="http://www.canada.com/js/thirdpartyads/habsinsideout_variables.js"></script>

<script>
// HIO Show ad code info
//Ad code variables
//var count = 1;

var pathArray = window.location.pathname.split( '/' );
var story_page = parseInt(pathArray[pathArray.length-1]);
var pm_page = "index";

if (story_page>=1) {
	pm_page="story";
}

 var Postmedia = {
                    "adConfig": {
                        "site": "mg_habsio.com",
                        "async": true,
                        "sra": true,
                        "networkId": "3081",
                        "disableInitialLoad": false,
                        "zone": "index",
                        "keys": {
                            "nk": "print",
                            "pr": ["habsio","mg"],                    
                            "cnt" : "sports",
                            "ck": <?php if (in_category( 'show' )) { echo "\"show\"";  } else { echo "\"index\""; }  ?>,
                            "page": pm_page
                        }
                    }
                };
                
</script></script>
	
	<!-- Meta Tags -->
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="google-site-verification" content="AHz1KnTbk4xjX8FbXTjLm1uwDvHvpzCvFRjLvb9Wf5w" />
	
	<!-- Title -->
	<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo ($tz_favicon_url); ?>" />
	
	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/<?php echo ($tz_theme_stylesheet); ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/print.css" type="text/css" media="print" />
    <meta name="bitly-verification" content="00ea4442f250"/>
    <style>
		.post div.entry-content embed, .post div.entry-content object, .single div.entry-content embed, .single div.entry-content object, .single-external-videos div.entry-content embed, .single-external-videos div.entry-content object { 
			width:620px;
			/*height:;*/
		} 
	</style>
	
	<!-- RSS, Atom & Pingbacks -->
	<?php if ($tz_feedburner) { /* if FeedBurner URL is set in theme options */ ?>
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php echo ($tz_feedburner); ?>" />
	<?php } else { /* if not then use the standard WP feed */ ?>
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?> RSS Feed" href="<?php bloginfo( 'rss2_url' ); ?>" />
	<?php } ?>
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo( 'rss_url' ); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo( 'atom_url' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<!-- Theme Hook -->
	<?php wp_enqueue_script("jquery"); /* load JQuery (modified to use Google over WP Bundle in functions.php) */ ?>
    <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); /* loads the javascript required for threaded comments */ ?>
	<?php wp_head(); ?>
	
	<!-- JS Scripts -->
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/superfish.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.color.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.custom.js"></script>
	
	<!-- Flexslider -->
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/flexslider.css" type="text/css" media="all" />
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.flexslider.js"></script>
	
	<script type="text/javascript" charset="utf-8">
		$(window).load(function() {
			//$('.flexslider').flexslider();
			
			jQuery('#mainSlider').flexslider({
				animation: "fade",
				pauseOnAction: true, 
				after: function(slider) { if (!slider.playing) { slider.play(); } }
			});
		});
	</script>
		
	<?php if (($tz_news_pictures == "true") && (is_home())) { /* if is hompage and "news in pcitures" is enabled */ ?>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.galleriffic.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.opacityrollover.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		// We only want these styles applied when javascript is enabled
		$('#picture-posts .navigation').css({'width' : '300px', 'position' : 'absolute', 'left' : '320px', 'top' : '45px' });
		$('div.content').css('display', 'block');

		// Initially set opacity on thumbs and add
		// additional styling for hover effect on thumbs
		var onMouseOutOpacity = 0.67;
		$('#thumbs ul.thumbs li').opacityrollover({
			mouseOutOpacity:   onMouseOutOpacity,
			mouseOverOpacity:  1.0,
			fadeSpeed:         'fast',
			exemptionSelector: '.selected'
		});
		
		// Initialize Advanced Galleriffic Gallery
		var gallery = $('#thumbs').galleriffic({
			delay: <?php echo( $tz_news_delay); ?>,
			numThumbs: 16,
			preloadAhead: 10,
			enableTopPager: false,
			enableBottomPager: false,
			maxPagesToShow: 1,
			imageContainerSel: '#slideshow',
			controlsContainerSel: '#controls',
			captionContainerSel: '#caption',
			loadingContainerSel: '#loading',
			renderSSControls: false,
			renderNavControls: false,
			playLinkText: 'Play Slideshow',
			pauseLinkText: 'Pause Slideshow',
			prevLinkText:	 '&lsaquo; Previous Photo',
			nextLinkText: 'Next Photo &rsaquo;',
			nextPageLinkText: 'Next &rsaquo;',
			prevPageLinkText: '&lsaquo; Prev',
			enableHistory: false,
			autoStart: <?php echo ($tz_news_autostart); ?>,
			syncTransitions: true,
			defaultTransitionDuration: 900,
			onSlideChange: function(prevIndex, nextIndex) {	
				// 'this' refers to the gallery, which is an extension of $('#thumbs')
				this.find('ul.thumbs').children()
				.eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
				.eq(nextIndex).fadeTo('fast', 1.0);
			},
			onPageTransitionOut: function(callback) {
				this.fadeTo('fast', 0.0, callback);
			},
			onPageTransitionIn: function() {
				this.fadeTo('fast', 1.0);
			}
		});
	});
	</script>
	<?php } ?>
	
	<?php if (is_page_template('template-contact.php')) { /* if the page uses the contact form template then load validation js */ ?>
		<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.validate.min.js"></script>
		<script>
			$(document).ready(function(){
				$("#contactForm").validate();
			});
	  </script>
	<?php } ?>

<!-- END head -->
</head>

<!-- BEGIN body -->
<body <?php body_class(); ?>>

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-MKS7Q2"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MKS7Q2');</script>
<!-- End Google Tag Manager -->

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

	<!-- BEGIN .container -->
	<div id="container">
			
			<div id="top_banner" align="center">
		     	<div class="branding">
					<a href="http://www.montrealgazette.com/" title="Montreal Gazette - Breaking News, Quebec, Opinion, Multimedia &amp; More">
						<img src="<?php bloginfo('template_directory'); ?>/images/_header/montreal-gazette-logo.png" alt="Montreal Gazette" width="175" height="44"></a>
				</div>
		     	<div class="advertisement">
			     	<!-- Start of leaderboard -->
					<script>
						ad_tile=ad_tile+1;
						document.write('\<SCRIPT language=\"JavaScript1.1\" SRC=\"http:\/\/ad.ca.doubleclick.net\/N3081\/adj\/'+ad_adsite+ad_path+';'+ad_loc.leaderboard+ad_sz.leaderboard+'tile='+ad_tile+';'+ad_dcopt.leaderboard+ad_nk+ad_pr+ad_ck+ad_sck+ad_page+ad_cnt+ad_kv+ad_kw+ad_ord+'?\">\<\/SCRIPT>');
					</script>
					<noscript>
						<a TARGET="_top" HREF="http://ad.ca.doubleclick.net/N3081/jump/mg_habsio.com/noscript;loc=theTop;loc=top;sz=468x60,728x90;tile=1;dcopt=ist;ord=47159745?">
						<IMG ALIGN="TOP" BORDER="0" VSPACE="0" HSPACE="0" WIDTH="468" HEIGHT="60" SRC="http://ad.ca.doubleclick.net/N3081/ad/mg_habsio.com/noscript;loc=theTop;loc=top;sz=468x60,728x90;tile=1;dcopt=ist;ord=47159745?"></a>
					</noscript><!-- End of leaderboard -->
		     	</div>
		     </div>
		
		<!-- BEGIN .header -->
		<div id="header" class="clearfix">
			
			<!-- BEGIN #logo -->
			<div id="logo_box" style="float:left">
				<a href="<?php bloginfo( 'url' ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/_header/HIO-header-logo.png" alt="<?php bloginfo( 'name' ); ?>" width="584" height="48" /></a>
			<!-- END #logo -->
			</div>
			
			<div id="sponsor_box" style="float:right; margin-top:15px">
				<!-- <a href="http://www.videotron.com/residential#" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/_header/sponsor_logo_header.jpg" alt="<?php bloginfo( 'name' ); ?>" width="118" height="45" /></a> -->
			<!-- END #logo -->
			</div>

			<!--
<div id="header_social_box" >
				
				<a href="http://www.facebook.com/#!/pages/Habs-InsideOut/64392143331" target="_blank">
					<img src="<?php bloginfo('template_directory'); ?>/images/fb-icon.png" alt="facebook" title="Visit our Facebook Fan Page" width="34" height="34" border="0"></a>
					
				<a href="https://twitter.com/HabsIO" target="_blank">
					<img src="<?php bloginfo('template_directory'); ?>/images/twitter-icon.png" alt="Twitter" width="34" height="34" border="0" title="Twitter"></a>
				
				<a href="http://www.youtube.com/user/HabsInsideOutVideos" target="_blank">
					<img src="<?php bloginfo('template_directory'); ?>/images/youtube-icon.png" alt="You Tube" width="34" height="34" border="0" title="Hockey Inside/out Youtube Channel"></a>
					
				<a href="http://itunes.apple.com/podcast/h-i-o-puckcast/id207543797">
					<img src="<?php bloginfo('template_directory'); ?>/images/puckcast-icon.png" alt="Puckcast" title="Puckcast" width="34" height="34" border="0" ></a>
												
			</div>
-->
			
		<!--END .header-->
		</div>
		
		<!-- BEGIN #primary-nav -->
		<div id="primary-nav-container">
        
        			<div id="primary-nav" class="rounded">
                    <div style="width:740px; float:left">
<?php displayMenu(1, 2); ?>
					</div>
					<div align="right" style="width:200px; float:right;padding-top:12px" class="header_login_btn_box">
<?php					
					        global $userdata;
					        get_currentuserinfo();

							if(is_user_logged_in()) {
							echo "Hi <a href='/wp-admin/profile.php'>".$userdata->user_login."</a>
								 / 
								<a href='".wp_logout_url(get_permalink()) . "'>Logout</a>";
							
							}else {
								echo "<a href='/wp-login.php?redirect_to=".urlencode(get_permalink())."'>Login</a> | 
									<a href='/wp-login.php?action=register'>Sign Up</a>
									";
							}
?>
						
					</div>
        </div>
		</div>
		<!-- END #primary-nav -->
		<!--BEGIN #content -->
		<div id="content-container">
		<div id="content" class="clearfix">	