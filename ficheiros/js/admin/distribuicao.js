$(document).ready(function() {

    $(".form-distribuicao").submit(function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário

        var form = $(this);
        var formData = new FormData(form[0]);

        if ($('.form-mask').length > 0) {
            $('.form-mask').addClass('is-active');
            $('.form-mask').append('<div class="loading"></div>');
        } else {
            $(this).addClass('is-active');
            $(this).append('<div class="loading"></div>');
        }

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {

                $('.is-active').removeClass('is-active');
                $('.loading').remove();

                if (response.success === false) {
                    let errors = response.errors;

                    $('.error').remove(); // Remove todos os erros existentes

                    $.each(errors, function(key, value) {
                        let fieldName = value.field;
                        let errorMessage = value.message;
                        let targetElement = form.find('[name="' + fieldName + '"]').next('.error');


                        if (targetElement.length === 0) {
                            // Se a div de erro não existir, crie-a
                            form.find('[name="' + fieldName + '"]').after("<small class='error'>" + errorMessage + "</small>");
                        } else {
                            // Se a div de erro já existe, apenas atualize o conteúdo
                            targetElement.html(errorMessage);
                        }
                        notie.alert({type: 3, text: "Algo de errado aconteceu", stay: true});
                    });
                } else {
                    // console.log(response);
                    $('.Area-Disctribuicao').html(response.view);

                    setTimeout(function() {
                        $(document).ready(function() {
                            $('.dataTable').DataTable({
                                "order": [[$('th.defaultSort').index(), 'desc']],
                                "paging": true,
                                "responsive": true,
                                "pagingType": "full_numbers",
                                "rowsGroup": [0], // Agrupa pela primeira coluna
                                "language": {
                                    "lengthMenu": "Número de registos por página  _MENU_",
                                    "zeroRecords": "Não encontrámos nada",
                                    "info": "Página _PAGE_ de _PAGES_",
                                    "infoEmpty": "Não existem resultados disponiveis",
                                    "infoFiltered": "(filtrado de um total de _MAX_ registros)",
                                    "search": "Pesquisar",
                                    "paginate": {
                                        "previous": "<",
                                        "next": ">",
                                        "last": "Última",
                                        "first": "Primeira"
                                    }
                                }
                            });
                        });
                    }, 100);


                    // $('form').remove();

                    notie.alert({type: 1, text: response.message, stay: true});
                    if (!form.hasClass('no-reset')) {
                        form[0].reset(); // Limpa os campos do formulário
                    }
                    submitFormDistribuicaoPasso2();
                }
            }
        });

    });


});

function submitFormDistribuicaoPasso2() {
    $(".form-distribuicao-passo2").submit(function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        e.stopPropagation();

        var form = $(this);
        var formData = new FormData(form[0]);

        if ($('.form-mask').length > 0) {
            $('.form-mask').addClass('is-active');
            $('.form-mask').append('<div class="loading"></div>');
        } else {
            $(this).addClass('is-active');
            $(this).append('<div class="loading"></div>');
        }

        notie.confirm({
            text: "Tem a certeza que deseja gravar esta distribuição?",
            submitText: 'Sim',
            cancelText: 'Não'
        }, function() {
            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('.is-active').removeClass('is-active');
                    $('.loading').remove();

                    if (response.success === false) {
                        let errors = response.errors;

                        $('.error').remove(); // Remove todos os erros existentes

                        $.each(errors, function(key, value) {
                            let fieldName = value.field;
                            let errorMessage = value.message;
                            let targetElement = form.find('[name="' + fieldName + '"]').next('.error');


                            if (targetElement.length === 0) {
                                // Se a div de erro não existir, crie-a
                                form.find('[name="' + fieldName + '"]').after("<small class='error'>" + errorMessage + "</small>");
                            } else {
                                // Se a div de erro já existe, apenas atualize o conteúdo
                                targetElement.html(errorMessage);
                            }
                            notie.alert({type: 3, text: "Algo de errado aconteceu", stay: true});
                        });
                    } else {
                        $('.Area-Disctribuicao').html(response.view);

                        notie.alert({type: 1, text: response.message, stay: true});
                        if (!form.hasClass('no-reset')) {
                            form[0].reset(); // Limpa os campos do formulário
                        }
                    }
                }
            });
        })
        $('.loading').remove();
    });
}