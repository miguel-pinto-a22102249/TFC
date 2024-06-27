<?
?>
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
                    <table class="responsive">
                        <thead>
                        <tr>
                            <th>Data</th>
                            <th>Número de Grupo da Distribuição</th>
                            <th>Opções</th>
                        </tr>
                        </thead>
                        <? foreach ($Data as $D) {
                            $credencialA = false;
                            foreach ($credenciais as $credencial) {
                                if ($credencial->getGrupoDistribuicao() == $D[1]
                                    && $credencial->getTipoCredencial() == Credencial::TIPO_CREDENCIAL_A) {
                                    $credencialA = $credencial;
                                    break;
                                }
                            }

                            /*
                             * $D[0] - Data
                             * $D[1] - NumeroGrupoDistribuicao
                             * */
                            ?>
                            <tr>
                                <td><?= $D[0] ?></td>
                                <td><?= $D[1] ?></td>
                                <td>
                                    <a title="Listar distribuição por Constituinte" class="btn-style small" href="<?= base_url('admin/distruibuicoes/listarPorConstituinte/' . $D[1]) ?>"><i class="fas fa-user"></i></a>
                                    <a title="Listar distribuição por Agregado" class="btn-style small" href="<?= base_url('admin/distruibuicoes/listarPorAgregado/' . $D[1]) ?>"><i class="fas fa-users"></i></a>
<!--                                    <a title="Gerar Credencial A" class="btn-style small btn-assinar-credencial btn-assinar-credencial-a" href="--><?php //= base_url('admin/credenciais/gerarCredencialA/' . $D[1]) ?><!--"><i class="fas fa-file"></i></a>-->


                                    <? if (!$credencialA) { ?>
                                        <a title="Gerar / Assinar Credencial A" class="btn-style small btn-assinar-credencial btn-assinar-credencial-a"
                                           href="<?= base_url('admin/credenciais/gerarCredencialA/' . $D[1]) ?>"><i class="fas fa-file"></i></a>
                                    <? } else { ?>
                                        <a title="Consultar Credencial A" class="btn-style small btn-consultar-credencial-a"
                                           href="<?= base_url('admin/credenciais/consultarCredencialA/' . $credencialA->getId()) ?>">
                                            <i class="fas fa-file"></i>
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    <? } ?>


                                </td>
                            </tr>
                            <?
                        } ?>
                    </table>
                </details>
            <? } ?>
        </div>
    </div>
</div>












