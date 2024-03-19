<div id="Area-Editar">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="/admin/agregados/editar/<?= $Agregado->getId() ?>" method="POST" class="form-ajax" enctype="multipart/form-data">
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Designacao">Designação</label>
                            <input type="text" name="Designacao" placeholder="Designação" value="<?= $Agregado->getDesignacao() ?>"/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="IdadeInicial">Idade Inícial</label>
                            <input type="number" step="1" name="IdadeInicial" placeholder="Idade Inícial" value="<?= $Agregado->getIdadeInicial() ?>"/>
                        </div>
                    </div>
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="IdadeFinal">Idade Final</label>
                            <input type="number" step="1" name="IdadeFinal" placeholder="Idade Final" value="<?= $Agregado->getIdadeFinal() ?>"/>
                        </div>
                    </div>
                </div>
                <button class="bottom btn-style" type="submit">Gravar</button>
            </form>
        </div>
    </div>
</div>
