<div id="Area-Lista-Distribuicoes-Data" class="area-listagem">
    <div class="row">
        <div class="columns large-12">
            <?
            $CI = &get_instance();

            //Agrupar as datas por anos
            $Datas_por_ano = [];
            foreach ($Datas as $Data) {
                $Datas_por_ano[dataFormatada($Data->Data, '%Y')][] = $Data->Data;
            }

            foreach ($Datas_por_ano as $Ano => $Data) {
                ?>
                <details>
                    <summary><?= $Ano ?></summary>
                    <? foreach ($Data as $D) { ?>
                        <div><?= $D ?></div>
                        <?
                    } ?>
                </details>
            <? } ?>
        </div>
    </div>
</div>












