;(function( $, window, document, undefined )
{
	$.fn.doubleTapToGo = function( params )	{
		if( !( 'ontouchstart' in window ) &&
			!navigator.msMaxTouchPoints &&
			!navigator.userAgent.toLowerCase().match( /windows phone os 7/i ) ) return false;

		this.each( function() {
			var curItem = false;

			$( this ).on( 'click', function( e ) {
				var item = $( this );
				if( item[ 0 ] != curItem[ 0 ] ) {
					e.preventDefault();
					curItem = item;

				}
			});

			$( document ).on( 'click touchstart MSPointerDown', function( e ) {
				var resetItem = true,
					parents	  = $( e.target ).parents();

				for( var i = 0; i < parents.length; i++ )
					if( parents[ i ] == curItem[ 0 ] )
						resetItem = false;

				if( resetItem )
					curItem = false;
			});
		});
		return this;
	};


})( jQuery, window, document );

$(function(){

    var w = $(window);

    function eqHeight(el) {
        var maxHeight = 0;
        $( el ).each( function( ) {
            maxHeight = Math.max( maxHeight,$( this ).height( ) );
        } ).each( function( ) {
            if( !$(this).hasClass( 'inner' ) )
            $( this ).css( 'height', maxHeight + 'px' );
        });
    }



    $('.js-fancybox').fancybox({
        'maxWidth' : '1200',
        'maxHeight': '900',
        'helpers' : {
            'title' : { 'type' : 'inside' }
        }
    });

    w.bind('ready', function () {
        $( '.nav .parent' ).doubleTapToGo();
    });


    /* Navigation Off-Canvas */

    $('#nav_switch').bind( 'tap click', function() {

        var nav_wrap = $('#nav_wrap'),
            nav1 = $('.nav.lvl-1'),
            nav_switch = $(this);


        if( nav1.hasClass('is-open') ) {
            nav1.removeClass('is-open');
            nav_switch.addClass('icon-menu').removeClass('icon-cancel fix');
            //$('body').css('overflow', 'visible').removeClass('dimm');
        }
        else {
            nav1.addClass('is-open');
            nav_switch.addClass('icon-cancel').removeClass('icon-menu');
            //$('body').css('overflow', 'hidden').addClass('dimm');
        }
    });

    $('.tab').click(function () {
        if( $(this).hasClass('closed') ){
            $('.tab.open').toggleClass('open').toggleClass('closed');
            $(this).toggleClass('open').toggleClass('closed');
        }
    });



    // scrolling effects used only on IE9+ and modern browsers
    //if( 1000 < w.width() && false === $('html').hasClass('old-ie') ) {
//
//        $(window).on('resize',function() {
//            $('.intro','#home').css('height', w.height()+'px');
//            $('.tabs','#home').css('height', ( w.height() - $('.nav_wrap').height() - $('.footer').height() ) + 'px');
//        }).trigger('resize');
//
//
//        var scrollToContent = function(){
//            $( 'html,body').animate({'scrollTop': $('#content').offset().top + 'px'}, 1500 );
//        };
//
//        var vid = $('.intro-video').get(0);
//
//        $( '.intro-stop, .intro-video' ).click(function (e) {
//
//            if( !vid.paused ) {
//
//                vid.pause();
//                scrollToContent();
//            }
//            else {
//                vid.play();
//            }
//            return false;
//        });
//
//
//        vid.onended = function() { scrollToContent(); };
//
//        if( $('#home').length > 0 ) {
//            var scrollingScreen = false,
//                lastScrollTop = 0,
//                top = $("body").scrollTop() || // Chrome places overflow at body
//                      $("html").scrollTop();   // Firefox places it at html
//
//            $("body").mousewheel(function(event, delta) {
//                if ( !scrollingScreen ) {
//                    scrollingScreen = true;
//                    if ( delta > 0 ) {
//                        top = $('.intro').offset().top;
//                        vid.play();
//                    }
//                    else if ( delta < 0 ) {
//                        top = $('#content').offset().top;
//                        vid.pause();
//                    }
//
//                    $("html,body").animate({ scrollTop:top }, 1500, 'swing', function() {
//                        scrollingScreen = false; // Releases the throttle
//                    });
//                }
//                return false;
//            });
//
//        }
//    }

});
