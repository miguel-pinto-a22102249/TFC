<?php

/* @var $distribuicao Distribuicao */
/* @var $produto Produto */
/* @var $agregados Agregado_Familiar */

$entregas ??= [];
$distribuicoes_individuais ??= [];
$produtos ??= [];
$agregados ??= [];
$distribuicoes ??= [];
$credenciais ??= [];
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
                        <th class="text-center"></th>
                        <th class="text-center defaultSort">NISS Constituinte Principal</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Entregas</th>
                        <!--                        <th class="th-opcoes"><i class="fas fa-cog fa-2x"></i></th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <? foreach ($distribuicoesPorAgregado as $IdAgregado => $distribuicaoAgregado) {
                        $numeroGrupoDistribuicao = $distribuicaoAgregado[0]->getNumeroGrupoDistribuicao();

                        $credencialB = false;
                        foreach ($credenciais as $credencial) {
                            if ($credencial->getGrupoDistribuicao() == $numeroGrupoDistribuicao
                                && json_decode($credencial->getIdsObjetosAssociados()) == $distribuicaoAgregado[0]->getId()) {
                                $credencialB = $credencial;
                                break;
                            }
                        }

                        ?>
                        <tr class="tr-accordion">
                            <td class="trigger">
                                <? if (!$credencialB) { ?>
                                    <a title="Gerar / Assinar Credencial B" class="btn-style small btn-assinar-credencial"
                                       href="<?= base_url('admin/credenciais/gerarCredencialB/' . $numeroGrupoDistribuicao . '/' . $IdAgregado) ?>"><i class="fas fa-file"></i></a>
                                <? } else { ?>
                                    <a title="Consultar Credencial B" class="btn-style small btn-consultar-credencial-b"
                                       href="<?= base_url('admin/credenciais/consultarCredencialB/' . $credencialB->getId()) ?>">
                                        <i class="fas fa-file"></i>
                                        <i class="fas fa-eye"></i>
                                    </a>
                                <? } ?>
                            </td>
                            <td class="trigger">

                                <? if ($this->session->userdata('ModoPrivacidade') == false) { ?>
                                    xxx xxx <?= substr($agregados[$IdAgregado]->getNissConstituintePrincipal(), 6, 9); ?>
                                    <?
                                } else {
                                    echo $agregados[$IdAgregado]->getNissConstituintePrincipal();
                                } ?>
                            </td>
                            <td>
                                <? if ($distribuicaoAgregado[0]->getEstado() == Distribuicao::ESTADO_TERMINADA) { ?>
                                    <span class="tag-estado-sucesso"><?= $distribuicaoAgregado[0]->getDesignacaoEstado() ?></span>
                                <? } else { ?>
                                    <span class="tag-estado-aviso"><?= $distribuicaoAgregado[0]->getDesignacaoEstado() ?></span>
                                <? } ?>
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
                                <details>
                                    <summary>Ver produtos atribuidos</summary>
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
                                </details>
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













