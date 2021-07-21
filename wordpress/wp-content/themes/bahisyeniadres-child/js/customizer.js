/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			//$('.site-title').text(to);
			if ( $( '.site-title a' ).length ) {
				$('.site-title a').text(to);
			} else {
				$('.site-title').text(to);
			}
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );




	wp.customize( 'root_color_main', function( value ) {
		value.bind( function( to ) {
			$( '.page-separator, .pagination .current, .pagination a.page-numbers:hover, .entry-content ul li:before, .btn, .comment-respond .form-submit input, .mob-hamburger span, .page-links__item' ).css( 'background-color', to );
            $( '.spoiler-box, .entry-content ol li:before, .mob-hamburger, .inp:focus, .search-form__text:focus, .entry-content blockquote' ).css('border-color', to);
            $( '.entry-content blockquote:before, .spoiler-box__title:after' ).css('color', to);
		} );
	});

	wp.customize( 'root_color_menu_bg', function( value ) {
		value.bind( function( to ) {
			$( '.main-navigation, .footer-navigation, .main-navigation ul li .sub-menu, .footer-navigation ul li .sub-menu' ).css( 'background-color', to );
            $( '.spoiler-box, .entry-content ol li:before, .mob-hamburger' ).css('border-color', to);
            $( '.entry-content blockquote:before, .spoiler-box__title:after' ).css('color', to);
		} );
	});

	wp.customize( 'root_color_text', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).css( 'color', to );
		} );
	});

	wp.customize( 'root_color_link', function( value ) {
		value.bind( function( to ) {
			$( 'a, .spanlink, .comment-reply-link, .pseudo-link' ).css( 'color', to );
		} );
	});

	wp.customize( 'root_color_link_hover', function( value ) {
		value.bind( function( to ) {
			$( 'a:hover, a:focus, a:active, .spanlink:hover, .comment-reply-link:hover, .pseudo-link:hover' ).css( 'color', to );
		} );
	});

	wp.customize( 'root_color_logo', function( value ) {
		value.bind( function( to ) {
            $( '.site-title, .site-title a' ).css( 'color', to );
		} );
	});

    // Цвет ссылок в меню
	wp.customize( 'root_color_menu', function( value ) {
		value.bind( function( to ) {
            $( '.main-navigation ul li a, .main-navigation ul li .removed-link, .footer-navigation ul li a, .footer-navigation ul li .removed-link' ).css( 'color', to );
		} );
	});
	
	

    /********************************************************************
     * Типографика
     *******************************************************************/
	wp.customize( 'root_typography_font_size', function( value ) {
		value.bind( function( to ) {
            $( 'body' ).css( 'font-size', to + 'px' );
		} );
	});

	wp.customize( 'root_typography_line_height', function( value ) {
		value.bind( function( to ) {
            $( 'body' ).css( 'line-height', to );
		} );
	});



    // текст на главной
    wp.customize( 'root_structure_home_h1', function( value ) {
        value.bind( function( to ) {
            $( '.home-header' ).html( to );
        } );
    });

    // текст на главной
    wp.customize( 'root_structure_home_text', function( value ) {
        value.bind( function( to ) {
            $( '.home-text' ).html( to );
        } );
    });






	// Header text color.
	/*wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );*/
} )( jQuery );
