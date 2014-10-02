// Initialise the Superfish Menu (http://users.tpg.com.au/j_birch/plugins/superfish/)
// Secondary Navigation
$(document).ready(function() { 
        $('#secondary-nav ul').superfish({ 
            delay: 100,
            animation: {opacity:'show'},
            speed: 'fast',
            autoArrows: false,
            dropShadows: false
        }); 
    });
    
$(document).ready(function() { 
        $('#primary-nav ul').superfish({ 
            delay: 200,
            animation: {opacity:'show', height:'show'},
            speed: 'fast',
            autoArrows: false,
            dropShadows: false
        }); 
    });

// flickr + 125 banner + 468 banner + 120x240 + video widget transitions
$(document).ready(function() { 
		$(".flickr_badge_image img, .ads-125 img, #banner-header img, .ads-120x240 img").css({
				backgroundColor: "#f8f8f8"
			});
		$(".flickr_badge_image img, .ads-125 img, #banner-header img, .ads-120x240 img").hover(function() {
			$(this).stop().animate({
				backgroundColor: "#333333"
				}, 300);
			},function() {
			$(this).stop().animate({
				backgroundColor: "#f8f8f8"
				}, 500);
		});
	});
	
// post thumbs + avatar transitions
$(document).ready(function() { 
		$(".category-block .post-thumb img, #picture-posts a.thumb, .tab-thumb img, .tab-comments .avatar, div.slideshow img, #related-posts .post-thumb img").css({
				backgroundColor: "#f8f8f8",
				borderColor: "#e8e8e8"
			});
		$(".category-block .post-thumb img, #picture-posts a.thumb, .tab-thumb img, .tab-comments .avatar, div.slideshow img, #related-posts .post-thumb img").hover(function() {
			$(this).stop().animate({
				backgroundColor: "#333",
				borderTopColor: "#222",
				borderRightColor: "#222",
				borderBottomColor: "#222",
				borderLeftColor: "#222"
				}, 300);
			},function() {
			$(this).stop().animate({
				backgroundColor: "#f8f8f8",
				borderTopColor: "#e8e8e8",
				borderRightColor: "#e8e8e8",
				borderBottomColor: "#e8e8e8",
				borderLeftColor: "#e8e8e8"
				}, 500);
		});
	});
	
// opacity changes
$(document).ready(function() { 
		$("#latest-post .post-thumb img, .attachment-thumbnail-wide").css({
				opacity: 1
			});
		$("#latest-post .post-thumb img, .attachment-thumbnail-wide").hover(function() {
			$(this).stop().animate({
				opacity: 0.8
				}, 300);
			},function() {
			$(this).stop().animate({
				opacity: 1
				}, 500);
		});
	});