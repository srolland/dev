<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php include( TEMPLATEPATH . '/functions/get-options.php' ); /* include theme options */ ?>

<!-- BEGIN html -->
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<!-- An AWESEM design (http://www.awesem.co.uk) - Proudly powered by WordPress (http://wordpress.org) -->

<!-- BEGIN head -->
<head profile="http://gmpg.org/xfn/11">
	
	<!-- TEMPORARY Ads Tags -->
	<script language="javascript1.1" src="http://www.canada.com/js/thirdpartyads/canwest_default_variables.js"></script>
	<script language="javascript1.1" src="http://www.canada.com/js/thirdpartyads/alsinsideout_variables.js"></script>
	
	<!-- Meta Tags -->
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	
	<!-- Title -->
	<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo ($tz_favicon_url); ?>" />
	
	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/<?php echo ($tz_theme_stylesheet); ?>" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/print.css" type="text/css" media="print" />
	
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

	<!-- BEGIN .container -->
	<div id="container">
	
		<!-- BEGIN #top-bar -->
		<div id="top-bar">
		
			<!-- BEGIN #top-bar-inner -->
			<div id="top-bar-inner">
			

				
				<!-- BEGIN #secondary-nav -->
				<div id="secondary-nav">
				<img src="http://devhio/wp-content/uploads/2011/02/headline.gif" alt="Absolutely everything about the Montreal Canadiens" />
				<!-- END #secondary-nav -->
				</div>
				
				<!-- BEGIN #date -->
				<div id="date">
					<p class="rounded"><?php echo date("l d F Y"); ?></p>
				<!-- END #date -->
				</div>
				
			<!-- END #top-bar-inner -->
			</div>
			
		<!-- END #top-bar -->
		</div>
	
		<!-- BEGIN .header -->
		<div id="header" class="clearfix">
			
			<!-- BEGIN #logo -->
			<div id="logo" style="float:left">
				<?php /*
				If "plain text logo" is set in theme options then use text
				if a logo url has been set in theme options then use that
				if none of the above then use the default logo.png */
				if ($tz_plain_logo == "true") { ?>
				<a href="<?php bloginfo( 'url' ); ?>"><?php bloginfo( 'name' ); ?></a>
				<p id="tagline"><?php bloginfo( 'description' ); ?></p>
				<?php } elseif ($tz_logo_url) { ?>
				<a href="<?php bloginfo( 'url' ); ?>"><img src="<?php echo ($tz_logo_url); ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
				<?php } else { ?>
				<a href="<?php bloginfo( 'url' ); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>" width="255" height="68" /></a>
				<?php } ?>
			<!-- END #logo -->
			</div>
			
       <div align="right"  style="width:740px;padding-bottom:15px;float:left;" ><!-- Start of leaderboard -->
<script>
	ad_tile=ad_tile+1;
	document.write('\<SCRIPT language=\"JavaScript1.1\" SRC=\"http:\/\/ad.ca.doubleclick.net\/N3081\/adj\/'+ad_adsite+ad_path+';'+ad_loc.leaderboard+ad_sz.leaderboard+'tile='+ad_tile+';'+ad_dcopt.leaderboard+ad_nk+ad_pr+ad_ck+ad_sck+ad_page+ad_cnt+ad_kv+ad_kw+ad_ord+'?\">\<\/SCRIPT>');
</script>
<noscript>
	<a TARGET="_top" HREF="http://ad.ca.doubleclick.net/N3081/jump/mg_habsio.com/noscript;loc=theTop;loc=top;sz=468x60,728x90;tile=1;dcopt=ist;ord=47159745?">
	<IMG ALIGN="TOP" BORDER="0" VSPACE="0" HSPACE="0" WIDTH="468" HEIGHT="60" SRC="http://ad.ca.doubleclick.net/N3081/ad/mg_habsio.com/noscript;loc=theTop;loc=top;sz=468x60,728x90;tile=1;dcopt=ist;ord=47159745?"></a>
</noscript><!-- End of leaderboard -->
</div>
			
		<!--END .header-->
		</div>
		
		<!-- BEGIN #primary-nav -->
		<div id="primary-nav-container">
        
        			<div id="primary-nav" class="rounded">
                    <div style="width:740px; float:left">
<?php displayMenu(2, 2); ?>
					</div>
            <div align="right" style="width:200px; float:left;;padding-top:12px"><a href="http://www.montrealgazette.com" target="_blank"><img src="/wp-content/themes/deadline/images/gazette-logo.png" alt="The Montreal Gazette" border="0" /></a>
            	</div>
        </div>
		</div>
		<!-- END #primary-nav -->
		<!--BEGIN #content -->
		<div id="content-container">
		<div id="content" class="clearfix">
	