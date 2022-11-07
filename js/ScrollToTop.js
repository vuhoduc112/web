$(document).ready(function() {
    // show and hide scroll to top button on scroll
    $(window).scroll(function() {

        if($(this).scrollTop() > 200) {
            // show button when scroll dowm 200px
            $('.UpToTop').fadeIn();
        } else {
            $('.UpToTop').fadeOut();
        }
    });
});