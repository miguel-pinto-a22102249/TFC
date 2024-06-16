<div id="Area-Adicionar">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="<?= base_url('/admin/entidadesDistribuidoras/adicionar') ?>" method="POST" class="form-ajax" enctype="multipart/form-data">
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Nome">Nome</label>
                            <input type="text" name="Nome" placeholder="Nome"/>
                        </div>
                    </div>
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="NIF">Nif</label>
                            <input type="text" step="1" name="NIF" id="NIF" placeholder="NIF"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="column large-10 medium-8 small-12">
                        <div class="input-group">
                            <label for="NomeCompleto">Nome Completo da Entidade</label>
                            <input type="text" name="NomeCompleto" placeholder="Nome utilizado para emissão de Credenciais"/>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="column large-10 medium-8 small-12">
                        <div class="input-group">
                            <label for="Morada">Morada</label>
                            <input type="text" step="1" name="Morada" id="Morada" placeholder="Morada"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column large-10 medium-8 small-12">
                        <div class="input-group">
                            <label for="TipoOperacao">Tipo de Operação</label>
                            <input type="text" name="TipoOperacao" value="Distribuição de Géneros Alimentares e/ou Bens de Primeira Necessidade - Continente"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column large-12 medium-12 small-12 input-group">
                        <div class="input-group">
                            <label for="Logo">Logo</label>
                            <input type="file" id="Logo" name="Logo" class="show-for-sr">
                        </div>
                    </div>
                </div>

                <button class="bottom btn-style" type="submit">Adicionar</button>
            </form>
        </div>
    </div>
</div>

