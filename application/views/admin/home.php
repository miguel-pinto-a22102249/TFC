<script src="<?= base_url() . './ficheiros/js/chart.js' . "?" . config_item('gestao.assets_version'); ?>"></script>

<div id="Home">


    <div class="row">
        <div class="column large-6 medium-12 small-12">
            <?= $this->load->view('admin/estatisticas/numero_total_distribuicoes_mes'); ?>
        </div>
        <div class="column large-6 medium-12 small-12">
            <div class="row">
                <div class="column large-12">
                    <h3 class="">Resumo</h3>
                    <?= $this->load->view('admin/home/quadro_de_erros'); ?>
                </div>
            </div>
        </div>
    </div>

    <?
    if (!eUtilizador()) {
        ?>
        <div class="row">
            <div class="column large-12">
                <h3 class=" margin-top-60">Últimos Logs</h3>
                <table class="text-center responsive">
                    <thead>
                    <tr>
                        <th class="text-center">Data de Criação</th>
                        <th class="text-center">Utilizador</th>
                        <th class="text-center">Ação</th>
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
                                    <?= $log->getAcao(); ?>
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
    <? } ?>
</div>

