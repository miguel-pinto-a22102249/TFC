$(document).foundation()
$(document).ready(function() {


//POP UP RESET PASSWORD ADMIN
    $('.open-popup-reset-password').on('click', function() {
        $('#popup-reset-password').css("display", "block");
    });
    $('.open-popup-reset-password').magnificPopup({
        type: 'inline',
        removalDelay: 900,
        midClick: true, // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
        callbacks: {
            beforeOpen: function() {
                this.st.mainClass = this.st.el.attr('data-effect');
            }
        },
    });

    tinymce.init({
        selector: '.textareaMCE',
        plugin: 'a_tinymce_plugin',
        a_plugin_option: true,
        a_configuration_option: 400
    });

    // Submete pedido de reset de password por AJAX
    $("#btn-reset-password").click(function(event) {

        $("#loading-wrapper").css("display", "block");
        event.preventDefault();
        var username = $("#UsernameResetPassword").val();
        var action = $("#Form-reset-password").attr('action');
        $.ajax({
                type: "post",
                url: action,
                data: {
                    username: username
                },
                success: function(data) {
                    var obj = jQuery.parseJSON(data);
                    //Se existir algum erro
                    if (obj.Sucesso == false) {
                        $("#loading-wrapper").css("display", "none");
                        $(".popup-wrapper").html(obj.Mensagem);
                    } else
                        //Se for enviado sem problemas
                    if (obj.Sucesso == true) {
                        $("#loading-wrapper").css("display", "none");
                        //guardar o html antes de ser substituido por a mensagem de erro
                        var htmlForm = $(".popup-wrapper").html();
                        $(".popup-wrapper").html(obj.Mensagem);
                        setTimeout(function() {
                            var magnificPopup = $.magnificPopup.instance; // save instance in magnificPopup variable
                            magnificPopup.close(); // Close popup that is currently opened
                        }, 3000);
                    }


                },
                error: function(data) {
                    var obj = jQuery.parseJSON(data);
                    $("#loading-wrapper").css("display", "none");
                    $(".popup-wrapper").html(obj.Mensagem);
                }
            }
        );
    });

    // Para remover a div de loading
    setTimeout(function() {
        $(".loading").fadeOut(300, function() {
            $(this).remove();
        });
    }, 700);

    // <editor-fold defaultstate="collapsed" desc="Eliminar - Notie Genérica">
    $('.confirma-accao').off("click.confirma");
    $('.confirma-accao').on("click.confirma", function(eve) {

        if ($(this).data("mensagem-accao") === undefined) {
            msg = "Tem a certeza que deseja efetuar esta ação?";
        } else {
            msg = $(this).data("mensagem-accao");
        }

        var url = $(this).attr('href');
        eve.preventDefault();

        notie.confirm({
            text: msg,
            submitText: 'Sim',
            cancelText: 'Não'
        }, function() {
            $.ajax({//request ajax
                url: url,
                dataType: "json",
                success: function(response) {
                    if (response.Sucesso == true) {
                        if (response.Mensagem == "") {
                            response.Mensagem = "Ação efetuada com sucesso";
                        }
                        notie.alert({type: 1, text: response.Mensagem})
                    } else {
                        notie.alert({type: 3, text: response.Mensagem})
                    }
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                error: function() {
                    notie.alert({type: 3, text: "Erro", stay: true})
                }
            });
        })

    });
    // </editor-fold>

    $('.trigger-modo-privacidade').off("click.confirma");
    $('.trigger-modo-privacidade').on("click.confirma", function(eve) {
        eve.preventDefault();
        eve.stopPropagation();
        eve.preventDefault();
        if ($(this).data("mensagem-accao") === undefined) {
            msg = "Tem a certeza que deseja efetuar esta ação?";
        } else {
            msg = $(this).data("mensagem-accao");
        }

        var $botao = $(this);


        notie.confirm({
            text: msg,
            submitText: 'Sim',
            cancelText: 'Não'
        }, function() {
            var url = $botao.attr('href');


            if ($botao.hasClass('trigger-modo-privacidade--lock')) {
                $botao.removeClass('trigger-modo-privacidade--lock');
                $botao.addClass("trigger-modo-privacidade--unlock");
            } else {
                $botao.removeClass('trigger-modo-privacidade--unlock');
                $botao.addClass("trigger-modo-privacidade--lock");
            }


            var hrefAtual = $botao.attr('href'); // Obtém o valor atual do href.

            //Vamos verificar se o href contém a string "ativaModoPrivacidade"
            if (hrefAtual.includes('ativaModoPrivacidade')) {
                var novoHref = hrefAtual.replace('ativaModoPrivacidade', 'desativaModoPrivacidade');
                $(this).attr('href', novoHref); // Define o novo valor do href.
            } else if (hrefAtual.includes('desativaModoPrivacidade')) {
                var novoHref = hrefAtual.replace('desativaModoPrivacidade', 'ativaModoPrivacidade');
                $(this).attr('href', novoHref); // Define o novo valor do href.
            }

            $.ajax({//request ajax
                url: url,
                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        if (response.message == "") {
                            response.message = "Ação efetuada com sucesso";
                        }
                        notie.alert({type: 1, text: response.message})
                    } else {
                        notie.alert({type: 3, text: response.message})
                    }
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                error: function() {
                    notie.alert({type: 3, text: "Erro", stay: true})
                }
            });
        })

    });


    // <editor-fold defaultstate="collapsed" desc="DATA TABLE ">
    $('.dataTable').DataTable({
        "order": [[$('th.defaultSort').index(), 'desc']],
        "pagin": true,
        "responsive": true,
        "pagingType": "full_numbers",
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
        },
    });
    $("div.toolbar").html('<b>Custom tool bar! Text/images etc.</b>');
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Backup BD">

    $('#backup-bd').on("click", function(eve) {
        eve.preventDefault();
        notie.confirm({
            text: 'Tem acerteza que quer efetuar um Backup da BD',
            submitText: 'Sim',
            cancelText: 'Não'
        }, function() {
            $.ajax({//request ajax
                url: $('#backup-bd').attr('href'),
                dataType: "json",
                success: function(response) {
                    if (response.Sucesso == true) {
                        notie.alert({type: 1, text: response.Mensagem})
                    } else {
                        notie.alert({type: 3, text: response.Mensagem})
                    }
                },
                error: function() {
                    notie.alert({type: 3, text: "Erro", stay: true})
                }
            });
        })

    });
    // </editor-fold>

    $('.select-multiple').select2();


    // <editor-fold defaultstate="collapsed" desc="Código para submissão de formulários via AJAX">
    $(".form-ajax").submit(function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário

        if ($('.form-mask').length > 0) {
            $('.form-mask').addClass('is-active');
            $('.form-mask').append('<div class="loading"></div>');
        } else {
            $(this).addClass('is-active');
            $(this).append('<div class="loading"></div>');
        }

        var form = $(this);
        var formData = new FormData(form[0]);

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
                    notie.alert({type: 1, text: response.message, stay: true});
                    if (!form.hasClass('no-reset')) {
                        form[0].reset(); // Limpa os campos do formulário
                    }
                }
            }
        });
    });
    // </editor-fold>

})
;

