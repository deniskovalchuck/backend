/*!
 * Adminux (http://maxartkiller.com)
 * Copyright 2017 The Adminux Author: Maxartkiller
 * purchase licence before use
 * You can not resale and/or modify without prior licences.
 */

"use strict";

$(document).on("ready", function() {

    /*LAYOUT CONTENT SCRIPT*/
    var body_1 = $('body');



    if (body_1.hasClass("scroll_header") === true) {
        $(window).on("scroll", function() {
            if ($(document).scrollTop() >= 250) {
                body_1.addClass("active_scroll");
            } else {
                body_1.removeClass("active_scroll");
            }
        });
    }




    /* theme picker js starts here */

    //load selected color css
    if ($.type($.cookie("themecolor")) != 'undefined' && $.cookie("themecolor") != '') {
        $('link[title=styles-animations]').prop('disabled', true);
        $('head').append('<link rel="stylesheet" href="../css/' + $.cookie("themecolor") + '.css" type="text/css" title="styles-animations">');
        $('.select-color').prop("checked", false);
        $("input[data-color='" + $.cookie("themecolor") + "']").prop("checked", true);
    }
    $('.select-color').on('change', function() {
        $.cookie("themecolor", $(this).attr('data-color'), { expires: 7 });
        $('link[title=styles-animations]').prop('disabled', true);
        $('head').append('<link rel="stylesheet" href="../css/' + $.cookie("themecolor") + '.css" type="text/css" title="styles-animations">');
        //$('#themepicker').modal('toggle');
    });

    //load selected reading
    if ($.type($.cookie("themereading")) != 'undefined' && $.cookie("themereading") != '') {
        $('.select-reading').prop("checked", false);
        $('body').addClass($.cookie("themereading"));
        $("input[data-reading='" + $.cookie("themereading") + "']").prop("checked", true);
    }
    $('.select-reading').on('change', function() {
        $.cookie("themereading", $(this).attr('data-reading'), { expires: 7 });
        if ($(this).attr('data-reading') === 'rtl-read') { $('body').addClass("rtl-read"); } else { $('body').removeClass("rtl-read"); }
        //$('#themepicker').modal('toggle');
    });

    //load selected rounded
    if ($.type($.cookie("themerounded")) != 'undefined' && $.cookie("themerounded") != '') {
        $('.select-rounded').prop("checked", false);
        $('body').addClass($.cookie("themerounded"));
        $("input[data-rounded='" + $.cookie("themerounded") + "']").prop("checked", true);
    }
    $('.select-rounded').on('change', function() {
        $.cookie("themerounded", $(this).attr('data-rounded'), { expires: 7 });
        if ($(this).attr('data-rounded') === 'rounded') { $('body').addClass("rounded"); } else { $('body').removeClass("rounded"); }
        //$('#themepicker').modal('toggle');
    });
    /* theme picker js starts ends here */









    $(window).on("load", function() {

        /*cicular progress sidebar home page 
        $('.progress_profile').circleProgress({
            fill: { gradient: ["#2ec7cb", "#6c8bef"] },
            lineCap: 'butt'
        });
*/
        /* Sparklines can also take their values from the first argument   passed to the sparkline() function */
        var myvalues = [10, 8, 5, 7, 4, 2, 8, 10, 8, 5, 6, 4, 1, 7, 4, 5, 8, 10, 8, 5, 6, 4, 4];
        $('.dynamicsparkline').sparkline(myvalues, { type: 'bar', width: '100px', height: '20', barColor: '#cccccc', barWidth: '2', barSpacing: 2 });

        var myvalues2 = [10, 8, 5, 7, 4, 2, 8, 10, 8, 5, 6, 4, 1, 7, 4, 5, 8, 10, 8, 5, 6, 4, 4, 1, 7, 4, 5, 8, 10, 8, 5, 6, 4, 4];
        $('.dynamicsparkline2').sparkline(myvalues2, { type: 'bar', width: '200px', height: '60', barColor: '#cccccc', barWidth: '3', barSpacing: 3 });







        /*Full screen result container show*/
        $('#search_header').on('focus', function() {
            $(".search-block").show();
            body_1.addClass('searchshow');
            $('#search_header').focusout();

        });

        /* Search window screen fullscreen open */
        $('.search-block .close-btn').on('click', function() {
            $(".search-block").slideUp();
            body_1.removeClass('searchshow');
        });

        /* on keypress hide search block which was in fullscreen */
        $(document).keyup(function(e) {
            if (e.keyCode == 27) { // escape key maps to keycode `27`
                $(".search-block").fadeOut();
                body_1.removeClass('searchshow');
                $('#search_header').focusout();
            }
        });

        /* inbox mail page  collapsible */
        $(".inboxmenu").on("click", function() {
            $(".mailboxnav ").toggleClass("mailboxnavopen");
        });
        $(".filemenu_btn").on("click", function() {
            $(".filemenu ").toggleClass("filemenuopen");
        });

        /* loading screen */
        $(".loader_wrapper").fadeOut("slow");

    });
    /* Custom css checkbox script */
    $('.form-check-input').on('change', function() {
        $(this).parent().toggleClass("active")
        $(this).closest(".media").toggleClass("active");
    });

    /* Card fullscreeen button script */
    $('.fullscreen-btn').on('click', function() {
        $(this).closest(".full-screen-container").toggleClass("fullscreen");
        body_1.toggleClass("fullscreen");
    });
    /* Card fullscreeen button script ends */

    /* Card fullscreeen button script */
    $('.push-cookie .alert.top .close, .push-cookie .alert.top .btn-secondary').on('click', function() {
        body_1.removeClass("push-cookie");
    });



});