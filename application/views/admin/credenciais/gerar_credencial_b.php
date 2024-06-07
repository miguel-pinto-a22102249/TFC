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
        <form action="<?= base_url("/admin/credenciais/gravarCredencial") ?>" method="POST" class="form-ajax" enctype="multipart/form-data">
            <div class="row">
                <div class="columns large-12">
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

                </div>
            </div>
            <div class="row">
                <div class="columns large-6">
                    <h3>Assinatura</h3>
                    <canvas id="signatureCanvas" width="350" height="150" style="border: 2px solid #cccccc"></canvas>
                    <br>
                    <button id="saveButton" class="btn-style small">Salvar Assinatura</button>
                    <button id="clearCanvasButton" class="btn-style small">Limpar Assinatura</button>
                </div>
                <div class="columns large-6">
                    <img id="signatureImage" src="" alt="Assinatura" style="display: none">

                </div>
            </div>

            <div class="row">
                <div class="columns large-12">
                    <button id="btn-gerar-credencial" class="btn-style">Gerar Credencial</button>
                </div>
            </div>
        </form>
    </div>
    <?
} ?>
<script src="<?= base_url() . '/ficheiros/js/admin/assinatura.js' . "?" . config_item('gestao.assets_version'); ?>"></script>



<style>
    h1, h2, h3 {
        text-align: center;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    th, td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    .section-title {
        font-weight: bold;
        margin-top: 20px;
    }
    .observations {
        margin-top: 20px;
        border: 1px solid #000;
        padding: 10px;
    }
</style>

<div>
    <h1>Credencial B</h1>
    <p><strong>Entidade Beneficiária (NIF | Nome):</strong> 501122915/Associação Bem Estar Infantil Vila Franca de Xira</p>
    <p><strong>Território:</strong> Vila Franca de Xira</p>
    <p><strong>Tipologia de Operação:</strong> Distribuição de Géneros Alimentares e/ou Bens de Primeira Necessidade - Continente</p>
    <p><strong>Organismo Intermédio (OI):</strong> 505305500 INSTITUTO DA SEGURANÇA SOCIAL I.P.</p>

    <div class="section-title">Registo da Credencial B</div>
    <p><strong>1.1. Nº da Credencial B:</strong> 1/2024</p>
    <p><strong>1.2. Data da Credencial:</strong> 15/01/2024</p>
    <p><strong>1.3. Entidade Mediadora:</strong> CEBI - FUNDAÇÃO PARA O DESENVOLVIMENTO COMUNITÁRIO DE ALVERCA</p>
    <p><strong>1.4. Morada:</strong> Qta. Santa Maria Rua Maria Eduarda Segura de Faria n.º 2</p>
    <p><strong>1.5. NIF da Entidade:</strong> 503738506</p>

    <div class="section-title">Dados do Titular do Agregado Familiar</div>
    <p><strong>2.1. Morada:</strong> Estrada Nacional 10 nº14 1º Dtº - Alverca</p>
    <p><strong>2.2. NISS:</strong> 11339603920</p>
    <p><strong>2.3. Nº de elementos do agregado:</strong> 5</p>

    <div class="section-title">Nº de Levantamento e Lista de Produtos</div>
    <table>
        <thead>
        <tr>
            <th>Produto</th>
            <th>Nº de Emb. Individuais a Entregar</th>
            <th>Nº de Emb. Individuais Entregues</th>
            <th>Nº de Emb. Individuais confirmadas que foram entregues *</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>LEITE DE VACA ULTRAPASTERIZADO (UHT) MEIO GORDO</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>QUEIJO CURADO DE VACA MEIO-GORDO</td>
            <td>5</td>
            <td>5</td>
            <td>5</td>
        </tr>
        <tr>
            <td>ARROZ CAROLINO</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>MASSA SIMPLES TIPO ESPARGUETE</td>
            <td>12</td>
            <td>12</td>
            <td>12</td>
        </tr>
        <tr>
            <td>CEREAIS</td>
            <td>4</td>
            <td>4</td>
            <td>4</td>
        </tr>
        <tr>
            <td>TOSTAS</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>BOLACHA MARIA</td>
            <td>14</td>
            <td>14</td>
            <td>14</td>
        </tr>
        <tr>
            <td>FEIJÃO ENCARNADO COZIDO ENLATADO</td>
            <td>4</td>
            <td>4</td>
            <td>4</td>
        </tr>
        <tr>
            <td>GRÃO-DE-BICO COZIDO ENLATADO</td>
            <td>4</td>
            <td>4</td>
            <td>4</td>
        </tr>
        <tr>
            <td>ERVILHAS COZIDAS ENLATADAS</td>
            <td>4</td>
            <td>4</td>
            <td>4</td>
        </tr>
        <tr>
            <td>FRANGO CONGELADO</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>PESCADA CONGELADA nº3</td>
            <td>4</td>
            <td>4</td>
            <td>4</td>
        </tr>
        <tr>
            <td>ATUM</td>
            <td>20</td>
            <td>20</td>
            <td>20</td>
        </tr>
        <tr>
            <td>SARDINHA EM ÓLEO VEGETAL</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>CAVALA</td>
            <td>20</td>
            <td>20</td>
            <td>20</td>
        </tr>
        <tr>
            <td>TOMATE PELADO ENLATADO</td>
            <td>4</td>
            <td>4</td>
            <td>4</td>
        </tr>
        <tr>
            <td>MISTURA DE VEGETAIS</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>BRÓCOLOS</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>FEIJÃO VERDE ULTRACONGELADO</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>ESPINAFRES</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>CENOURA ULTRACONGELADAS</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>ALHO FRANCÊS ULTRACONGELADO</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        <tr>
            <td>AZEITE</td>
            <td>2</td>
            <td>2</td>
            <td>2</td>
        </tr>
        <tr>
            <td>CREME VEGETAL PARA BARRAR</td>
            <td>3</td>
            <td>3</td>
            <td>3</td>
        </tr>
        <tr>
            <td>MARMELADA</td>
            <td>2</td>
            <td>2</td>
            <td>2</td>
        </tr>
        </tbody>
    </table>

    <div class="observations">
        <strong>Observações:</strong>
        <p></p>
    </div>

    <p><strong>O/A Responsável</strong></p>
    <p>(1) Titular ou representante do agregado familiar.</p>

    <h2>Exmo. Senhor(a)</h2>
    <p>Titular ou Representante do Agregado Familiar</p>
    <p>Morada:</p>

    <p><strong>DATA:</strong> ___ / ___ / 20___</p>

    <p><strong>ASSUNTO:</strong> Convocatória para distribuição de géneros alimentares e/ou de bens de primeira necessidade nas instalações da entidade:</p>

    <p>Informamos que no dia ___ de ___ de 202___ entre as ___:___ horas e as ___:___ horas devem dirigir-se às instalações da entidade:</p>
    <p>morada: ___</p>

    <p>a fim de levantar os géneros alimentares e/ou de bens de primeira necessidade que foram atribuídos ao vosso agregado familiar.</p>

    <p>Aproveitamos a oportunidade para lembrar que no momento da distribuição devem proceder à confirmação e validação das quantidades recebidas na respetiva credencial.</p>

    <p>Com os melhores cumprimentos</p>

    <p><strong>O/A Responsável</strong></p>
</div>










