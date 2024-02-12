<div id="Lista-Logs">	
    <h2 class="text-center">Logs</h2>
    <div class="grid-x align-center align-self-middle">
        <div class="large-10 medium-11 small-12 cell">
            <table class="text-center dataTable display responsive">
                <thead>
                    <tr>
                        <th class="text-center defaultSort">Data de Criação</th>
                        <th class="text-center">Utilizador</th>
                        <th class="text-center">Descrição</th>
                    </tr>
                </thead>
                <? foreach ($logs as $log) { ?>
                    <tr class="accordion">
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
                <? } ?>
            </table>
        </div>
    </div>
</div>
