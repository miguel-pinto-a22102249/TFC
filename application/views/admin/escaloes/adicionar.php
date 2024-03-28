<div id="Area-Adicionar">

    <?
    $this->load->model('Produto');
    $produtos = (new Produto())->obtemElementos(['Estado' => 1]);

    ?>

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


                <!-- Campo para produtos e quantidades -->
                <div class="row">
                    <div class="column large-12">
                        <div class="input-group input-group--produtos-quantidades">
                            <label>Produtos e Quantidades</label>
                            <!-- Você pode adicionar campos de entrada para cada produto e sua quantidade -->
                            <div class="product-inputs">
                                <div>
                                    <select name="produtos[]">
                                        <? foreach ($produtos as $produto) { ?>
                                            <option value="<?= $produto->getId() ?>"><?= $produto->getNome() ?></option>
                                        <? } ?>
                                    </select>
                                    <input type="number" name="quantidades[]" placeholder="Quantidade">
                                </div>
                            </div>
                            <button type="button" class="add-product btn-style">Adicionar Produto</button>
                        </div>
                    </div>
                </div>


                <button class="bottom btn-style" type="submit">Adicionar</button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Adiciona campos de entrada para produto e quantidade
        $('.add-product').click(function() {
            var newProductInput = '<div><select name="produtos[]"><?php foreach ($produtos as $produto): ?><option value="<?= $produto->getId() ?>"><?= $produto->getNome() ?></option><?php endforeach; ?></select><input type="number" name="quantidades[]" placeholder="Quantidade"><button type="button" class="remove-product btn-style">Remover</button></div>';
            $('.product-inputs').append(newProductInput);
        });

        // Remove campos de entrada para produto e quantidade
        $(document).on('click', '.remove-product', function() {
            $(this).parent('div').remove();
        });
    });
</script>
