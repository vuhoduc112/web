var Scrollposition =0;
$(document).ready(function() {
    $(window).on('scroll', function(){
        $('#nav').toggleClass('hiden', $(window).scrollTop() > Scrollposition);
        Scrollposition = $(window).scrollTop();
    });
});