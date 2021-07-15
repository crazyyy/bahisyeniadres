jQuery(function($) {
    "use strict";

    var width = $(window).width();


    /**
     * Menu
     */
    var $hamburger = $('.mob-hamburger');
    var $menu = $('#site-navigation');
    var $header_menu = $('#header_menu');
    var $top_menu = $('#top_menu');
    var $sidebar_menu = $('.widget-mobile-menu ul');

    var $to_mob_menu = $top_menu.clone();
    var $to_mob_menu_sidebar_menu = $sidebar_menu.clone();
    $to_mob_menu.find('li').addClass('only-hamburger');
    $to_mob_menu_sidebar_menu.find('li').addClass('only-hamburger');

    $hamburger.on('click', function(){
        $hamburger.toggleClass('active');
        $menu.slideToggle();
    });


    /**
     * Fixed menu
     */
    if ( typeof fixed_main_menu !== 'undefined' && fixed_main_menu == 'yes' ) {
        $("#site-navigation").clone().attr('id', '').addClass("site-navigation-fixed").appendTo('body');

        $(window).scroll(function () {
            if ($(this).scrollTop() > $(".site-header").outerHeight() && $(window).width() > 974) {
                $('.site-navigation-fixed').show();
                $('.site-navigation-fixed').css('width', $("#site-navigation").outerWidth());
                $('.site-navigation-fixed').css('left', $("#site-navigation").offset().left);
            } else {
                $('.site-navigation-fixed').hide();
            }
        });

        $(window).resize(function () {
            if ($('.site-navigation-fixed').is(':visible')) {
                $('.site-navigation-fixed').css('width', $("#site-navigation").outerWidth());
                $('.site-navigation-fixed').css('left', $("#site-navigation").offset().left);
            }
        });
    }


    /**
     * Dropdown menu
     */
    var timer;

    if ( width > 991 ) {

        $('.top-menu .menu-item a, .top-menu .menu-item .removed-link, .main-navigation .menu-item a, .main-navigation .menu-item .removed-link').on('mouseenter', function () {
            $(this).parent().parent().find('.sub-menu:visible').hide();
            $(this).parent().find('.sub-menu:first').show();
            clearTimeout(timer);
        });

        $('.top-menu, .main-navigation').on({
            mouseenter: function () {
                clearTimeout(timer);
            },
            mouseleave: function () {
                timer = setTimeout(hideMenu, 400);
            }
        });

    }

    function hideMenu() {
        $('.top-menu .menu-item .sub-menu, .main-navigation .menu-item .sub-menu, .sidebar-navigation .menu-item .sub-menu').slideUp(200);
    }



    if ( width <= 991 ) {

        $('#site-navigation').on('click', '.menu-item-has-children', function (e) {
            if ( e.target.nodeName != 'A' && e.target.nodeName != 'a' ) {
                e.stopPropagation();
                $(this).toggleClass('open');
                $(this).find('.sub-menu:first').slideToggle();
            }
        });

        $('#footer_menu').on('click', '.menu-item-has-children', function (e) {
            if ( e.target.nodeName != 'A' && e.target.nodeName != 'a' ) {
                e.stopPropagation();
                $(this).toggleClass('open');
                $(this).find('.sub-menu:first').slideToggle();
            }
        });

    }

    $('.sidebar-navigation').on('click', '.menu-item-has-children', function (e) {
        if ( e.target.nodeName != 'A' && e.target.nodeName != 'a' ) {
            e.stopPropagation();
            $(this).toggleClass('open');
            $(this).find('.sub-menu:first').slideToggle();
        }
    });


    /**
     * Mob menu transfer
     */
    if ( typeof top_menu_mobile_position !== 'undefined' && top_menu_mobile_position == 'bottom' ) {
        $header_menu.append( $to_mob_menu.html() );
    }
    else {
        $header_menu.prepend( $to_mob_menu.html() );
    }
    $header_menu.append( $to_mob_menu_sidebar_menu.html() );


    /**
     * TOC
     */
    $(document).on('click', '.js-table-of-contents-hide', function() {

        var $toc = $(this).parents('.table-of-contents');

        $toc.toggleClass('open');
        if ( $toc.hasClass('open') ) {
            eraseCookie( 'wpshop_toc_hide' );
            $('.js-table-of-contents-list').slideDown();
        } else {
            createCookie( 'wpshop_toc_hide', 'hide' );
            $('.js-table-of-contents-list').slideUp();
        }

    });
    $(document).on('click', '.table-of-contents a[href*="#"]', function(e){
        var fixed_offset = 100;
        $('html,body').stop().animate({ scrollTop: $(this.hash).offset().top - fixed_offset }, 500);
        e.preventDefault();
    });


    /**
     * Lightbox
     */
    if ( settings_array.lightbox_enabled == true ) {
        $('.entry-content').find("a:has(img)").wpshoplightbox();
        $(document).find("a:has(img.lightbox-open)").wpshoplightbox();
    }


    /**
     * Tables responsive
     */
    $('.entry-content table').wrap( $("<div class='table-responsive' />") );


    /**
     * Spoiler
     */
    $('.js-spoiler-box-title').click(function(){
        var $this = $(this);
        $this.toggleClass('active').next().slideToggle();
    });


    /**
     * Single paged
     */
    console.log(window.location.hash);
    if ( $('body').hasClass('single-paged') && ! window.location.hash ) {
        var destination = $('#main').offset().top;
        $('html,body').animate( { scrollTop: destination }, 800 );
    }


    /**
     * Pseudo links
     */
    jQuery(document).on('click', '.js-link', function (event) {
        var href = jQuery(this).data('href');

        if ( href.substring(0,4) != 'http' ) {
            var base64 = base64_decode(href);
            if ( base64.substring(0,4) == 'http' ) {
                href = base64;
            }
        }

        var target = 'self';
        if ( jQuery(this).data('target') == 'blank' || jQuery(this).data('target') == '_blank' ||
             jQuery(this).attr('target') == 'blank' || jQuery(this).attr('target') == '_blank' ) {
            target = 'blank';
        }

        if ( target == 'blank' ) {
            window.open( href );
        } else {
            document.location.href = href;
        }
    });


    /**
     * Social link share
     */
    $('.js-share-link').click(function(){
        if ( ! $(this).hasClass('js-share-link-no-window') ) {
            openWin($(this).data("uri"));
        } else {
            window.location.href = $(this).data("uri");
        }
    });

    function openWin( url ) {
        var features, w = 626, h = 436;
        var top = (screen.height - h)/2, left = (screen.width - w)/2;
        if(top < 0) top = 0;
        if(left < 0) left = 0;
        features = 'top=' + top + ',left=' +left;
        features += ',height=' + h + ',width=' + w + ',resizable=no';
        open(url, 'displayWindow', features);
    }


    /**
     * Pseudo links
     */
    $('.ps-link').click(function(){
        var uri = base64_decode( $(this).data("uri") );
        window.open(uri);
    });


    /**
     * Star Rating
     */
    $(document).on('click', '.js-star-rating-item', function(){
        var $this = $(this);
        var $parent = $this.parent();
        var score = $this.data('score');
        var post_id = $parent.data('post-id');
        var rating_count = $parent.data('rating-count');
        var rating_sum = $parent.data('rating-sum');
        var rating_value = $parent.data('rating-value');

        if ( $parent.hasClass('disabled') ) return;

        $parent.addClass('disabled process');

        var ajaxdata = {
            action : 'wpshop_star_rating_submit',
            nonce : wps_ajax.nonce,
            post_id : post_id,
            score : score,
            rating_count: rating_count,
            rating_sum: rating_sum,
            rating_value: rating_value
        };
        jQuery.post( wps_ajax.url, ajaxdata, function( response ) {
            if ( response.success ) {

                rating_sum = rating_sum + score;
                rating_count++;

                rating_value = (rating_sum / rating_count).toFixed(2);

                var rating_count_text = 'assessment';

                var lang = $('html').attr('lang');

                if ( typeof rating_count_text_filter  !== 'undefined' ) {
                    rating_count_text = rating_count_text_filter;
                } else {
                    if ( lang == 'ru-RU' ) {
                        rating_count_text = decOfNum(rating_count, ['оценка', 'оценки', 'оценок']);
                    }

                    if ( lang == 'uk' ) {
                        rating_count_text = decOfNum(rating_count, ['оцінка', 'оцінки', 'оцінок']);
                    }
                }

                $this.parent().parent().find('.star-rating-text').html('<em>( <strong>' + rating_count + '</strong> ' + rating_count_text + ', ' + settings_array.rating_text_average + ' <strong>' + rating_value + '</strong> ' + settings_array.rating_text_from + ' <strong>5</strong> )</em></div>');

            } else {
                if ( response.data == 'already' ) {
                    //alert('already');
                }
                console.log(response);
            }
            $parent.removeClass('process');
        });

        function decOfNum(number, titles) {
            var cases = [2, 0, 1, 1, 1, 2];
            return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
        }

    });

    $('.js-star-rating-item').on({
        mouseenter: function () {
            if ( $(this).parent().hasClass( 'disabled' ) ) return;
            $(this).parent().addClass('hover');
            $(this).addClass('hover').prevAll().addClass('hover');
        },
        mouseleave: function () {
            if ( $(this).parent().hasClass( 'disabled' ) ) return;
            $(this).parent().removeClass('hover');
            $('.js-star-rating-item').removeClass('hover');
        }
    });


    /**
     * Smiles
     */
    $('.js-comment-smiles img').click(function(){
        var $this = $(this);
        $('#comment').val( $('#comment').val() + ' ' + $this.prop('alt') + '' );
    }).on('dragstart', function(event) { event.preventDefault(); });


    /**
     * Adaptive videos
     */
    responsiveIframe();
    $(window).resize(function(){
        responsiveIframe();
    });

    function responsiveIframe() {
        $('.entry-content iframe, .responsive-iframe iframe').each(function(){

            if ( $(this).parents('.not-responsive').length ) return;
            if ( $(this).width() <= $(this).parent().width() ) return;

            var iw = $(this).width();
            var ih = $(this).height();
            var ip = $(this).parent().width();
            var ipw = ip/iw;
            var ipwh = Math.round(ih*ipw);
            $(this).css({
                'width': ip,
                'height' : ipwh
            });
        });
    }


    /**
     * Scroll to top
     */
    var $scroll_btn = $(".js-scrolltop");

    $scroll_btn.click(function () {
        return $("body,html").animate({
            scrollTop: 0
        }, 500);
    });

    $(window).scroll(function () {
        if ( $(this).scrollTop() > 100 ) {
            if (width < 991) {
                if ( $scroll_btn.data('mob') == 'on' ) {
                    $scroll_btn.fadeIn();
                }
            } else {
                $scroll_btn.fadeIn();
            }
        } else {
            $scroll_btn.fadeOut();
        }
    });

});


/**
 * Urlspan
 */
function GoTo(link){window.open(link.replace("_","http://"));}


// Функция декодирования строки из base64
// Функция декодирования строки из base64
function base64_decode (encodedData) { // eslint-disable-line camelcase
    //  discuss at: http://locutus.io/php/base64_decode/
    // original by: Tyler Akins (http://rumkin.com)
    // improved by: Thunder.m
    // improved by: Kevin van Zonneveld (http://kvz.io)
    // improved by: Kevin van Zonneveld (http://kvz.io)
    //    input by: Aman Gupta
    //    input by: Brett Zamir (http://brett-zamir.me)
    // bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
    // bugfixed by: Pellentesque Malesuada
    // bugfixed by: Kevin van Zonneveld (http://kvz.io)

    if (typeof window !== 'undefined') {
        if (typeof window.atob !== 'undefined') {
            return decodeURIComponent(escape(window.atob(encodedData)));
        }
    } else {
        return new Buffer(encodedData, 'base64').toString('utf-8');
    }

    var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
    var o1;
    var o2;
    var o3;
    var h1;
    var h2;
    var h3;
    var h4;
    var bits;
    var i = 0;
    var ac = 0;
    var dec = '';
    var tmpArr = [];

    if (!encodedData) {
        return encodedData;
    }

    encodedData += '';

    do {
        // unpack four hexets into three octets using index points in b64
        h1 = b64.indexOf(encodedData.charAt(i++));
        h2 = b64.indexOf(encodedData.charAt(i++));
        h3 = b64.indexOf(encodedData.charAt(i++));
        h4 = b64.indexOf(encodedData.charAt(i++));

        bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;

        o1 = bits >> 16 & 0xff;
        o2 = bits >> 8 & 0xff;
        o3 = bits & 0xff;

        if (h3 === 64) {
            tmpArr[ac++] = String.fromCharCode(o1);
        } else if (h4 === 64) {
            tmpArr[ac++] = String.fromCharCode(o1, o2);
        } else {
            tmpArr[ac++] = String.fromCharCode(o1, o2, o3);
        }
    } while (i < encodedData.length);

    dec = tmpArr.join('');

    return decodeURIComponent(escape(dec.replace(/\0+$/, '')));
}

function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    } else {
        expires = "";
    }
    document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = encodeURIComponent(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}