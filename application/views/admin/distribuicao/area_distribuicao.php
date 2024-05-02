<script src="<?= base_url() . '/ficheiros/js/admin/distribuicao.js' . "?" . CACHE ?>"></script>

<?
/** @var Agregado_Familiar $agregado */
?>
<div class="Area-Disctribuicao">
    <div class="Area-Disctribuicao-passo-1">
        <div class="row">
            <div class="column large-8 medium-10 small-12 form-login-wrapper">
                <form action="<?= base_url("/admin/distribuicoes/distribuicaoPasso2") ?>" method="POST" class="no-ajax form-distribuicao" enctype="multipart/form-data">

                    <table>
                        <thead>
                        <tr>
                            <th></th>
                            <th>Niss Constituinte Principal</th>
                        </tr>
                        <tr>
                            <th colspan="2"><label><input type="checkbox" id="selecionarTodos"> Selecionar todos</label></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($Agregados as $agregado) { ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="agregados[]" id="<?= $agregado->getId() ?>" value="<?= $agregado->getId() ?>">
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
                            </tr>

                        <? } ?>
                        </tbody>
                    </table>

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
        console.log('changed');
        var checkboxes = document.querySelectorAll('input[name="agregados[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = selecionarTodosCheckbox.checked;
        });
    });
</script>

