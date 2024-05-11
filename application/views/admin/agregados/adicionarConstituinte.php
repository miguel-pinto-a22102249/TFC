<div class="area-adicionar">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="/admin/agregados/constituintes/adicionar" method="POST" class="form-ajax" enctype="multipart/form-data">
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Niss">Niss</label>
                            <input type="text" name="Niss" placeholder="Niss"/>
                        </div>
                    </div>
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="DataNascimento">DataNascimento</label>
                            <input type="date" name="DataNascimento" placeholder=""/>
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
                                        if ($this->session->userdata('ModoPrivacidade') == false) {
                                            echo '<option value="' . $agregado->getId() . '">xxx xxx ' . substr($agregado->getNissConstituintePrincipal(), 6, 9) . '</option>';
                                        } else {
                                            echo '<option value="' . $agregado->getId() . '">' . $agregado->getNissConstituintePrincipal() . '</option>';
                                        }
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
                <button class="bottom btn-style" type="submit">Adicionar</button>
            </form>
        </div>
    </div>
</div>
