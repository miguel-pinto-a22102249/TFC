<div class="area-adicionar">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="<?= base_url("/admin/agregados/adicionar") ?>" method="POST" class="form-ajax" enctype="multipart / form-data">
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="NissConstituintePrincipal">Niss Constituinte Principal</label>
                            <input type="text" name="NissConstituintePrincipal" placeholder="NissConstituintePrincipal"/>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="IdsEntidadesDistribuidoras">Selecione as Entidades Distribuidoras</label>
                            <?

                            $this->load->model('Entidade_Distribuidora');
                            $EntidadesDistribuidoras = (new Entidade_Distribuidora())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);
                            ?>

                            <select name="IdsEntidadesDistribuidoras" id="IdsEntidadesDistribuidoras" multiple>
                                <?
                                foreach ($EntidadesDistribuidoras as $EntidadeDistribuidora) {
                                    echo "<option value='{$EntidadeDistribuidora->getId()}'>{$EntidadeDistribuidora->getNome()}</option>";
                                }
                                ?>
                            </select>
                            <a href="javascript:;" onclick="selecionarTodos()" style="margin-top: -5px;display: block;"><small><u>Selecionar Todos</u></small></a>
                        </div>
                    </div>
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Grupo">Grupo</label>
                            <input type="text" name="Grupo" placeholder="Grupo"/>
                        </div>
                    </div>
                </div>
                <button class="bottom btn-style" type="submit">Adicionar</button>
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