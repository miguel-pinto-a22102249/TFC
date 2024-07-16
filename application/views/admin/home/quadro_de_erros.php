<?php
$this->load->model('Produto');
$this->load->model('Distribuicao');
$this->load->model('Agregado_Familiar');
$this->load->model('Constituinte');
$produtos_sem_stock = (new Produto())->obtemElementos(null, ['StockAtual' => [0,"where"]]);
$distribuicoes = (new Distribuicao())->obtemElementos(null, null);
$agregados = (new Agregado_Familiar())->obtemElementos(null, null);
$constituintes = (new Constituinte())->obtemElementos(null, null);

?>
<div class="wrapper-quadro-erros">
    <table>
        <tbody>
        <tr>
            <td>
                <span><b>Produtos sem stock</b></span>
            </td>
            <td>
                <?= count($produtos_sem_stock) ?>
            </td>
        </tr>
        <tr>
            <td>
                <span><b>Distribuições não concluidas</b></span>
            </td>
            <td>
                <?= count($distribuicoes) ?>
            </td>
        </tr>
        <tr>
            <td>
                <span><b>Total de Agregados</b></span>
            </td>
            <td>
                <?= count($agregados) ?>
            </td>
        </tr>
        <tr>
            <td>
                <span><b>Total de Constituintes</b></span>
            </td>
            <td>
                <?= count($constituintes) ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>