/**
 * WPShop Lightbox
 *
 * @version   1.0.1
 *
 * Changelog
 *
 * 1.0.1    2019-11-07      Add image check formats: webp, svg
 */

(function(window, document, $) {
    "use strict";

    // jquery required
    if (!$) return;

    $.fn.wpshoplightbox = function(options) {
        var selector;
        var $this = $(this);

        var container =
                '<div class="wpshoplightbox-container" role="dialog" tabindex="-1">' +
                '<div class="wpshoplightbox-bg"></div>' +
                '<div class="wpshoplightbox-inner">' +
                '<div class="wpshoplightbox-close"><svg width="17" height="17" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M-1-1h19v19h-19z"/><path fill="#fff" d="M8.485 7.071l-7.071-7.071-1.414 1.414 7.071 7.071-7.071 7.071 1.414 1.414 7.071-7.071 7.071 7.071 1.414-1.414-7.071-7.071 7.071-7.071-1.414-1.414-7.071 7.071z"/></svg></div>' +
                '<div class="wpshoplightbox-body"><div class="wpshoplightbox-image"></div></div>' +
                '<div class="wpshoplightbox-caption"></div>' +
                "</div>" +
                "</div>",
            $container = $(container);

        options = options || {};

        // on click on link with href
        $this.on('click', function(){

            var $current = $(this);
            var image_src = $current.attr('href');
            var img = document.createElement("img"),
                $img = $(img);

            if ( image_src.match(/(\.jpg|\.gif|\.jpeg|\.png|\.webp|\.svg)$/i) ) {

                $img.attr('src', image_src);

                // append container
                var box = $container.appendTo("body")[0];

                // scroll disappear fix
                $('head').append(
                    '<style id="wpshoplightbox-scroll-style" type="text/css">.wpshoplightbox-scroll{margin-right:' +
                    (window.innerWidth - document.documentElement.clientWidth) +
                    "px;}</style>"
                );
                $('body').addClass('wpshoplightbox-scroll');

                // add image in lightbox
                $container.find('.wpshoplightbox-image').html($img);

                // timeout need for animation
                setTimeout(function () {
                    $container.addClass('wpshoplightbox--open');
                }, 10);

                return false;

            }
        });


        $(document).on('click', '.wpshoplightbox-body, .wpshoplightbox-close', function() {
            close();
        });

        function close() {
            $(document).find('.wpshoplightbox-container').removeClass('wpshoplightbox--open');
            setTimeout(function(){
                $(document).find('.wpshoplightbox-container').remove();
            }, 400);
            $('body').removeClass('wpshoplightbox-scroll');
            $("#wpshoplightbox-scroll-style").remove();
        }

    };

})(window, document, jQuery);