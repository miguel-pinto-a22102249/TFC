<?php

if (count($Constituintes) > 0) {
    ?>
    <div id="Area-Lista-Escaloes" class="area-listagem">
        <div class="row">
            <div class="columns large-12">

                <table class="dataTable display responsive">
                    <thead>
                    <tr>
                        <th class="text-center">NISS</th>
                        <th class="text-center defaultSort">Agregado</th>
                        <th class="text-center">Escalão</th>
                        <th class="th-opcoes"><i class="fas fa-cog fa-2x"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?

                    foreach ($Constituintes as $Constituinte) { ?>
                        <tr class="tr-accordion">
                            <td class="trigger">
                                xxx xxx <?= substr($Constituinte->getNiss(), 6, 9); ?>
                            </td>
                            <td class="text-center">
                                <?= $Constituinte->getDesignacaoAgregado(); ?>
                            </td>
                            <td class="text-center">
                                <?= $Constituinte->getDesignacaoEscalao(); ?>
                            </td>
                            <td class="td-opcoes">
                                <ul class="dropdown menu" data-dropdown-menu>
                                    <li>
                                        <a class="text-right" href="javascript:;"><i class="fas fa-2x fa-cog"></i></a>
                                        <ul class="menu text-left">
                                            <li>
                                                <a style="text-decoration:none" href="<?= base_url() . 'admin/agregados/constituintes/editar/' . $Constituinte->Segmento ?>">
                                                    <i class="fas fa-search-plus fa-1x"></i> Consultar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="Editar" href="<?= base_url() . 'admin/agregados/constituintes/editar/' . $Constituinte->getId() ?>">
                                                    <i class="fas fa-edit fa-1x"></i> Ediar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="confirma-accao" href="<?= base_url() . 'admin/agregados/constituintes/eliminar/' . $Constituinte->getId() ?>">
                                                    <i class="fas fa-trash-alt fa-1x"></i> Eliminar
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    <? } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
<? } ?>













