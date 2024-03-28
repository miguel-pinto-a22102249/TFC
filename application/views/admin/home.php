<div id="Home">
    <div class="row">
        <div class="column large-6 medium-12 small-12">
            <h3 class="">Entregas Finalizadas</h3>

        </div>
        <div class="column large-6 medium-12 small-12">
            <div class="row">
                <div class="column large-12">
                    <h3 class="">Número de Agregados</h3>
                </div>
                <div class="column large-12">
                    <h3 class="">Erros</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="column large-12">
            <h3 class=" margin-top-60">Últimos Logs</h3>
            <table class="text-center responsive">
                <thead>
                <tr>
                    <th class="text-center">Data de Criação</th>
                    <th class="text-center">Utilizador</th>
                    <th class="text-center">Descrição</th>
                </tr>
                </thead>
                <?
                if ($logs) {
                    foreach ($logs as $log) {
                        ?>
                        <tr>
                            <td>
                                <?= $log->getDataCriacao(); ?>
                            </td>
                            <td>
                                Nome = <?= $log->getNomeUtilizador($log->getIdUtilizador()); ?><br>
                                Id = <?= $log->getIdUtilizador(); ?>
                            </td>
                            <td>
                                <?= $log->getDescricao(); ?>
                            </td>
                        </tr>
                        <?
                    }
                }
                ?>

            </table>
        </div>
    </div>
</div>



