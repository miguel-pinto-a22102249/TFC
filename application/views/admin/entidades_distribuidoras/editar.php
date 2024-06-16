<div id="Area-Adicionar">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="<?= base_url("/admin/entidadesDistribuidoras/editar/" . $EntidadeDistribuidora->getId()) ?>" method="POST" class="form-ajax no-reset" enctype="multipart/form-data">
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Designacao">Nome</label>
                            <input type="text" name="Nome" placeholder="Nome" value="<?= $EntidadeDistribuidora->getNome() ?>"/>
                        </div>
                    </div>
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="NIF">Nif</label>
                            <input type="text" step="1" name="NIF" id="NIF" value="<?= $EntidadeDistribuidora->getNIF() ?>" placeholder="NIF"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column large-10 small-12">
                        <div class="input-group">
                            <label for="NomeCompleto">Nome Completo da Entidade</label>
                            <input type="text" name="NomeCompleto" value="<?= $EntidadeDistribuidora->getNomeCompleto(); ?>" placeholder="Nome utilizado para emissão de Credenciais"/>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="column large-10 small-12">
                        <div class="input-group">
                            <label for="Morada">Morada</label>
                            <input type="text" step="1" name="Morada" id="Morada" value="<?= $EntidadeDistribuidora->getMorada() ?>" placeholder="Morada"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column large-10 medium-8 small-12">
                        <div class="input-group">
                            <label for="TipoOperacao">Tipo de Operação</label>
                            <input type="text" name="TipoOperacao" value="<?= $EntidadeDistribuidora->getTipoOperacao() ?>"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column large-12 medium-12 small-12 input-group">
                        <div class="input-group">
                            <label for="Logo">Logo</label>
                            <input type="file" id="Logo" name="Logo" class="show-for-sr">
                        </div>
                        <?
                        if (trim($EntidadeDistribuidora->getLogo()) == "" || $EntidadeDistribuidora->getLogo() == null) {
                            $urlImg = base_url('ficheiros/imagens/base/default.png');
                        } else {
                            $urlImg = base_url(CAMINHO_IMAGENS_DINAMICAS . 'logos_entidades/' . $EntidadeDistribuidora->getLogo());
                        }
                        ?>
                        <img loading="lazy" height="50px" style="max-width: 150px" src="<?= $urlImg ?>">
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

