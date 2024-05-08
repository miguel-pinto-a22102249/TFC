<div id="Area-Editar">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="<?= base_url("/admin/agregados/constituintes/editar/" . $Constituinte->getId()) ?>" method="POST" class="form-ajax no-reset" enctype="multipart/form-data">
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Niss">Niss</label>
                            <input type="text" name="Niss" placeholder="Niss" value="<?= $Constituinte->getNiss() ?>"/>
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
                                        if ($agregado->getId() == $Constituinte->getIdAgregado()) {
                                            $attr = 'selected';
                                        } else {
                                            $attr = '';
                                        }

                                        if ($this->session->userdata('ModoPrivacidade') == false) {
                                            echo '<option ' . $attr . ' value="' . $agregado->getId() . '">xxx xxx ' . substr($agregado->getNissConstituintePrincipal(), 6, 9) . '</option>';
                                        } else {
                                            echo '<option ' . $attr . ' value="' . $agregado->getId() . '">' . $agregado->getNissConstituintePrincipal() . '</option>';
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
                                            if ($escalao->getId() == $Constituinte->getIdEscalao()) {
                                                $attr = 'selected';
                                            } else {
                                                $attr = '';
                                            }

                                            echo '<option ' . $attr . ' value="' . $escalao->getId() . '">' . $escalao->getDesignacao() . '</option > ';
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
                <button class="bottom btn-style" type="submit">Editar</button>
            </form>
        </div>
    </div>
</div>
