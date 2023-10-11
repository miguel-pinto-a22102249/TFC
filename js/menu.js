$(document).ready(function() {
    console.log('menu.js');
    $('.open-menu-btn').on('click', function() {
        console.log('open-menu-btn');
        if ($('body').hasClass('closed-menu')) {
            $('body').removeClass('closed-menu');
        } else {
            $('body').addClass('closed-menu');
        }
    });
});