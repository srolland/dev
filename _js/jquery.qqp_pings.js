/*
 *  Project: QQP Pings
 *  Description: Turns WP comments into live chat via ajax
 *  Author: Mathieu Hallé <m@qqpart.ca>
 *  License: ?
 */

;(function ( $, window, document, undefined ) {

    var plugin_name = "qqp_ping",
    	_this,
        defaults = {
            ajaxurl: false,
            _qqp_ping_nonce: false,
            comment_depth: 0,
            
            // ctl
            btn_scroll_top: false,
            ping_status_box: false
            
        };

    // The actual plugin constructor
    function Plugin( element, options ) {
        this.element = element;
        this.$element = jQuery( this.element );
        // referances
		_this = this;
        // jQuery has an extend method which merges the contents of two or
        // more objects, storing the result in the first object. The first object
        // is generally empty as we don't want to alter the default options for
        // future instances of the plugin
        this.options = $.extend( {}, defaults, options );

        this._defaults = defaults;
        this._name = plugin_name;
		this.last_ping_time = 0;
		this.qqp_ping_timer = false;
		this.qqp_ping_pending_shutdown = false;
		this.comment_post_pending = false;
		this.reload_timer = false;
		this.reload_timer_time = 5;
		
		// checking if the box contain a comment form
		this.$form_box = jQuery( 'div.form_box', this.$element );
		if ( this.$form_box.length == 0 ) {
			this.$form_box = this.generate_form_box();
			this.$element.append( this.$form_box );
		}
		
		
		// checking if the box contain a comment <ul> container
		this.$comments_box = jQuery( 'ul.comments_box', this.$element );
		if ( this.$comments_box.length == 0 ) {
			this.$comments_box = this.generate_comments_box();
			this.$element.append( this.$comments_box );
		}
		

		   
		
		
		       
        
        

        this.init();
    }

    Plugin.prototype = {

        init: function() {
            // Place initialization logic here
            // You already have access to the DOM element and
            // the options via the instance, e.g. this.element
            // and this.options
            // you can add more functions like the one below and
            // call them like so: this.yourOtherFunction(this.element, this.options).
            //console.log( "INTI:: " + this._name );
            
            
            
            
            
            
            if ( this.options.btn_scroll_top && this.options.btn_scroll_top.length > 0 ) {
	            
	            this.options.btn_scroll_top.click(function() {
	            	_this.options.btn_scroll_top.removeClass( 'new' );
		            _this.comment_box_scroll_to( 0 );
	            });
            }
            
            
            
            
            this.qqp_ping_startup();
            
            
        },

        yourOtherFunction: function(el, options) {
            // some logic
        },
        
        
		qqp_ping_startup: function() {
			_this.qqp_ping_pending_shutdown = false;
			//$qqp_ping_toggle_btn.val( 'Go offline' ).addClass('online');
			_this.setCookie( "qqp_auto_ping_init" , 'Yes', 365 );
			_this.qqp_ping_init();
		},
		
	
		qqp_ping_shutdown: function() {
			_this.qqp_ping_pending_shutdown = true;
			_this.setCookie( "qqp_auto_ping_init" , 'No', 365 );
		},      
        
        qqp_ping_init: function() {
			_this.qqp_ping( { _do: 'ping',data:{} } );
		},
        
        qqp_ping: function( request_data ) {
        
			var qqp_ping_request_data = {};
			
			var default_request_data = {
				_qqp_ping_nonce: _this.options._qqp_ping_nonce,
				post_id: _this.options.post_id,
				action: 'qqp_pings',
				last_ping_time: _this.last_ping_time,
				_do:	"ping"
			};
			
			//console.log(_this.last_ping_time)
			
			if ( typeof request_data === "undefined" ) {
				var qqp_ping_request_data = default_request_data;
			} else {
				var qqp_ping_request_data = jQuery.extend( default_request_data, request_data );
			}
			//console.log( "sent :" + qqp_ping_request_data._do )
			
			
			//alert("aa")
			jQuery.ajax({
				url: _this.options.ajaxurl + '?rand=' + Math.floor( ( Math.random() * 100000000 ) +1 ),
				datatype: 'json',
				type: 'post',
				data: qqp_ping_request_data,
				timeout: 35000,
				success: function( data, textStatus, jqXHR ) {
					//console.log( "...pong" )
					//console.log( ".. " + qqp_ping_request_data._do + " " + textStatus )
					if ( data.status == 'success' ) {
						_this.qqp_ping_succeeded( data );
					} else { 
						if ( data.status == 'error' ) {
							//if it's a gererated error
						}
						_this.qqp_ping_failed();
					}
					
				},
				error: function(jqXHR, textStatus, errorThrown) {
					if ( qqp_ping_request_data._do == 'comment_post' ) {
						_this.comment_post_pending = false;
						_this.reset_form_box();
					}
					
					if ( qqp_ping_request_data._do == 'ping' ) {
						_this.qqp_ping_failed();
					}
					
					
				}
			});
		}, 
		
		
		qqp_ping_succeeded: function( ping_data ) {
			
			switch( ping_data.did ) {
				case 'ping':
					_this.last_ping_time = ping_data.time;
					_this.qqp_handle_ping_events( ping_data.data );
					_this.qqp_set_ping_timer();
					
					break;
					
				case 'comment_post':

					_this.comment_post_pending = false;
					_this.reset_form_box();
					
					break;	
					
				default:
				
					break;
				
				
			}
		},
        
        qqp_ping_failed: function() {
			//_this.update_ping_status( false );
			_this.qqp_set_ping_timer();
			console.log("Ping Timed Out ....");
		},
	
		qqp_set_ping_timer: function() {
			if ( !this.qqp_ping_pending_shutdown ) {
				_this.qqp_ping_timer = setTimeout( _this.qqp_ping, 10000 );
				_this.set_reload_timer();
			} else {

			}
		},
		
		qqp_handle_ping_events: function( data ) {
		
			for( var kk in data ) {
			
				switch( kk ) {
					case'comments':
						for( var qq in data[kk] ) {
							_this.generate_new_comment( data[kk][qq] );
						}
						
						
						break;
					
					
				}
			
				
				
			}
		
		},







/* UI functions
-------------------------------------------------------------------------------------- */
		
		
		comment_box_scroll_to: function( where ) {
			_this.reset_form_box();
			_this.$comments_box.parents('div:eq(2)').animate({
					scrollTop: '0px'
         	}, 1000, function() {
         		
         	});
		},
		

		
		prapare_form_box: function( where ) {
			
			if ( !_this.comment_post_pending ) {
				_this.reset_form_box();
				var $the_li = jQuery( 'li[rel="' + where + '"]' );
				jQuery( '.comment_ctrl_box', $the_li ).first().after( _this.$form_box );
				jQuery( '.comment_content', _this.$form_box ).focus();
				//jQuery( '.comment_ctrl_box .reply_btn', $the_li ).hide();
			}
			
			
			
		},


		reset_form_box: function() {
		
			if ( !_this.comment_post_pending ) {

				jQuery( '.form_submit_btn', _this.$form_box ).removeClass( 'disabled' );
				
				var $the_li = _this.$form_box.parents( 'li' );
				
				//jQuery( '.comment_ctrl_box .reply_btn', $the_li ).show();
				
				
				jQuery( '.comment_content', _this.$form_box ).val( '' );
				jQuery( '.comment_submit', _this.$form_box ).attr( 'disabled' , '' );
	
				
				_this.$element.prepend( _this.$form_box );
			}
			
		},
		
		post_form_box: function () {
		
		
			
		
			var $the_li = _this.$form_box.parents( 'li' );
			
			var $form_btn = jQuery( '.form_submit_btn', _this.$form_box );
			var $comment_content_box = jQuery( '.comment_content' , _this.$form_box );
			
			
			var comment_parent = $the_li.attr( 'rel' );
			var comment_content = $comment_content_box.val().replace("\n", "");
			
			
			
			
			if ( comment_content != '' && !$form_btn.hasClass( 'disabled' ) ) {
				$form_btn.addClass( 'disabled' );
				_this.qqp_ping( { 
					_do: 'comment_post',
					data:{ 
						comment_parent:comment_parent, 
						comment_content:comment_content 
					}
				});
				_this.comment_post_pending = true;
				
			} else {
				$comment_content_box.parent( 'div' ).addClass( 'error' );
				var to = setTimeout(function() { $comment_content_box.parent( 'div' ).removeClass( 'error' ); } , 100 );
			}
		},
		
		
		
		
		update_reload_timer: function() {
			 if ( _this.options.ping_status_box && _this.options.ping_status_box.length > 0 ) {
			 	if ( _this.reload_timer_time != 0 ) {
				 	_this.options.ping_status_box.html( _this.reload_timer_time );
				 	_this.reload_timer_time = _this.reload_timer_time - 1;
				 	_this.set_reload_timer();
			 	} else {
				 	_this.options.ping_status_box.html( 'loading' );
				 	_this.reload_timer_time = 5;
			 	}
            }
		},

		set_reload_timer: function() {
			clearTimeout( _this.reload_timer );
			_this.reload_timer = setTimeout( _this.update_reload_timer , 1000 );
		},




/* Function to create various DOM element on the interfaces
-------------------------------------------------------------------------------------- */
		generate_form_box: function () {
			
			var form_content;
			var form_class = 'form_box ';
			// check if comment are open
			if ( _this.options.comments_open ) {
				// comments are open, inject the form
				
				var comment_content = jQuery( '<textarea>' )
												.addClass( 'comment_content' )
												.attr( 'placeholder', 'Type your comment here ...' )
												.bind('keydown', function( e ) {
														if(e.keyCode == 13) {
															if ( jQuery( '.form_autosend_btn', _this.$form_box ).is( ':checked' ) ) {
																_this.post_form_box();
																return false;
															}
														}
														return;
													});
				
				var form_col_1 = 	jQuery( '<div>' )
										.addClass( 'form_col_1' )
										.append(
											comment_content
										);
										
										
				var send_btn = jQuery( '<a>' )
									.addClass( 'form_submit_btn' )
									.html( 'Send' )
									.click( function() {
										_this.post_form_box();
										
									})
											
				var form_col_2 = 	jQuery( '<div>' )
										.addClass( 'form_col_2' )
										.append(
											send_btn,
											jQuery( '<label>' )
													.addClass( 'form_autosend_box' )
													.html( 'Press Enter to send' )
													.append(
														jQuery( '<input>' )
															.attr({
																value: true,
																//checked: 'checked',
																type: 'checkbox'
															})
															.addClass( 'form_autosend_btn' )
															.click( function() {
																$this = jQuery( this );
																if ( $this.is(':checked') ) {
																	send_btn.hide();
																} else {
																	send_btn.show();
																}
																comment_content.focus();
															})
													),
											jQuery( '<a>' )
													.addClass( 'form_close_btn' )
													.html( 'Cancel' )
													.click( function() {
														_this.reset_form_box();
													})
										)
				form_content = form_col_1.add(form_col_2);
				form_class += 'logged_in';
			} else {
				form_content = jQuery( '<div>' )
									.addClass( 'form_col_no_form' )
									.append(
										jQuery( '<p>' )
											.append(
												jQuery( '<a>' )
													.attr({ href: '/wp-login.php?redirect_to=' + encodeURIComponent( document.URL ) })
													.html( 'Login' ),
												' or ',
												jQuery( '<a>' )
													.attr({ href: '/wp-login.php?action=register' })
													.html( 'register' ),
												' to comment.'
											)
									)
			}				
			
			
			// form box
			var output = jQuery( '<div>' )
							.addClass( form_class )
							.append(
								form_content
							);

			
			
			
			return output;
		},

		generate_comments_box: function () {
			var output = jQuery('<ul>').addClass('comments_box');
			return output;
		},
		
		generate_new_comment: function( data ) {
			
			//console.log( data );
			
			
			// CHECK IF COMMENT ALREADY EXIST
			var $comment_exist = jQuery( 'li[rel="' + data.comment_ID + '"]', _this.$comments_box );
			if ( $comment_exist.length == 0 ) {
		
				$target = false;

				var reply_btn = '';
				
				// CHECK FOR COMMENTS DEPTH - HIDE REPLY
				$depth = jQuery( 'li[rel="' + data.comment_parent + '"]', _this.$comments_box ).parents( 'ul.comments_box' );
				if ( _this.options.comment_depth -1  > $depth.length ) {
					reply_btn = jQuery( '<a>' )
									.addClass( 'reply_btn' )
									.append( 'Reply' )
									.click(function() {
										_this.prapare_form_box( data.comment_ID );
								})
				}
				
		
				var new_ctrl = 		jQuery( '<div>' )
										.addClass( 'comment_ctrl_box' )
										.append( reply_btn );
										
										
										
						
				var new_comment = 	jQuery( '<li>' )
										.addClass( 'comment' )
										.attr( 'rel' , data.comment_ID )
										.attr( 'id' , 'comment-' + data.comment_ID )
										.append(
											jQuery( '<div>' )
												.addClass( 'comment_col_1' )
												.append( 
													jQuery( '<div>' )
														.addClass( 'comment_gravatar' )
														.append( 
															jQuery( '<img>' )
																.attr({ 
																	src: 'http://www.gravatar.com/avatar/' + MD5( data.comment_author_email ) + '?s=55' ,
																	width: '55px',
																	height: '55px'
																})
																
														)
												 )
										)
										.append(
											jQuery( '<div>' )
												.addClass( 'comment_col_2' )
												.append(
													jQuery( '<div>' )
														.addClass( 'comment_meta_box' )
														.append( 'by ' )
														.append(
															jQuery( '<span>' )
																.addClass( 'comment_author' )
																.append( data.comment_author )
														)
														.append( ' on ' )
														.append(
															jQuery( '<span>' )
																.addClass( 'comment_date' )
																.append( data.comment_date )
														)
												)
												.append(
													jQuery( '<div>' )
														.addClass( 'comment_content' )
														.html( data.comment_content )
												)
	
										)
										.append(
											new_ctrl
										);
				
				
				
				
				if ( data.comment_parent == '0' ) {
					_this.$comments_box.prepend( new_comment );
					
					if ( this.options.btn_scroll_top && this.options.btn_scroll_top.length >0 ) {
						
						//console.log( _this.$comments_box.offset().top );
						if ( _this.$comments_box.offset().top < 0 ) {
							_this.options.btn_scroll_top.addClass( 'new' );
						}
		            }
					
					
					
					
					
					
					
				} else {
					var $the_li = jQuery( 'li[rel="' + data.comment_parent + '"]' );
					
					if ( $the_li.length > 0 ) {
						$the_ul = jQuery( 'ul', $the_li ).first();
						if ( $the_ul.length == 0 ) {
							$the_li.append(
									_this.generate_comments_box()
							);
							$the_ul = jQuery( 'ul', $the_li ).first();
						}
						$the_ul.prepend( new_comment );
					}
				}
			
	
			} // END EXIST CHECK

		},



		










        
        
/* Helper functions
-------------------------------------------------------------------------------------- */


       
	    pad_num: function ( number ) {
			return number < 10 ? "0" + number : number;
		},
		
		getCookie: function (c_name) {
			var i,x,y,ARRcookies=document.cookie.split(";");
			for (i=0;i<ARRcookies.length;i++) {
				x = ARRcookies[i].substr( 0, ARRcookies[i].indexOf( "=" ) );
				y = ARRcookies[i].substr( ARRcookies[i].indexOf( "=" ) + 1 );
				x = x.replace( /^\s+|\s+$/g ,"" );
				if ( x == c_name ) {
					return unescape(y);
				}
			}
		},
		
		setCookie: function( c_name, value, exdays ) {
			var exdate = new Date();
			exdate.setDate( exdate.getDate() + exdays );
			var c_value = escape( value ) + ( ( exdays == null ) ? "" : "; expires=" + exdate.toUTCString() );
			document.cookie = c_name + "=" + c_value;
		},
		
		checkCookie: function() {
			var username = getCookie( "qqp_auto_ping_init" );
			if ( username != null && username == "Yes" )  {
				return true;	
			} else {
				return false;	
			}
		}
        
        
        
/* END
-------------------------------------------------------------------------------------- */	        
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[plugin_name] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + plugin_name)) {
                $.data(this, "plugin_" + plugin_name, new Plugin( this, options ));
            }
        });
    };

})( jQuery, window, document );



	
	
	var getCookie =  function ( c_name ) {
			var i,x,y,ARRcookies=document.cookie.split(";");
			for (i=0;i<ARRcookies.length;i++) {
				x = ARRcookies[i].substr( 0, ARRcookies[i].indexOf( "=" ) );
				y = ARRcookies[i].substr( ARRcookies[i].indexOf( "=" ) + 1 );
				x = x.replace( /^\s+|\s+$/g ,"" );
				if ( x == c_name ) {
					return unescape(y);
				}
			}
		}
		
	var setCookie = function( c_name, value, exdays ) {
			var exdate = new Date();
			exdate.setDate( exdate.getDate() + exdays );
			var c_value = escape( value ) + ( ( exdays == null ) ? "" : "; expires=" + exdate.toUTCString() );
			document.cookie = c_name + "=" + c_value;
		}
		
	
	
	
	
	
	
	var MD5 = function (string) {
 
	function RotateLeft(lValue, iShiftBits) {
		return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
	}
 
	function AddUnsigned(lX,lY) {
		var lX4,lY4,lX8,lY8,lResult;
		lX8 = (lX & 0x80000000);
		lY8 = (lY & 0x80000000);
		lX4 = (lX & 0x40000000);
		lY4 = (lY & 0x40000000);
		lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);
		if (lX4 & lY4) {
			return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
		}
		if (lX4 | lY4) {
			if (lResult & 0x40000000) {
				return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
			} else {
				return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
			}
		} else {
			return (lResult ^ lX8 ^ lY8);
		}
 	}
 
 	function F(x,y,z) { return (x & y) | ((~x) & z); }
 	function G(x,y,z) { return (x & z) | (y & (~z)); }
 	function H(x,y,z) { return (x ^ y ^ z); }
	function I(x,y,z) { return (y ^ (x | (~z))); }
 
	function FF(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function GG(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function HH(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function II(a,b,c,d,x,s,ac) {
		a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
		return AddUnsigned(RotateLeft(a, s), b);
	};
 
	function ConvertToWordArray(string) {
		var lWordCount;
		var lMessageLength = string.length;
		var lNumberOfWords_temp1=lMessageLength + 8;
		var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
		var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
		var lWordArray=Array(lNumberOfWords-1);
		var lBytePosition = 0;
		var lByteCount = 0;
		while ( lByteCount < lMessageLength ) {
			lWordCount = (lByteCount-(lByteCount % 4))/4;
			lBytePosition = (lByteCount % 4)*8;
			lWordArray[lWordCount] = (lWordArray[lWordCount] | (string.charCodeAt(lByteCount)<<lBytePosition));
			lByteCount++;
		}
		lWordCount = (lByteCount-(lByteCount % 4))/4;
		lBytePosition = (lByteCount % 4)*8;
		lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
		lWordArray[lNumberOfWords-2] = lMessageLength<<3;
		lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
		return lWordArray;
	};
 
	function WordToHex(lValue) {
		var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
		for (lCount = 0;lCount<=3;lCount++) {
			lByte = (lValue>>>(lCount*8)) & 255;
			WordToHexValue_temp = "0" + lByte.toString(16);
			WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
		}
		return WordToHexValue;
	};
 
	function Utf8Encode(string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";
 
		for (var n = 0; n < string.length; n++) {
 
			var c = string.charCodeAt(n);
 
			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}
 
		}
 
		return utftext;
	};
 
	var x=Array();
	var k,AA,BB,CC,DD,a,b,c,d;
	var S11=7, S12=12, S13=17, S14=22;
	var S21=5, S22=9 , S23=14, S24=20;
	var S31=4, S32=11, S33=16, S34=23;
	var S41=6, S42=10, S43=15, S44=21;
 
	string = Utf8Encode(string);
 
	x = ConvertToWordArray(string);
 
	a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;
 
	for (k=0;k<x.length;k+=16) {
		AA=a; BB=b; CC=c; DD=d;
		a=FF(a,b,c,d,x[k+0], S11,0xD76AA478);
		d=FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
		c=FF(c,d,a,b,x[k+2], S13,0x242070DB);
		b=FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
		a=FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
		d=FF(d,a,b,c,x[k+5], S12,0x4787C62A);
		c=FF(c,d,a,b,x[k+6], S13,0xA8304613);
		b=FF(b,c,d,a,x[k+7], S14,0xFD469501);
		a=FF(a,b,c,d,x[k+8], S11,0x698098D8);
		d=FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
		c=FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
		b=FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
		a=FF(a,b,c,d,x[k+12],S11,0x6B901122);
		d=FF(d,a,b,c,x[k+13],S12,0xFD987193);
		c=FF(c,d,a,b,x[k+14],S13,0xA679438E);
		b=FF(b,c,d,a,x[k+15],S14,0x49B40821);
		a=GG(a,b,c,d,x[k+1], S21,0xF61E2562);
		d=GG(d,a,b,c,x[k+6], S22,0xC040B340);
		c=GG(c,d,a,b,x[k+11],S23,0x265E5A51);
		b=GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
		a=GG(a,b,c,d,x[k+5], S21,0xD62F105D);
		d=GG(d,a,b,c,x[k+10],S22,0x2441453);
		c=GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
		b=GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
		a=GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
		d=GG(d,a,b,c,x[k+14],S22,0xC33707D6);
		c=GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
		b=GG(b,c,d,a,x[k+8], S24,0x455A14ED);
		a=GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
		d=GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
		c=GG(c,d,a,b,x[k+7], S23,0x676F02D9);
		b=GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
		a=HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
		d=HH(d,a,b,c,x[k+8], S32,0x8771F681);
		c=HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
		b=HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
		a=HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
		d=HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
		c=HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
		b=HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
		a=HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
		d=HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
		c=HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
		b=HH(b,c,d,a,x[k+6], S34,0x4881D05);
		a=HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
		d=HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
		c=HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
		b=HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
		a=II(a,b,c,d,x[k+0], S41,0xF4292244);
		d=II(d,a,b,c,x[k+7], S42,0x432AFF97);
		c=II(c,d,a,b,x[k+14],S43,0xAB9423A7);
		b=II(b,c,d,a,x[k+5], S44,0xFC93A039);
		a=II(a,b,c,d,x[k+12],S41,0x655B59C3);
		d=II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
		c=II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
		b=II(b,c,d,a,x[k+1], S44,0x85845DD1);
		a=II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
		d=II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
		c=II(c,d,a,b,x[k+6], S43,0xA3014314);
		b=II(b,c,d,a,x[k+13],S44,0x4E0811A1);
		a=II(a,b,c,d,x[k+4], S41,0xF7537E82);
		d=II(d,a,b,c,x[k+11],S42,0xBD3AF235);
		c=II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
		b=II(b,c,d,a,x[k+9], S44,0xEB86D391);
		a=AddUnsigned(a,AA);
		b=AddUnsigned(b,BB);
		c=AddUnsigned(c,CC);
		d=AddUnsigned(d,DD);
	}
 
	var temp = WordToHex(a)+WordToHex(b)+WordToHex(c)+WordToHex(d);
 
	return temp.toLowerCase();
}
	
	
	
	
	
