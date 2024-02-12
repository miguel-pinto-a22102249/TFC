$(document).foundation()
$(document).ready(function () {

    //Slider Home
    const swiperHome = new Swiper('.slider-home', {});

    //Depois do DOM estar carregado
    /*(function() {
     var state = document.readyState;
     if (state === 'complete') {
     // Para remover a div de loading
     $(".loading").fadeOut(300, function() {
     $(this).remove();
     });
     //WOW
     wow = new WOW(
     {
     boxClass: 'wow', // default
     animateClass: 'animated', // default
     offset: 0, // default
     mobile: true, // default
     live: true        // default
     }
     )
     wow.init();
     
     } else
     setTimeout(arguments.callee, 100);
     })();*/

    setTimeout($(".loading").fadeOut(300, function () {
        $(this).remove();
    }), 1000);

    //Slick
    const swiperTestemunhos = new Swiper('.slider-testemunhos', {
        direction: 'horizontal',
        loop: true,
    });



    /*************** DATA TABLE ******************/
//    $('#table_id').DataTable();
//    $('.dataTable').DataTable({
//        "order": [[$('th.defaultSort').index(), 'desc']],
//        "pagin": true,
//        "pagingType": "full_numbers",
//        "language": {
//            "lengthMenu": "Número de registos por página  _MENU_",
//            "zeroRecords": "Não encontrámos nada",
//            "info": "Página _PAGE_ de _PAGES_",
//            "infoEmpty": "Não existem resultados disponiveis",
//            "infoFiltered": "(filtrado de um total de _MAX_ registros)",
//            "search": "Pesquisar",
//            "paginate": {
//                "previous": "<",
//                "next": ">",
//                "last": "Última",
//                "first": "Primeira"
//            }
//        },
//    });
    /********************************************/

    $('.open-popup-link').magnificPopup({
        type: 'inline',
        midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
    });

    $(".table-accordion .trigger").on("click", function () {
        $(".tr-accordion").toggleClass("open").next(".fold").toggleClass("open");
    });


//    var lazyLoadInstance = new LazyLoad({
//        elements_selector: ".lazy"
//    });


//Colocar menu visivel no scroll up
    var prev = 0;
    var $window = $(window);
    var $nav = $('.scrollhide-nav');
    var scrollTop = $window.scrollTop();
    var offsetTop = window.pageYOffset;

    if (offsetTop === 0) {
        //Adicionar class quando está no topo do site
        $nav.addClass("nav--top");
        $nav.removeClass("nav--not-top");
    } else {
        //Adicionar class quando não está no topo do site
        $nav.addClass("nav--not-top");
        $nav.removeClass("nav--top");

    }

    $window.on('scroll', function () {
        scrollTop = $window.scrollTop();
        offsetTop = window.pageYOffset;
        $nav.toggleClass('hidden', scrollTop > prev);

        if (offsetTop === 0) {
            //Adicionar class quando está no topo do site
            $nav.addClass("nav--top");
            $nav.removeClass("nav--not-top");
        } else {
            //Adicionar class quando não está no topo do site
            $nav.addClass("nav--not-top");
            $nav.removeClass("nav--top");

        }

        if ($(window).width() <= 1023) {
            $('.top-bar').css({display: "none"});
        }

        prev = scrollTop;
    });


    //    POPUP GENERRICO QUE ABRE AUTOMATICAMENTE
    $('.dialog__close-button').off('click.close');
    $('.dialog__close-button').on('click.close', function () {
        $('body').css("overflow-y", "scroll");
        $('.dialog').css("display", "none");
        Cookies.set('__info_generica', 1, {expires: 1});
    });


//************************** Popup pré inscrição **************************
//    ABRIR POPUP AUTOMATICAMENTE
//    if (Cookies.get('pre-inscricao') != 1) {
//        setTimeout(function () {
//            $('.popup-pre-inscricao').css({
//                "background-color": "rgba(black, 0.8)",
//                "display": "inline-block",
//                "transition": "all .5s ease-in-out",
//                "transform": "scale(1)"});
//            $('.popup-pre-inscricao').css("background-color", "rgba(0,0,0,0.7)");
//            $('body').css("overflow-y", "hidden");
//        }, 6000);
    $('.close-button').off('click.close');
    $('.close-button').on('click.close', function () {
        $('body').css("overflow-y", "scroll");
        $('.popup-pre-inscricao').css("display", "none");

        //Se a pessoa fechar a dialog e ja tiver aceite os cookies
        // é colocado um cookie para que nao volte a abrir durante 7 dias
//        Cookies.set('pre-inscricao', 1, {expires: 7});
    });
    //Parar abrir o form por um <a>
    $('.btn-abrir-pre-inscricao ').off('click.abrir');
    $('.btn-abrir-pre-inscricao ').on('click.abrir', function () {
        $('.popup-pre-inscricao').css({
            "background-color": "rgba(black, 0.8)",
            "display": "inline-block",
            "transition": "all .5s ease-in-out",
            "transform": "scale(1)"});
        $('.popup-pre-inscricao').css("background-color", "rgba(0,0,0,0.7)");
        $('body').css("overflow-y", "hidden");
    });


//**************************************************************************

//**************************** Barra de cookies ******************************


    $('#btn-aceitar-cookies').off('click.aceitar');
    $('#btn-aceitar-cookies').on('click.aceitar', function () {
        $('.wrapper-cookies').hide();
        Cookies.set('__accepted_cookies', 1, {expires: 7});
    });
    $('#btn-aceitar-cookies-recomendados').off('click.aceitar');
    $('#btn-aceitar-cookies-recomendados').on('click.aceitar', function () {
        $.magnificPopup.close();
        $('.wrapper-cookies').hide();
        Cookies.set('__accepted_cookies', 1, {expires: 7});
    });

    $('#btn-guardar-cookies').off('click.aceitar');
    $('#btn-guardar-cookies').on('click.aceitar', function () {
        $.magnificPopup.close();
        $('.wrapper-cookies').hide();
        Cookies.set('__accepted_cookies', 1, {expires: 7});
    });

    $('#btn-configurar-cookies').off('click.configurar');
    $('#btn-configurar-cookies').on('click.configurar', function () {
        $.magnificPopup.open({
            items: {
                src: '.configurar-cookies',
            }});
    });

//*****************************************************************************

    equalizeULItemsHeight();

});

/**
 * André Carvalho
 * Serve para equalizar em altura os LI numa linha
 *
 */
equalizeULItemsHeight = function () {
    var elements = {};
    $('.ul-equalize').children('li').each(function () {
        var key = $(this).offset().top + '';
        if (!elements[key]) {
            elements[key] = {
                'minHeight': 0,
                'els': []
            };
        }

        var outerHeight = $(this).find('.description').outerHeight();
        if (elements[key].minHeight < outerHeight) {
            elements[key].minHeight = outerHeight;
        }


        elements[key].els.push($(this).find('.description'));
    });
    $.each(elements, function (k, v) {
        var minHeight = v.minHeight;
        $.each(v.els, function (key, $el) {
            $el.css('min-height', minHeight);
        });
    });
//    alert('das')
};


