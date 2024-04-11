<?
/** @var Agregado_Familiar $agregado */

//var_dump($agregados_constituinCtes);

$CI = &get_instance();

$produtos = (new Produto)->obtemElementos(null, null, ['Estado' => ESTADO_ATIVO]);

//Vai guardar os totais de produtos necessários depois da soma de todos os constituintes
$totaisProdutosNecessarios = [];

?>
<div class="Area-Disctribuicao-passo-2">
    <section>
        <div class="row">
            <div class="column large-12 medium-12 small-12">
                <table>
                    <thead>
                    <tr>
                        <th>Niss Agregado</th>
                        <th>Niss Constituinte</th>
                        <th>Produtos</th>
                    </tr>
                    </thead>
                    <? foreach ($agregados_constituintes

                                as $key => $agregado_constituintes) {
                        foreach ($agregado_constituintes

                                 as $agregado_constituinte) {
                            ?>
                            <tr>
                                <td><?= $key ?></td>
                                <td><?= $agregado_constituinte->getNiss() ?></td>
                                <td>
                                    <table>
                                        <thead>
                                        <tr>
                                            <?
                                            foreach ($agregado_constituinte->ProdtutosQuantidades as $produto_id => $quantidade) {
                                                if (array_key_exists($produto_id, $totaisProdutosNecessarios) == false) {
                                                    //Tem o if para inicializar o indice caso não existe, para evitar o notice
                                                    $totaisProdutosNecessarios[$produto_id] = 0;
                                                    $totaisProdutosNecessarios[$produto_id] += $quantidade;
                                                } else {
                                                    $totaisProdutosNecessarios[$produto_id] += $quantidade;
                                                } ?>
                                                <th><?= $produtos[$produto_id]->getNome() ?></th>
                                                <?
                                            } ?>
                                        </tr>
                                        </thead>
                                        <tr>
                                            <?
                                            foreach ($agregado_constituinte->ProdtutosQuantidades as $produto_id => $quantidade) { ?>
                                                <td><?= $quantidade ?></td>
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
                <? foreach ($totaisProdutosNecessarios

                            as $produto_id => $quantidade) {
                    ?>
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
</div>

