<div class="area-adicionar">
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

         $.ajax({
             type: form.attr('method'),
             url: form.attr('action'),
             data: formData,
             processData: false,
             contentType: false,
             success: function(response) {
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
                     console.log(response);
                     $('.resultado').html(response.view);
                     notie.alert({type: 1, text: response.message, stay: true});
                     if (!form.hasClass('no-reset')) {
                         form[0].reset(); // Limpa os campos do formulário
                     }
                 }
             }
         });
     });
</script>
