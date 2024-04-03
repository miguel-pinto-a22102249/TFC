<?
$coresSofts = [
    '#E2E8F0', '#EEDEE5', '#EDF2F7', '#DFDEEE', '#EBF8FF', '#DFEEDE', '#F0F0F0', '#FAF5FF', '#FFF5F7', '#FFF7E6'
]; ?>

<div class="area-importacao margin-top-40 area-listagem">
    <div class="row">
        <? if (count($agregados) > 0) { ?>
            <div class="column large-12 medium-10 small-12">
                <table class="dataTable display responsive">
                    <thead>
                    <tr>
                        <th class="defaultSort">NISS Constituinte Principal</th>
                        <th class="text-center">NISS</th>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Idade</th>
                        <th class="text-center">Escalão</th>
                        <th class="text-center">Data Nascimento</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    $count = 0;
                    foreach ($agregados as $IdAgregado => $constituinte_temp) { ?>
                        <? foreach ($constituinte_temp as $constituinte) { ?>
                            <tr class="" style="background-color:<?= $coresSofts[$count] ?> ">
                                <td style="background-color:<?= $coresSofts[$count] ?>"><?php echo $IdAgregado ?></td>
                                <td class="text-center">
                                    <?= $constituinte->getNiss(); ?>
                                </td>
                                <td class="text-center">
                                    <?= $constituinte->getNome(); ?>
                                </td>
                                <td class="text-center">
                                    <?= $constituinte->Idade; ?>
                                </td>
                                <td class="text-center">
                                    <?
                                    $designacaoEscalao = $constituinte->getDesignacaoEscalao();
                                    if ($designacaoEscalao == "" || $designacaoEscalao == null || $designacaoEscalao == false || $designacaoEscalao == "-") {
                                        echo "<span class='label--error'>Não definido</span>";
                                    } else {
                                        echo $designacaoEscalao;
                                    } ?>

                                </td>
                                <td class="text-center">
                                    <?= $constituinte->getDataNascimento(); ?>
                                </td>
                            </tr>
                        <? }
                        $count++;
                        if ($count >= 10) {
                            $count = 0;
                        }
                    } ?>
                    </tbody>
                </table>
            </div>
        <? } ?>
    </div>
</div>

