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
$EntidadeDistribuidora = $entidades_distribuidoras[reset($distribuicoes)->getIdEntidadeDistribuidora()];


//$CI = &get_instance();
//$CI->firephp->log($distribuicoesPorAgregado, 'distribuicoesPorAgregado');


if (count($distribuicoesPorAgregado) > 0) { ?>
    <div class="credencial-b">
        <div class="row">
            <div class="columns large-12">
                <div class="html-credencial">
                    <?
                    if (trim($EntidadeDistribuidora->getLogo()) == "" || $EntidadeDistribuidora->getLogo() == null) {
                        $urlImg = base_url('ficheiros/imagens/base/default.png');
                    } else {
                        $urlImg = base_url(CAMINHO_IMAGENS_DINAMICAS . 'logos_entidades/' . $EntidadeDistribuidora->getLogo());
                    }
                    ?>
                    <img class="credencial-b__logo-entidade" loading="lazy" height="50px" style="max-width: 150px" src="<?= $urlImg ?>">

                    <div class="credencial-b__header">
                        <p><strong>Entidade Beneficiária (NIF | Nome):</strong> <?= $EntidadeDistribuidora->getNIF() ?> / <?= $EntidadeDistribuidora->getNomeCompleto() ?></p>
                        <p><strong>Território:</strong> <?= config_item('credencial_territorio') ?></p>
                        <p><strong>Tipologia de Operação:</strong> <?= $EntidadeDistribuidora->getTipoOperacao() ?></p>
                        <p><strong>Organismo Intermédio (OI):</strong> <?= config_item('credencial_organismo_intermedio') ?></p>
                    </div>

                    <div>
                        <h3>Credencial A</h3>
                        <p>A Credencial A diz respeito ao registo das quantidades de produtos distribuídos pelas Entidades Mediadoras aos destinatários finais.</p>
                    </div>


                    <div class="section-title margin-top-30 margin-bottom-10">1. Registo da Credencial A</div>
                    <table>
                        <tbody>
                        <tr>
                            <td><strong>1.1. Nº da Credencial B:</strong></td>
                            <td> <?= reset($distribuicoes)->getNumeroGrupoDistribuicao() . '/' . date('Y') ?></td>

                        </tr>
                        <tr>
                            <td><strong>1.2. Data da Credencial:</strong></td>
                            <td><?= date("d/m/Y"); ?></td>
                        </tr>
                        <tr>
                            <td><strong>1.3. Entidade Mediadora:</strong></td>
                            <td><?= $EntidadeDistribuidora->getNomeCompleto() ?></td>
                        </tr>
                        <tr>
                            <td><strong>1.4. Morada:</strong></td>
                            <td>Qta. Santa Maria Rua Maria Eduarda Segura de Faria n.º 2</td>
                        </tr>
                        <tr>
                            <td><strong>1.5. NIF da Entidade:</strong></td>
                            <td><?= $EntidadeDistribuidora->getNIF() ?></td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="section-title margin-top-30 margin-bottom-10">3. Nº de Levantamento e Lista de Produtos</div>
                    <table class="responsive">
                        <thead>
                        <tr>
                            <th class="text-center defaultSort">NISS Constituinte Principal</th>
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



                    <div class="observations margin-bottom-30 margin-top-30">
                        <strong>Observações:</strong>
                        <textarea name="observacoes"></textarea>
                    </div>

                    <div class="margin-top-30 margin-bottom-10">
                        <p><strong>O/A Responsável</strong></p>
                        <div class="row signature-container">
                            <div class="columns large-6 remover">
                                <canvas class="signatureCanvas" width="350" height="150"></canvas>
                                <br>
                                <button class="saveButton btn-style small">Guardar Assinatura</button>
                                <button class="clearCanvasButton btn-style small">Limpar Assinatura</button>
                            </div>
                            <div class="columns large-6">
                                <img class="signatureImage" src="" alt="Assinatura" style="display: none">
                            </div>
                        </div>
                    </div>
<!--                    <div class="margin-top-30 margin-bottom-10">-->
<!--                        <p><strong>(1) Titular ou representante do agregado familiar.</strong></p>-->
<!--                        <div class="row signature-container margin-top-30 margin-bottom-10">-->
<!--                            <div class="columns large-6 remover">-->
<!--                                <canvas class="signatureCanvas" width="350" height="150"></canvas>-->
<!--                                <br>-->
<!--                                <button class="saveButton btn-style small">Guardar Assinatura</button>-->
<!--                                <button class="clearCanvasButton btn-style small">Limpar Assinatura</button>-->
<!--                            </div>-->
<!--                            <div class="columns large-6">-->
<!--                                <img class="signatureImage" src="" alt="Assinatura" style="display: none">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

                </div>
                <?
                //                $CI->firephp->log(reset($distribuicoes));
                ?>
                <input type="hidden" id="IdDistribuicao" name="IdDistribuicao" value="<?= reset($distribuicoes)->getId() ?>">
                <input type="hidden" id="GrupoDistribuicao" name="GrupoDistribuicao" value="<?= reset($distribuicoes)->getNumeroGrupoDistribuicao() ?>">
                <input type="hidden" id="TipoCredencial" name="TipoCredencial" value="<?= Credencial::TIPO_CREDENCIAL_A ?>">
                <div class="row">
                    <div class="columns large-12">
                        <button id="btn-gerar-credencial" data-url="<?= base_url('admin/credenciais/gravarCredencial') ?>" class="btn-style">Gerar Credencial</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?
} ?>
<script src="<?= base_url() . '/ficheiros/js/admin/credenciais.js' . "?" . config_item('gestao.assets_version'); ?>"></script>










