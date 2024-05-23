
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
                        <th class="text-center">NISS Constituinte Principal</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center defaultSort">Entregas</th>
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
                            <td>
                                <?= $agregados[$IdAgregado]->getDesignacaoEstado() ?>
                            </td>
                            <td>
                                <?
                                foreach ($distribuicaoAgregado as $distribuicao) { ?>
                                    <?
                                    $IdsEntregas = json_decode($distribuicao->getIdsEntregas());
                                    foreach ($IdsEntregas as $IdEntrega) {
                                        $entrega = $entregas[$IdEntrega];
                                        $IdsDistriIndividuais = json_decode($entrega->getIdsDistribuicoesIndividuais());
                                        foreach ($IdsDistriIndividuais as $IdDistriIndividual) {
                                            $distribuicaoIndividual = $distribuicoes_individuais[$IdDistriIndividual];
                                            $ProdutosDistribuicaoIndividual = json_decode($distribuicaoIndividual->getProdutosQuantidades());
                                            ?>
                                            <details class="details__tabela-produtos-a-receber">
                                                <summary><i class="fa fa-arrow-down"></i>
                                                    <? if ($this->session->userdata('ModoPrivacidade') == false) { ?>
                                                        xxx xxx <?= substr($distribuicaoIndividual->getNissConstituinte(), 6, 9); ?>
                                                        <?
                                                    } else {
                                                        echo $distribuicaoIndividual->getNissConstituinte();
                                                    } ?>
                                                </summary>
                                                <table class="responsive">
                                                    <thead>
                                                    <tr>
                                                        <th>Produto</th>
                                                        <th>Quantidade</th>
                                                    </thead>
                                                    <? foreach ($ProdutosDistribuicaoIndividual as $IdProduto => $Quantidade) {
                                                        $produto = new Produto();
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
                                            <?
                                        }
                                    } ?>
                                    <?
                                }
                                ?>
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

/*
if (count(distribuicoesPorAgregado) > 0) {
    ?>
    <div id="Area-Lista-Escaloes" class="area-listagem">
        <div class="row">
            <div class="columns large-12">
                <table class="dataTable display responsive">
                    <thead>
                    <tr>
                        <th class="text-center">NISS Constituinte Principal</th>
                        <th class="text-center defaultSort">Grupo</th>
                        <th class="text-center">Estado</th>
                        <th class="th-opcoes"><i class="fas fa-cog fa-2x"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?

                    foreach ($Agregados as $agregado) { ?>
                        <tr class="tr-accordion">
                            <td class="trigger">
                                <a style="text-decoration:none" href="admin/agregado/consultar/<?= $agregado->getSegmento() ?>">
                                    <? if ($this->session->userdata('ModoPrivacidade') == false) { ?>
                                        xxx xxx <?= substr($agregado->getNissConstituintePrincipal(), 6, 9); ?>
                                        <?
                                    } else {
                                        echo $agregado->getNissConstituintePrincipal();
                                    } ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <?= $agregado->getGrupo(); ?>
                            </td>
                            <td class="text-center">
                                <?= $agregado->getDesignacaoEstado(); ?>
                            </td>
                            <td class="td-opcoes">
                                <ul class="dropdown menu" data-dropdown-menu>
                                    <li>
                                        <a class="text-right" href="javascript:;"><i class="fas fa-2x fa-cog"></i></a>
                                        <ul class="menu text-left">
                                            <li>
                                                <a style="text-decoration:none" href="<?= base_url() . 'admin/agregados/consultar/' . $agregado->Segmento ?>">
                                                    <i class="fas fa-search-plus fa-1x"></i> Consultar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="Editar" href="<?= base_url() . 'admin/agregados/editar/' . $agregado->getId() ?>">
                                                    <i class="fas fa-edit fa-1x"></i> Ediar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="confirma-accao" href="<?= base_url() . 'admin/agregados/eliminar/' . $agregado->getId() ?>">
                                                    <i class="fas fa-trash-alt fa-1x"></i> Eliminar
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    <? } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<? } ?>
*/












