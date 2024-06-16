<?php

$this->load->model('credencial');

/* @var $distribuicao Distribuicao */
/* @var $produto Produto */
/* @var $agregados Agregado_Familiar */

$entregas ??= [];
$distribuicoes_individuais ??= [];
$produtos ??= [];
$agregados ??= [];
$distribuicoes ??= [];
$entidades_distribuidoras ??= [];


$CI = &get_instance();
//Organizar as distruicoes por agregado
$distribuicoesPorAgregado = [];
foreach ($distribuicoes as $distribuicao) {
    $distribuicoesPorAgregado[$distribuicao->getIdAgregado()][] = $distribuicao;
}

$agregado = $agregados[reset($distribuicoes)->getIdAgregado()];
//$constituintePrincipal = (new Constituinte())->obtemElementos(null, ['Niss' => $agregado->getNissConstituintePrincipal()])[0];

//$CI = &get_instance();
//$CI->firephp->log($distribuicoesPorAgregado, 'distribuicoesPorAgregado');
//var_dump(reset($distribuicoesPorAgregado)->getIdEntidadeDistribuidora());
$EntidadeDistribuidora = $entidades_distribuidoras[reset($distribuicoes)->getIdEntidadeDistribuidora()];

if (count($distribuicoesPorAgregado) > 0) { ?>
    <!--    <div id="Area-Lista-Distribuicoes" class="area-listagem">-->
    <!--        <form action="--><?php //= base_url("/admin/credenciais/gravarCredencial") ?><!--" method="POST" class="form-ajax" enctype="multipart/form-data">-->
    <!--        </form>-->
    <!--    </div>-->

    <script src="<?= base_url() . '/ficheiros/js/admin/credenciais.js' . "?" . config_item('gestao.assets_version'); ?>"></script>

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
                        <h3>Credencial B</h3>
                        <p>A Credencial B diz respeito ao registo das quantidades de produtos distribuídos pelas Entidades Mediadoras aos destinatários finais.</p>
                        <p>
                            No ato do levantamento dos produtos, as credenciais são assinadas por quem recebe, uma vez que são a prova da entrega e da distribuição dos produtos.
                            <br>As credenciais são preenchidas em duplicado, sendo que:
                        </p>
                        <ul>
                            <li> o original é entregue ao titular ou representante do agregado familiar;</li>
                            <li> o duplicado fica arquivado na Entidade Mediadora e deve ser feito o upload para o sistema de informação</li>
                        </ul>
                    </div>


                    <div class="section-title margin-top-30 margin-bottom-10">1. Registo da Credencial B</div>
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

                    <div class="section-title margin-top-30 margin-bottom-10">2. Dados do Titular do Agregado Familiar</div>
                    <table>
                        <tbody>
                        <tr>
                            <td><strong>2.1. Morada:</strong></td>
                            <td><?= $agregado->getMorada() ?></td>
                        </tr>
                        <tr>
                            <td><strong>2.2. NISS:</strong></td>
                            <td><?= $agregado->getNissConstituintePrincipal() ?></td>
                        </tr>
                        <tr>
                            <td><strong>2.3. Nº de elementos do agregado:</strong></td>
                            <td><?= $agregado->getNumeroTotalConstituintesAgregado() ?></td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="section-title margin-top-30 margin-bottom-10">3. Nº de Levantamento e Lista de Produtos</div>
                    <? foreach ($distribuicoesPorAgregado as $IdAgregado => $distribuicaoAgregado) { ?>
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
                                <th>Nº de Emb. Individuais a Entregar</th>
                                <th>Nº de Emb. Individuais Entregues</th>
                                <th>Nº de Emb. Individuais confirmadas que foram entregues *</th>
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
                                    <td>
                                        <?= $Quantidade ?>
                                    </td>
                                    <td>
                                        <?= $Quantidade ?>
                                    </td>
                                </tr>
                                <?
                            } ?>
                        </table>

                        <?
                    } ?>


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
                    <div class="margin-top-30 margin-bottom-10">
                        <p><strong>(1) Titular ou representante do agregado familiar.</strong></p>
                        <div class="row signature-container margin-top-30 margin-bottom-10">
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

                </div>
                <?
                //                $CI->firephp->log(reset($distribuicoes));
                ?>
                <input type="hidden" id="IdDistribuicao" name="IdDistribuicao" value="<?= reset($distribuicoes)->getId() ?>">
                <input type="hidden" id="GrupoDistribuicao" name="GrupoDistribuicao" value="<?= reset($distribuicoes)->getNumeroGrupoDistribuicao() ?>">
                <input type="hidden" id="TipoCredencial" name="TipoCredencial" value="<?= Credencial::TIPO_CREDENCIAL_B ?>">
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






