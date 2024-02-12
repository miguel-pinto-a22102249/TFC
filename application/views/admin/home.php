<div id="Home">	
    <h2 class="text-center">Bem Vindo</h2>
    <div class="grid-x align-center align-self-middle">
        <div class="large-10 medium-11 small-12 cell">
            <? /* Tabela de Logs */ ?>
            <h3 class=" margin-top-60">Ùltimos Logs</h3>
            <table class="text-center responsive">
                <thead>
                    <tr>
                        <th class = "text-center">Data de Criação</th>
                        <th class = "text-center">Utilizador</th>
                        <th class = "text-center">Descrição</th>
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


