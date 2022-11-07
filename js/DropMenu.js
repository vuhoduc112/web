$(document).ready(function() {
    $('#drop').on('click', function() {
        $(".subitem").toggleClass('show-dropdown');
        $('.cheveron').toggleClass("show-dropdown");
    });
});