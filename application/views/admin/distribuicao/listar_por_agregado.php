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
                <table class="display dataTable responsive">
                    <thead>
                    <tr>
                        <th class="text-center defaultSort">NISS Constituinte Principal</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Entregas</th>
                        <!--                        <th class="th-opcoes"><i class="fas fa-cog fa-2x"></i></th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach ($distribuicoesPorAgregado as $IdAgregado => $distribuicaoAgregado) {
                        $numeroGrupoDistribuicao = $distribuicaoAgregado[0]->getNumeroGrupoDistribuicao();
                        ?>
                        <tr class="tr-accordion">
                            <td class="trigger">
                                <a title="Gerar Credencial B" class="btn-style small btn-assinar-credencial"
                                   href="<?= base_url('admin/credenciais/gerarCredencialB/' . $numeroGrupoDistribuicao . '/' . $IdAgregado) ?>"><i class="fas fa-file"></i></a>
                                <? if ($this->session->userdata('ModoPrivacidade') == false) { ?>
                                    xxx xxx <?= substr($agregados[$IdAgregado]->getNissConstituintePrincipal(), 6, 9); ?>
                                    <?
                                } else {
                                    echo $agregados[$IdAgregado]->getNissConstituintePrincipal();
                                } ?>
                            </td>
                            <td>
                                <?= $agregados[$IdAgregado]->getDesignacaoEstado() ?>
                            </td>
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
            </div>
        </div>
    </div>
    <?
}













