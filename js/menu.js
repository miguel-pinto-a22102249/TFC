$(document).ready(function() {

    $('.open-menu-btn').on('click', function() {
        if ($('body').hasClass('closed-menu')) {
            $('body').removeClass('closed-menu');
            $('#logo').removeClass('hide');
            $('#icon').addClass('hide');
        } else {
            $('body').addClass('closed-menu');
            $('#logo').addClass('hide');
            $('#icon').removeClass('hide');
        }
    });
});