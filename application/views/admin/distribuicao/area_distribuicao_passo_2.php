<?
/** @var Agregado_Familiar $agregado */

//var_dump($agregados_constituinCtes);

$CI = &get_instance();

$produtos = (new Produto)->obtemElementos(null, null, ['Estado' => ESTADO_ATIVO]);

//Vai guardar os totais de produtos necessários depois da soma de todos os constituintes
$totaisProdutosNecessarios = [];

?>
<div class="Area-Disctribuicao-passo-2">
    <form action="<?= base_url("/admin/distribuicoes/distribuicaoPasso3") ?>" method="POST"
          class="no-ajax form-distribuicao-passo2" enctype="multipart/form-data">
        <section>
            <div class="row">
                <div class="column large-12 medium-12 small-12" style="overflow-x: auto">

                    <table>
                        <thead>
                        <tr>
                            <th>Niss Agregado</th>
                            <th>Niss Constituinte</th>
                            <th>Escalão</th>
                            <th>Produtos</th>
                        </tr>
                        </thead>
                        <? foreach ($agregados_constituintes as $niss_agregado => $agregado_constituintes) {
                            foreach ($agregado_constituintes as $agregado_constituinte) {
//                                $CI = &get_instance();
//                                $CI->firephp->log($agregado_constituinte);

                                // hidden input para guardar o niss do agregado
                                ?>
                                <input type="hidden" name="NissConstituintes[]" value="<?= $agregado_constituinte->getNiss() ?>">
                                <tr>
                                    <td>
                                        <? if ($this->session->userdata('ModoPrivacidade') == false) { ?>
                                            xxx xxx <?= substr($niss_agregado, 6, 9); ?>
                                            <?
                                        } else {
                                            echo $niss_agregado;
                                        } ?>
                                    </td>
                                    <td>
                                        <? if ($this->session->userdata('ModoPrivacidade') == false) { ?>
                                            xxx xxx <?= substr($agregado_constituinte->getNiss(), 6, 9); ?>
                                            <?
                                        } else {
                                            echo $agregado_constituinte->getNiss();
                                        } ?>
                                    </td>
                                    <td>
                                        <?= $agregado_constituinte->getDesignacaoEscalao() ?>
                                    </td>
                                    <td>
                                        <table>
                                            <thead>
                                            <tr>
                                                <?
                                                foreach ($agregado_constituinte->ProdtutosQuantidades as $produto_id => $quantidade) {
                                                    if (array_key_exists($produto_id, $totaisProdutosNecessarios) == false) {
                                                        //Tem o if para inicializar o indice caso não existe, para evitar o notice
                                                        $totaisProdutosNecessarios[$produto_id] = 0;
                                                        $totaisProdutosNecessarios[$produto_id] += $quantidade[0];
                                                    } else {
                                                        $totaisProdutosNecessarios[$produto_id] += $quantidade[0];
                                                    } ?>
                                                    <th><?= $produtos[$produto_id]->getNome() ?></th>
                                                    <?
                                                } ?>
                                            </tr>
                                            </thead>
                                            <tr>
                                                <?
                                                foreach ($agregado_constituinte->ProdtutosQuantidades as $produto_id => $quantidade) {
                                                    ?>
                                                    <td>
                                                        <table>
                                                            <thead>
                                                            <tr>
                                                                <th>Quant. a Atribuir</th>
                                                                <th>Quant. Atribuida</th>
                                                            </tr>
                                                            </thead>
                                                            <tr>
                                                                <td class="text-center"><?= $quantidade[0] ?></td>
                                                                <td>
                                                                    <input class="<?= $quantidade[1] == 0 ? 'outline--error' : '' ?>" type="number"
                                                                           name="QuantidadeAjustada[<?= $agregado_constituinte->getId() ?>][<?= $produto_id ?>]" value="<?= $quantidade[1] ?>" min="0">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <?
                                                }
                                                ?>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            <? }
                        } ?>
                    </table>
                </div>
            </div>
        </section>

        <div class="row">
            <div class="column large-12 medium-12s small-12">
                <h3>Produtos necessários</h3>
                <table>
                    <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Stock Atual</th>
                    </tr>
                    </thead>
                    <? foreach ($totaisProdutosNecessarios as $produto_id => $quantidade) { ?>
                        <tr>
                            <?
                            $insuficiente = $produtos[$produto_id]->getStockAtual() < $quantidade;
                            ?>
                            <td><?= $produtos[$produto_id]->getNome() ?></td>
                            <td><?= $quantidade ?></td>
                            <td>
                                <?
                                if ($insuficiente) {
                                    ?><span class="label--error"><?= $produtos[$produto_id]->getStockAtual() ?></span><?
                                } else { ?>
                                    <span class="label--correct"><?= $produtos[$produto_id]->getStockAtual() ?></span>
                                    <?
                                }
                                ?>
                        </tr>
                    <? } ?>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="column large-12 medium-12s small-12">
                <h3>Preview de stocks após distribuição</h3>
                <table>
                    <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Stock Atual</th>
                    </tr>
                    </thead>
                    <? foreach ($produtos_apos_distribuicao as $produto) { ?>
                        <tr>
                            <td><?= $produto->getNome() ?></td>
                            <td><?= $produto->getStockAtual() ?></td>
                        </tr>
                    <? } ?>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="column large-12 medium-12s small-12 text-right">
                <button class="btn-style button" type="submit">
                    <i class="fas fa-save fa-1x"></i> Gravar Distribuição
                </button>
            </div>
        </div>
    </form>
</div>

