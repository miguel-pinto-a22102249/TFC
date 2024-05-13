<?php

/* @var $distribuicao Distribuicao */
/* @var $produto Produto */
/* @var $agregados Agregado_Familiar */

$entregas ??= [];
$distribuicoes_individuais ??= [];
$produtos ??= [];
$agregados ??= [];
$distribuicoes ??= [];

$CI = &get_instance();
//Organizar as distruicoes por agregado
$distribuicoesPorAgregado = [];
foreach ($distribuicoes as $distribuicao) {
    $distribuicoesPorAgregado[$distribuicao->getIdAgregado()][] = $distribuicao;
}

//$CI = &get_instance();
//$CI->firephp->log($distribuicoesPorAgregado, 'distribuicoesPorAgregado');


if (count($distribuicoesPorAgregado) > 0) { ?>
    <div id="Area-Lista-Distribuicoes" class="area-listagem">
        <div class="row">
            <div class="columns large-12">
                <table class="responsive">
                    <thead>
                    <tr>
                        <th class="text-center defaultSort">NISS Constituinte Principal</th>
                        <!--                        <th class="text-center">Estado</th>-->
                        <th class="text-center">Entregas</th>
                        <!--                        <th class="th-opcoes"><i class="fas fa-cog fa-2x"></i></th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach ($distribuicoesPorAgregado as $IdAgregado => $distribuicaoAgregado) { ?>
                        <tr class="tr-accordion">
                            <td class="trigger">
                                <? if ($this->session->userdata('ModoPrivacidade') == false) { ?>
                                    xxx xxx <?= substr($agregados[$IdAgregado]->getNissConstituintePrincipal(), 6, 9); ?>
                                    <?
                                } else {
                                    echo $agregados[$IdAgregado]->getNissConstituintePrincipal();
                                } ?>
                            </td>
                            <!--                            <td>-->
                            <!--                                --><?php //= $agregados[$IdAgregado]->getDesignacaoEstado() ?>
                            <!--                            </td>-->
                            <td>
                                <?
                                $ProdutosQuantidadesAgregado = [];
                                foreach ($distribuicaoAgregado as $distribuicao) { ?>
                                    <?
                                    $IdsEntregas = json_decode($distribuicao->getIdsEntregas());
                                    foreach ($IdsEntregas as $IdEntrega) {
                                        $entrega = $entregas[$IdEntrega];
                                        $IdsDistriIndividuais = json_decode($entrega->getIdsDistribuicoesIndividuais());
                                        foreach ($IdsDistriIndividuais as $IdDistriIndividual) {
                                            $distribuicaoIndividual = $distribuicoes_individuais[$IdDistriIndividual];
                                            $ProdutosDistribuicaoIndividual = json_decode($distribuicaoIndividual->getProdutosQuantidades());
                                            foreach ($ProdutosDistribuicaoIndividual as $IdProduto => $Quantidade) {
                                                if (!key_exists($IdProduto, $ProdutosQuantidadesAgregado)) {
                                                    $ProdutosQuantidadesAgregado[$IdProduto] = 0;
                                                }
                                                $ProdutosQuantidadesAgregado[$IdProduto] += $Quantidade;// Aqui vamos junatar todas as quantidades de produtos do agregado
                                            }
                                        } ?>
                                    <? } ?>
                                    <?
                                }
                                ?>
                                <table class="responsive">
                                    <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Quantidade</th>
                                    </tr>
                                    </thead>
                                    <? foreach ($ProdutosQuantidadesAgregado as $IdProduto => $Quantidade) {
                                        $produto = $produtos[$IdProduto];
                                        if ($Quantidade == 0) {
                                            continue;
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <?= $produto->getNome() ?>
                                            </td>
                                            <td>
                                                <?= $Quantidade ?>
                                            </td>
                                        </tr>
                                        <?
                                    } ?>
                                </table>
                            </td>
                        </tr>
                        <?
                    } ?>
                    </tbody>
                </table>

                <h3>Assinatura</h3>
                <canvas id="signatureCanvas" width="400" height="200" style="border: 2px solid black"></canvas>
                <br>
                <button id="saveButton">Salvar Assinatura</button>
                <button id="clearCanvasButton">Limpar Assinatura</button>
                <img id="signatureImage" src="" alt="Assinatura">
            </div>
        </div>
    </div>
    <?
} ?>
<script src="<?= base_url() . '/ficheiros/js/admin/assinatura.js' . "?" . CACHE ?>"></script>











