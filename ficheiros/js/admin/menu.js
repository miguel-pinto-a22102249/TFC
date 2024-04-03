$(document).ready(function() {

    $('.open-menu-btn').on('click', function() {
        if ($('body').hasClass('closed-menu')) {
            $('body').removeClass('closed-menu');
            $('#logo').removeClass('hide');
            $('#icon').addClass('hide');
            setTimeout(function() {

            }, 1000);
        } else {
            $('body').addClass('closed-menu');
            $('#logo').addClass('hide');
            $('#icon').removeClass('hide');
        }
    });


    // Para o menu dropdown lateral
    let dropdown = document.getElementsByClassName("dropdown-btn");
    let i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            $('#sidebar .dropdown-container').css('display', 'none');
            $('#sidebar .dropdown-btn').removeClass('active');
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }

});