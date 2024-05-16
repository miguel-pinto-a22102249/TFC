<div class="area-editar">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="<?= base_url("/admin/produtos/editar/" . $Produto->getId()) ?>" method="POST" class="form-ajax no-reset" enctype="multipart/form-data">
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Nome">Nome</label>
                            <input type="text" name="Nome" placeholder="Nome" value="<?= $Produto->getNome() ?>"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Nome">Categoria</label>
                            <select name="Categoria">
                                <?
                                if ($Produto->getCategoria() == null || $Produto->getCategoria() == "") {
                                    echo "<option value='' selected>Selecione uma categoria</option>";
                                }

                                $categorias = explode(',',
                                    str_replace(["[", "]"], "", config_item("produtos.classificacao")));
                                foreach ($categorias as $categoria) {
                                    $codigo = explode(':', $categoria)[0];
                                    $nome = explode(':', $categoria)[1];
                                    $selected = $Produto->getCategoria() == $codigo ? 'selected' : '';
                                    echo "<option value='$codigo' $selected>$nome</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Detalhes">Detalhes</label>
                            <input type="text" name="Detalhes" placeholder="Detalhes" value="<?= $Produto->getDetalhes() ?>"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="StockAtual">Stock Atual</label>
                            <input type="number" step="1" name="StockAtual" placeholder="Stock Atual" value="<?= $Produto->getStockAtual() ?>"/>
                        </div>
                    </div>
                </div>
                <button class="bottom btn-style" type="submit">Gravar</button>
            </form>
        </div>
    </div>
</div>
