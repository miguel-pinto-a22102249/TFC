<div class="area-adicionar">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="<?= base_url("/admin/produtos/adicionar") ?>" method="POST" class="form-ajax" enctype="multipart/form-data">
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Nome">Nome</label>
                            <input type="text" id="Nome" name="Nome" placeholder="Nome"/>
                        </div>
                    </div>
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="IdEntidadeDistribuidora">Entidade Distribuidora</label>
                            <?

                            $this->load->model('Entidade_Distribuidora');
                            $EntidadesDistribuidoras = (new Entidade_Distribuidora())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);
                            ?>

                            <select name="IdEntidadeDistribuidora">
                                <option value="">Selecione uma entidade distribuidora</option>
                                <?
                                foreach ($EntidadesDistribuidoras as $EntidadeDistribuidora) {
                                    echo "<option value='{$EntidadeDistribuidora->getId()}'>{$EntidadeDistribuidora->getNome()}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Nome">Categoria</label>
                            <select name="Categoria">
                                <option value="">Selecione uma categoria</option>
                                <?
                                $categorias = explode(',',
                                    str_replace(["[", "]"], "", config_item("produtos_classificacao")));
                                foreach ($categorias as $categoria) {
                                    $codigo = explode(':', $categoria)[0];
                                    $nome = explode(':', $categoria)[1];
                                    echo "<option value='$codigo'>$nome</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="StockAtual">Stock Atual</label>
                            <input type="number" step="1" id="StockAtual" name="StockAtual" placeholder="Stock Atual"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Detalhes">Detalhes</label>
                            <textarea type="text" id="Detalhes" name="Detalhes" rows="3" placeholder="Detalhes"></textarea>
                        </div>
                    </div>
                </div>


                <button class="bottom btn-style" type="submit">Adicionar</button>
            </form>
        </div>
    </div>
</div>
