<div id="Area-Novo-Utilizador">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="<?= base_url("/admin/escaloes/editar/" . $Escalao->getId()) ?>" method="POST" class="form-ajax" enctype="multipart/form-data">
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Designacao">Designação</label>
                            <input type="text" name="Designacao" placeholder="Designação" value="<?= $Escalao->getDesignacao() ?>"/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="IdadeInicial">Idade Inícial</label>
                            <input type="number" step="1" name="IdadeInicial" placeholder="Idade Inícial" value="<?= $Escalao->getIdadeInicial() ?>"/>
                        </div>
                    </div>
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="IdadeFinal">Idade Final</label>
                            <input type="number" step="1" name="IdadeFinal" placeholder="Idade Final" value="<?= $Escalao->getIdadeFinal() ?>"/>
                        </div>
                    </div>
                </div>
                <button class="bottom btn-style" type="submit">Gravar</button>
            </form>
        </div>
    </div>
</div>
