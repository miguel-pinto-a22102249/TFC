<?
$coresSofts = [
    '#E2E8F0', '#EEDEE5', '#EDF2F7', '#DFDEEE', '#EBF8FF', '#DFEEDE', '#F0F0F0', '#FAF5FF', '#FFF5F7', '#FFF7E6'
]; ?>

<div class="area-importacao margin-top-40 area-listagem form-mask">
    <div class="row">
        <? if (count($agregados) > 0) { ?>
            <div class="column large-12 medium-10 small-12">
                <table class="dataTable display responsive">
                    <thead>
                    <tr style="height: 40px">
                        <th class="defaultSort">Importar</th>
                        <th class="defaultSort">NISS Agregado</th>
                        <th class="text-center">NISS</th>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Idade</th>
                        <th class="text-center">Escalão</th>
                        <th class="text-center">Data Nasc</th>
                        <th class="text-center">Erros</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    $count = 0;
                    foreach ($agregados as $IdAgregado => $constituinte_temp) { ?>
                        <? foreach ($constituinte_temp as $constituinte) { ?>
                            <tr class="" style="background-color:<?= $coresSofts[$count] ?>; height: 40px">
                                <td style="background-color:<?= $coresSofts[$count] ?>">
                                    <? if ($constituinte->Importar) { ?>
                                        <label class="success">Sim</label>
                                        <?
                                    } else { ?>
                                        <label class="error">Não</label>
                                        <?
                                    } ?>
                                </td>
                                <td style="background-color:<?= $coresSofts[$count] ?>"><?php echo $IdAgregado ?></td>
                                <td class="text-center">
                                    <?= $constituinte->getNiss(); ?>
                                </td>
                                <td class="text-center">
                                    <?= $constituinte->getNome(); ?>
                                </td>
                                <td class="text-center">
                                    <?= $constituinte->Idade; ?>
                                </td>
                                <td class="text-center">
                                    <?
                                    $designacaoEscalao = $constituinte->getDesignacaoEscalao();
                                    if ($designacaoEscalao == "" || $designacaoEscalao == null || $designacaoEscalao == false || $designacaoEscalao == "-") {
                                        echo "<span class='label--error'>Não definido</span>";
                                    } else {
                                        echo $designacaoEscalao;
                                    } ?>

                                </td>
                                <td class="text-center">
                                    <?= $constituinte->getDataNascimento(); ?>
                                </td>
                                <td class="text-center">
                                    <? foreach ($constituinte->Erros as $erro) { ?>
                                        <div class="small"><?= $erro; ?></div>
                                        <?
                                    }; ?>
                                </td>
                            </tr>
                        <? }
                        $count++;
                        if ($count >= 10) {
                            $count = 0;
                        }
                    } ?>
                    </tbody>
                </table>
                <center><p>Todas a linhas com erros, não serão importadas.</p></center>
            </div>
        <? } ?>
    </div>
    <div class="row area-importacao__footer">
        <div class="column large-12 medium-10 small-12">
            <div class="area-importacao__footer__wrapper">
                <a class="button" href="<?= base_url('admin/agregados/importacao'); ?>">Nova Importação</a>
                <a class="button button--success" href="">Confirmar Importação</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Capturar o clique no botão "Confirmar Importação"
    $('.button--success').click(function(e) {
        e.preventDefault(); // Evitar comportamento padrão do botão

        if ($('.form-mask').length > 0) {
            $('.form-mask').addClass('is-active');
            $('.form-mask').append('<div class="loading"></div>');
        } else {
            $(this).addClass('is-active');
            $(this).append('<div class="loading"></div>');
        }

        var agregados = <?php echo json_encode($agregados); ?>;
        // Enviar os dados via AJAX para o controlador PHP
        $.ajax({
            url: '<?php echo base_url('admin/agregados/guardarImportacao'); ?>',
            type: 'POST',
            data: {dados: JSON.stringify(agregados)}, // Envie os dados como JSON
            success: function(response) {

                $('.is-active').removeClass('is-active');
                $('.loading').remove();

                if (response.success === false) {
                    let errors = response.errors;
                    notie.alert({type: 1, text: response.message, stay: true});
                    if (!form.hasClass('no-reset')) {
                        form[0].reset(); // Limpa os campos do formulário
                    }
                } else {
                    // console.log(response);
                    $('.resultado').html(response.view);


                    notie.alert({type: 1, text: response.message, stay: true});
                    if (!form.hasClass('no-reset')) {
                        form[0].reset(); // Limpa os campos do formulário
                    }
                }
            }
        });
    });
});
</script>


