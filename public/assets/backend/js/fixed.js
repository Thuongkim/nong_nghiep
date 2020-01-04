$(document).ready(function() {

    $('.countdown').on("propertychange keyup input paste", function () {
        var limit = $(this).attr("maxlength");
        if(limit == 0 || limit == '' || limit === undefined)
            limit = 255;
        $(this).prev('span').text(limit);

        var remainingChars = limit - $(this).val().length;
        if (remainingChars <= 0) {
            $(this).val($(this).val().substring(0, limit));
        }
        $(this).prev('span').text((remainingChars <= 0) ? 0 : remainingChars);

    });

    $(document).on( 'scroll', function(){

        if ($(window).scrollTop() > 100) {
            $('.scroll-top-wrapper').addClass('show');
        } else {
            $('.scroll-top-wrapper').removeClass('show');
        }
    });

    $('.scroll-top-wrapper').on('click', scrollToTop);
});

function ajaxLoader (el, options) {
    // Becomes this.options
    var defaults = {
        bgColor         : '#fff',
        duration        : 800,
        opacity         : 0.7,
        classOveride    : false,
    }
    this.options    = jQuery.extend(defaults, options);
    this.container  = $(el);

    this.init = function() {
        var container = this.container;
        // Delete any other loaders
        this.remove();
        // Create the overlay
        var overlay = $('<div></div>').css({
            'background-color': this.options.bgColor,
            'opacity':this.options.opacity,
            'width':'100%',
            'height':'100%',
            'position':'fixed',
            'top':'0%',
            'left':'0%',
            'z-index':99999
        }).addClass('ajax_overlay');
        // add an overiding class name to set new loader style
        if (this.options.classOveride) {
            overlay.addClass(this.options.classOveride);
        }

        // insert overlay and loader into DOM
        container.append(
            overlay.append(
                $('<div></div>').addClass('ajax_loader')
                ).fadeIn(this.options.duration)
            );
    };

    this.remove = function(){
        var overlay = this.container.children(".ajax_overlay");
        if (overlay.length) {
            overlay.fadeOut(this.options.classOveride, function() {
                overlay.remove();
            });
        }
    }

    this.init();
}

function scrollToTop() {
    verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
    element = $('body');
    offset = element.offset();
    offsetTop = offset.top;
    $('html, body').animate({scrollTop: offsetTop}, 500, 'linear');
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function imgDefaultLoadError( image ) {
    image.onerror = "";
    image.src = "../../../../../assets/img/404.jpg";
    return true;
}