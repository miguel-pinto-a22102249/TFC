<div id="Area-Lista-Distribuicoes-Data" class="area-listagem">
    <div class="row">
        <div class="columns large-12">
            <?
            $CI = &get_instance();

            //Agrupar as datas por anos
            $Datas_por_ano = [];
            foreach ($Datas as $Data) {
//                var_dump($Data);
                $Datas_por_ano[dataFormatada($Data->Data, '%Y')][] = [$Data->Data, $Data->NumeroGrupoDistribuicao];
            }

            foreach ($Datas_por_ano as $Ano => $Data) {
                ?>
                <details>
                    <summary><i class="fa fa-arrow-down"></i> Distribuições de: <?= $Ano ?></summary>
                    <ul>
                        <? foreach ($Data as $D) { ?>
                            <li>
                                <?= $D[0] . ' - Número de Grupo da Distribuição: ' . $D[1] ?>
                                <a title="Listar distribuição por Constituinte" href="<?= base_url('admin/distruibuicoes/listarPorConstituinte/' . $D[1]) ?>"><i class="fas fa-user"></i></a>
                                <a title="Listar distribuição por Agregado" href="<?= base_url('admin/distruibuicoes/listarPorAgregado/' . $D[1]) ?>"><i class="fas fa-users"></i></a>
                            </li>
                            <?
                        } ?>
                    </ul>
                </details>
            <? } ?>
        </div>
    </div>
</div>












