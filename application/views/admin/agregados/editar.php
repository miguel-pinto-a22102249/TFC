<div id="Area-Editar">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="<?= base_url("/admin/agregados/editar/" . $Agregado->getId()) ?>" method="POST" class="form-ajax no-reset" enctype="multipart/form-data">
                <div class="row">
                    <div class="column large-8 medium-9 small-12">
                        <div class="row">
                            <div class="column large-6 medium-6 small-12">
                                <div class="input-group">
                                    <label for="NissConstituintePrincipal">Niss Constituinte Principal</label>
                                    <input type="text" name="NissConstituintePrincipal" readonly placeholder="NissConstituintePrincipal" value="<?= $Agregado->getNissConstituintePrincipal() ?>"/>
                                </div>
                            </div>

                            <div class="column large-6 medium-6 small-12">
                                Constituintes do Agregado
                                <ul>
                                    <?

                                    $constituintes = (new Constituinte)->obtemElementos(null, ['IdAgregado' => $Agregado->getId()], null, false);
                                    if (count($constituintes) > 0) {
                                    foreach ($constituintes

                                             as $constituinte) {
                                        ?>
                                        <li>
                                            <a class="btn-consultar-popup-ajax" style="text-decoration:none" href="<?= base_url() . 'admin/agregados/constituintes/consultarConstituinte/' . $constituinte->getId() ?>">
                                                <i class="fas fa-search-plus fa-1x"></i> <?= $constituinte->getNiss(); ?>
                                            </a>
                                        </li>
                                    <?
                                    }
                                    ?>
                                        <script>
                                    triggerPopupAjaxConsultaEdicao();
                                </script>
                                        <?
                                    }
                                    ?>
                                </ul>
                            </div>

                        </div>
                        <div class="row">
                            <div class="column large-10 medium-12 small-12">
                                <div class="input-group">
                                    <label for="Morada">Niss Constituinte Principal</label>
                                    <input type="text" name="Morada" placeholder="Morada" value="<?= $Agregado->getMorada() ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="column large-6 medium-6 small-12">
                                <div class="input-group">
                                    <label for="IdsEntidadesDistribuidoras">Entidades Distribuidoras</label>
                                    <?
                                    $this->load->model('Entidade_Distribuidora');
                                    $EntidadesDistribuidoras = (new Entidade_Distribuidora())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);

                                    // Obtenha os IDs das entidades distribuidoras do banco de dados
                                    $selectedIds = json_decode($Agregado->getIdsEntidadesDistribuidoras());
                                    ?>

                                    <select name="IdsEntidadesDistribuidoras[]" id="IdsEntidadesDistribuidoras" multiple>
                                        <?
                                        foreach ($EntidadesDistribuidoras as $EntidadeDistribuidora) {
                                            $id = $EntidadeDistribuidora->getId();
                                            $selected = in_array($id, $selectedIds) ? 'selected' : '';
                                            echo "<option value='{$id}' {$selected}>{$EntidadeDistribuidora->getNome()}</option>";
                                        }
                                        ?>
                                    </select>
                                    <a href="javascript:;" onclick="selecionarTodos()" style="margin-top: -5px;display: block;"><small><u>Selecionar Todos</u></small></a>
                                </div>
                            </div>

                            <div class="column large-6 medium-6 small-12">
                                <div class="input-group">
                                    <label for="Grupo">Grupo</label>
                                    <input type="text" name="Grupo" placeholder="Grupo" value="<?= $Agregado->getGrupo() ?>"/>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <button class="bottom btn-style" type="submit">Editar</button>
            </form>
        </div>
    </div>
</div>
<script>
function selecionarTodos() {
    var select = document.getElementById("IdsEntidadesDistribuidoras");
    for (var i = 0; i < select.options.length; i++) {
        select.options[i].selected = true;
    }
}
</script>