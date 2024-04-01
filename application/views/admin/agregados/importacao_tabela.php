<?
$coresSofts = [
    '#E2E8F0', '#F7FAFC', '#EDF2F7', '#E0E7FF', '#EBF8FF', '#F0FFF4', '#F0F0F0', '#FAF5FF', '#FFF5F7', '#FFF7E6'
]; ?>

<div class="area-importacao">
    <div class="row">
        <? if (count($agregados) > 0) { ?>
            <div class="column large-12 medium-10 small-12 form-login-wrapper">
                <table class="dataTable display responsive">
                    <thead>
                    <tr>
                        <th class="defaultSort">NISS Constituinte Principal</th>
                        <th class="text-center">NISS</th>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Escalão</th>
                        <th class="text-center">Data Nascimento</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    $count = 0;
                    foreach ($agregados as $IdAgregado => $constituinte_temp) { ?>
                        <tr style="background-color:<?= $coresSofts[$count] ?> ">
                            <td rowspan="<?= count($constituinte_temp) + 1 ?>"><?php echo $IdAgregado ?></td>
                        </tr>
                        <? foreach ($constituinte_temp as $constituinte) { ?>
                            <tr class="" style="background-color:<?= $coresSofts[$count] ?> ">
                                <td class="text-center">
                                    <?= $constituinte->getNiss(); ?>
                                </td>
                                <td class="text-center">
                                    <?= $constituinte->getNome(); ?>
                                </td>
                                <td class="text-center">
                                    <?= $constituinte->getIdEscalao(); ?>
                                </td>
                                <td class="text-center">
                                    <?= $constituinte->getDataNascimento(); ?>
                                </td>
                            </tr>
                        <? }
                        $count++;
                    } ?>
                    </tbody>
                </table>
            </div>
        <? } ?>
    </div>
</div>

