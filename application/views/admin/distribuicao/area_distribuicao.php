<script src="<?= base_url() . '/ficheiros/js/admin/distribuicao.js' . "?" . config_item('gestao.assets_version'); ?>"></script>

<?
/** @var Agregado_Familiar $agregado */

$this->load->model('Entidade_Distribuidora');
?>
<div class="Area-Disctribuicao">
    <div class="Area-Disctribuicao-passo-1">
        <div class="row">
            <div class="column large-12 medium-12 small-12 form-login-wrapper">
                <form action="<?= base_url("/admin/distribuicoes/distribuicaoPasso2") ?>" method="POST" class="no-ajax form-distribuicao" enctype="multipart/form-data">

                    <div class="row">
                        <div class="column large-4 medium-12 small-12 margin-bottom-15">
                            <label>Variável de Distribuição: <?= explode(',', substr(config_item('distribuicao_variavel'), 1, -1))[0];?></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="column large-4 medium-12 small-12">
                            <div class="input-group">
                                <label for="TipoDistribuicao">Tipo de Distribuição</label>
                                <select name="TipoDistribuicao">
                                    <option value="1" data-mensagem-alerta="Esta opção irá fazer a distribuição tentando preencher os totais mesmo que implique que alguns constituintes recebam 0.">Distribuição por Totais</option>
                                    <option value="2" data-mensagem-alerta="Esta opção irá dividir os produtos de forma mais uniforme possível.">Distribuição Equitativa
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="column large-4 medium-12 small-12">
                            <div class="input-group">
                                <label for="EsgotarStock">Esgotar Stock?</label>
                                <select name="EsgotarStock">
                                    <option value="1" selected>Sim</option>
                                    <option value="0">Não
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="column large-4 medium-12 small-12">
                            <div class="input-group">
                                <label for="IdEntidadeDistribuidora">Entidade Distribuidora</label>
                                <?
                                $this->load->model('Entidade_Distribuidora');
                                $EnstidadesDistribuidoras = (new Entidade_Distribuidora())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);
                                ?>
                                <select name="IdEntidadeDistribuidora">
                                    <option value="">Selecione uma entidade distribuidora</option>
                                    <? foreach ($EnstidadesDistribuidoras as $EntidadeDistribuidora) { ?>
                                        <option value="<?= $EntidadeDistribuidora->getId() ?>"><?= $EntidadeDistribuidora->getNome() ?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="column large-12 medium-12 small-12 form-login-wrapper">
                            <table>
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Niss Constituinte Principal</th>
                                    <th>Grupo</th>
                                    <th>Entidade Distribuidora</th>
                                </tr>
                                <tr>
                                    <th><input disabled type="checkbox" id="selecionarTodos"></th>
                                    <th colspan="3"><label for="selecionarTodos">Selecionar todos</label></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($Agregados as $agregado) {
                                    //Se não tiver entidades distribuidoras, não mostra
                                    if ($agregado->getIdsEntidadesDistribuidoras() == null) {
                                        continue;
                                    }


                                    $IdsEntidadesDistribuidoras = "";
                                    if ($agregado->getIdsEntidadesDistribuidoras() != null) {
                                        $IdsEntidadesDistribuidoras = json_decode($agregado->getIdsEntidadesDistribuidoras());
                                        if (is_array($IdsEntidadesDistribuidoras)) {
                                            $IdsEntidadesDistribuidoras = implode(',', $IdsEntidadesDistribuidoras);
                                        }
                                    }
                                    ?>
                                    <tr data-entidades-distribuidoras="<?= $IdsEntidadesDistribuidoras ?>">
                                        <td>
                                            <input disabled type="checkbox" name="agregados[]" id="<?= $agregado->getId() ?>" value="<?= $agregado->getId() ?>">
                                        </td>
                                        <td>
                                            <label for="<?= $agregado->getId() ?>">
                                                <? if ($this->session->userdata('ModoPrivacidade') == false) { ?>
                                                    xxx xxx <?= substr($agregado->getNissConstituintePrincipal(), 6, 9); ?>
                                                    <?
                                                } else {
                                                    echo $agregado->getNissConstituintePrincipal();
                                                } ?>
                                            </label>
                                        </td>
                                        <td><?= $agregado->getGrupo() ? $agregado->getGrupo() : "-"?></td>
                                        <td>
                                            <label for="<?= $agregado->getId() ?>">
                                                <?
                                                $IdsEntidadesDistribuidoras = json_decode($agregado->getIdsEntidadesDistribuidoras());
                                                if ($IdsEntidadesDistribuidoras != null) {
                                                    $EntidadesDistribuidoras = (new Entidade_Distribuidora())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);

                                                    if (is_array($IdsEntidadesDistribuidoras)) {
                                                        $entidades = '';
                                                        foreach ($EntidadesDistribuidoras as $EntidadeDistribuidora) {
                                                            if (in_array($EntidadeDistribuidora->getId(), $IdsEntidadesDistribuidoras)) {
                                                                $entidades .= $EntidadeDistribuidora->getNome() . ', ';
                                                            }
                                                        }
                                                        echo substr($entidades, 0, -2);
                                                    } else {
                                                        echo $EntidadesDistribuidoras[$IdsEntidadesDistribuidoras]->getNome();
                                                    }
                                                }
                                                ?>
                                            </label>
                                        </td>
                                    </tr>

                                <? } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>


                    <button class="bottom btn-style" type="submit">Adicionar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // JavaScript para selecionar/desselecionar todos os checkboxes
    var selecionarTodosCheckbox = document.getElementById('selecionarTodos');
    selecionarTodosCheckbox.addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('input[name="agregados[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = selecionarTodosCheckbox.checked;
        });
    });

    // JavaScript para mostrar alerta quando a opção de distribuição equitativa for selecionada
    function showAlertForSelectedOption() {
        var selectedOption = $('select[name="TipoDistribuicao"]').find('option:selected');
        var alertMessage = selectedOption.data('mensagem-alerta');

        // Remove qualquer alerta existente antes de adicionar um novo
        $('small.alert').remove();

        // Adiciona o alerta abaixo do select
        if (alertMessage) {
            $('select[name="TipoDistribuicao"]').after('<small class="alert label--error" style="margin-top:8px;display: inline-block;">' + alertMessage + '</small>');
        }
    }

    // Executa a função quando a página carrega
    showAlertForSelectedOption();

    // Adiciona o evento de mudança para o select
    $('select[name="TipoDistribuicao"]').on('change', function() {
        showAlertForSelectedOption();
    });

    // Deselecionar e esconder as linhas da tabela que não tenham no data o id da entidade distribuidora selecionada
    $('select[name="IdEntidadeDistribuidora"]').on('change', function() {
        $('input[type="checkbox"]').prop('checked', false);
        var idEntidadeDistribuidora = $(this).val();
        $('table tbody tr').each(function() {
            var entidadesDistribuidoras = $(this).data('entidades-distribuidoras').toString();

            if (entidadesDistribuidoras.includes(idEntidadeDistribuidora)) {
                $(this).show();
                $('#selecionarTodos').prop('disabled', false);
                $(this).find('input').prop('disabled', false);
            } else {
                $(this).find('input[type="checkbox"]').prop('checked', false);
                $(this).find('input').prop('disabled', true);
                $(this).hide();
            }

        });
    });

</script>

