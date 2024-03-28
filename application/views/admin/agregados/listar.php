<?php

if (count($Agregados) > 0) {
    ?>
    <div id="Area-Lista-Escaloes" class="area-listagem">
        <div class="row">
            <div class="columns large-12">

                <table class="dataTable display responsive">
                    <thead>
                    <tr>
                        <th class="text-center">NISS Constituinte Principal</th>
                        <th class="text-center defaultSort">Grupo</th>
                        <th class="text-center">Estado</th>
                        <th class="th-opcoes"><i class="fas fa-cog fa-2x"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?

                    foreach ($Agregados as $agregado) { ?>
                        <tr class="tr-accordion">
                            <td class="trigger">
                                <a style="text-decoration:none" href="admin/agregado/consultar/<?= $agregado->getSegmento() ?>">
                                    <?= substr($agregado->getNissConstituintePrincipal(),0,3); ?> xxx xxx
                                </a>
                            </td>
                            <td class="text-center">
                                <?= $agregado->getGrupo(); ?>
                            </td>
                            <td class="text-center">
                                <?= $agregado->getDesignacaoEstado(); ?>
                            </td>
                            <td class="td-opcoes">
                                <ul class="dropdown menu" data-dropdown-menu>
                                    <li>
                                        <a class="text-right" href="javascript:;"><i class="fas fa-2x fa-cog"></i></a>
                                        <ul class="menu text-left">
                                            <li>
                                                <a style="text-decoration:none" href="<?= base_url() . 'admin/agregados/consultar/' . $agregado->Segmento ?>">
                                                    <i class="fas fa-search-plus fa-1x"></i> Consultar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="Editar" href="<?= base_url() . 'admin/agregados/editar/' . $agregado->getId() ?>">
                                                    <i class="fas fa-edit fa-1x"></i> Ediar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="confirma-accao" href="<?= base_url() . 'admin/agregados/eliminar/' . $agregado->getId() ?>">
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













