<div id="Area-Novo-Utilizador">

    <?
    $this->load->model('Produto');
    $produtos = (new Produto())->obtemElementos(['Estado' => 1]);

    ?>

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


                <div class="row">
                    <div class="column large-12">
                        <div class="input-group input-group--produtos-quantidades">
                            <label>Produtos e Quantidades</label>
                            <!-- Você pode adicionar campos de entrada para cada produto e sua quantidade -->
                            <div class="product-inputs">
                                <? if (!is_null($Escalao->getProdutos())) { ?>
                                    <?
                                    // Decodifica o JSON de produtos e quantidades do objeto Escalao
                                    $produtos_quantidades = json_decode($Escalao->getProdutos(), true);
                                    foreach ($produtos_quantidades as $produto_id => $quantidade) { ?>
                                        <div>
                                            <select name="produtos[]">
                                                <?php foreach ($produtos as $produto): ?>
                                                    <option value="<?= $produto->getId() ?>" <?= ($produto->getId() == $produto_id) ? 'selected' : '' ?>><?= $produto->getNome() ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <input type="number" name="quantidades[]" value="<?= $quantidade ?>" placeholder="Quantidade">
                                            <button type="button" class="remove-product btn-style">Remover</button>
                                        </div>
                                    <? } ?>
                                <? } ?>
                            </div>
                            <button type="button" class="add-product btn-style">Adicionar Produto</button>
                        </div>
                    </div>
                </div>

                <button class="bottom btn-style" type="submit">Gravar</button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Adiciona campos de entrada para produto e quantidade
        $('.add-product').click(function() {
            var newProductInput = '<div><select name="produtos[]"><?php foreach ($produtos as $produto): ?><option value="<?= $produto->getId() ?>"><?= $produto->getNome() ?></option><?php endforeach; ?></select><input type="number" name="quantidades[]" placeholder="Quantidade"><button type="button" class="btn-style remove-product">Remover</button></div>';
            $('.product-inputs').append(newProductInput);
        });

        // Remove campos de entrada para produto e quantidade
        $(document).on('click', '.remove-product', function() {
            $(this).parent('div').remove();
        });
    });
</script>

