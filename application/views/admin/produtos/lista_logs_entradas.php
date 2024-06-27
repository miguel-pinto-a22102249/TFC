<?
if (count($logs) > 0) { ?>

    <div id="Area-Lista-Logs-Produtos" class="area-listagem">
        <div class="row">
            <div class="columns large-12">
                <table class="display dataTable responsive">
                    <thead>
                    <tr>
                        <th>Data</th>
                        <th>Ação</th>
                        <th>Utilizador</th>
                        <th>Stock Atual</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    foreach ($logs as $log) {
                        ?>
                        <tr>
                            <td><?= $log->DataCriacao ?></td>
                            <td><?= $log->Acao ?></td>
                            <td><?= $utilizadores[$log->IdUtilizador]->getNome() ?></td>
                            <td><?// Usar uma expressão regular para encontrar o valor do StockAtual
                                preg_match('/StockAtual:\s*(\d+)/', $log->Descricao, $matches);

                                // Verificar se foi encontrada uma correspondência e exibir o valor
                                if (isset($matches[1])) {
                                    $stockAtual = $matches[1];
                                    echo $stockAtual;
                                } else {
                                    echo "-";
                                } ?>
                            </td>
                        </tr>
                    <? }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <?
}