$(document).ready(function() {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('.go-top').fadeIn();
        } else {
            $('.go-top').fadeOut();
        }
    });

    $('.go-top').click(function() {
        $('#back-to-top').tooltip('hide');
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    $('.go-top').tooltip('show');

    $('[data-toggle="tooltip"]').tooltip();
    
    $('.carousel').carousel({
        wrap: false
    });
    
});