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
                        </div>

                        <div class="row">
                            <div class="column large-6 medium-6 small-12">
                                <div class="input-group">
                                    <label for="Grupo">Grupo</label>
                                    <input type="text" name="Grupo" placeholder="Grupo" value="<?= $Agregado->getGrupo() ?>"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column large-4 medium-3 small-12">
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

                <button class="bottom btn-style" type="submit">Adicionar</button>
            </form>
        </div>
    </div>
</div>
