<div id="Area-Novo-Utilizador">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="<?= base_url('/admin/escaloes/adicionar') ?>" method="POST" class="form-ajax" enctype="multipart/form-data">
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Designacao">Designação</label>
                            <input type="text" name="Designacao" placeholder="Designação"/>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="IdadeInicial">Idade Inícial</label>
                            <input type="number" step="1" name="IdadeInicial" placeholder="Idade Inícial"/>
                        </div>
                    </div>
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="IdadeFinal">Idade Final</label>
                            <input type="number" step="1" name="IdadeFinal" placeholder="Idade Final"/>
                        </div>
                    </div>
                </div>
                <button class="bottom btn-style" type="submit">Cria</button>
            </form>
        </div>
    </div>
</div>
