<div class="area-adicionar form-mask">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="<?php echo base_url('admin/agregados/importacao'); ?>" method="post" enctype="multipart/form-data" class="no-reset form-agregados-importacao">
                <div class="form-group">
                    <label for="ficheiro">Ficheiro</label>
                    <input type="file" name="ficheiro" id="ficheiro" class="form-control" required>
                </div>
                <button class="bottom btn-style margin-top-20" type="submit">Importar</button>
            </form>
        </div>
    </div>
    <div class="resultado"></div>
</div>

<script>
     $(".form-agregados-importacao").submit(function(e) {
         e.preventDefault(); // Impede o envio padrão do formulário

         var form = $(this);
         var formData = new FormData(form[0]);

         if ($('.form-mask').length > 0) {
             $('.form-mask').addClass('is-active');
             $('.form-mask').append('<div class="loading"></div>');
         }else{
             $(this).addClass('is-active');
             $(this).append('<div class="loading"></div>');
         }

         var form =

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
                     $('.resultado').html(response.view);


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

                     notie.alert({type: 1, text: response.message, stay: true});
                     if (!form.hasClass('no-reset')) {
                         form[0].reset(); // Limpa os campos do formulário
                     }
                 }
             }
         });
     });
</script>
