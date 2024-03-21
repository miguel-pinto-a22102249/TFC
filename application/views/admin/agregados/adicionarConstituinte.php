<div class="area-adicionar">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="/admin/agregados/adicionar" method="POST" class="form-ajax" enctype="multipart/form-data">
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="NissConstituintePrincipal">Niss</label>
                            <input type="text" name="NissConstituintePrincipal" placeholder="Niss"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="IdAgregado">Agregado</label>
                            <?
                            $agregados = (new Agregado_Familiar)->obtemElementos(null, ['Estado' => 1]);
                            if (count($agregados) > 0) { ?>

                                <select name="IdAgregado">
                                    <option value="">Selecione um agregado</option>
                                    <? foreach ($agregados as $agregado) {
                                        echo '<option value="' . $agregado->getId() . '">' . substr($agregado->getNissConstituintePrincipal(), 0, 3) . ' xxx xxx</option>';
                                    }
                                    ?>
                                </select>
                            <? } else {
                                echo 'Não existem agregados';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <div class="input-group">
                                <label for="IdEscalao">Escalão</label>
                                <?

                                $this->load->model('Escalao');
                                $escaloes = (new Escalao())->obtemElementos(null, ['Estado' => 1]);
                                if (count($escaloes) > 0) { ?>

                                    <select name="IdEscalao">
                                        <option value="">Selecione um Escalão</option>
                                        <? foreach ($escaloes as $escalao) {
                                            echo '<option value="' . $escalao->getId() . '">' . $escalao->getDesignacao() . '</option > ';
                                        }
                                        ?>
                                    </select>
                                <? } else {
                                    echo 'Não existem agregados';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="bottom btn-style" type="submit">Cria</button>
            </form>
        </div>
    </div>
</div>
