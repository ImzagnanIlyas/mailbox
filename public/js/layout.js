$(function () {

    // ------------------------------------------------------- //
    // Sidebar
    // ------------------------------------------------------ //
    $('.sidebar-toggler').on('click', function () {
        $('.sidebar').toggleClass('shrink show clicked');
        $('#newEmail').toggleClass('px-3 px-lg-3');
        $('#content').toggleClass('contentSimple contentToggled');
    });

    $(".sidebar").on("mouseout", function() {
        if ($(this).hasClass("clicked")) {
            $(this).addClass("shrink show");
            $('#newEmail').removeClass('px-3 px-lg-3');
        }
    }).on("mouseover", function() {
        if ($(this).hasClass("clicked")) {
            $(this).removeClass("shrink show");
            $('#newEmail').addClass('px-3 px-lg-3');
        }
    });

    var stylesheet = $('link#theme-stylesheet');
    $( "<link id='new-stylesheet' rel='stylesheet'>").insertAfter(stylesheet);
    var alternateColour = $('link#new-stylesheet');

    if ($.cookie("theme_csspath")) {
        alternateColour.attr("href", $.cookie("theme_csspath"));
    }

    $("#colour").change(function () {

        if ($(this).val() !== '') {

            var theme_csspath = '';
            var tmp = $(this).val();
            theme_csspath = "http://mailbox.test/css/layout/style."+$(this).val()+".css";

            console.log(theme_csspath);
            alternateColour.attr("href", theme_csspath);

            $.cookie("theme_csspath", theme_csspath, { expires: 365, path: document.URL.substr(0, document.URL.lastIndexOf('/')) });

        }

        return false;
    });


});
