<?php

if (count($Escaloes) > 0) {
    ?>
    <div id="Area-Lista-Escaloes" class="area-listagem">
        <div class="row">
            <div class="columns large-12">

                <table class="dataTable display responsive">
                    <thead>
                    <tr>
                        <th class="text-center">Designação</th>
                        <th class="text-center defaultSort">Idade Inicial</th>
                        <th class="text-center">Idade Limite</th>
                        <th class="th-opcoes"><i class="fas fa-cog fa-2x"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?

                    foreach ($Escaloes as $escalao) { ?>
                        <tr class="tr-accordion">
                            <td class="trigger">
                                <a style="text-decoration:none" href="admin/escaloes/consultar/<?= $escalao->getSegmento() ?>">
                                    <?= $escalao->getDesignacao(); ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <?= $escalao->getIdadeInicial(); ?>
                            </td>
                            <td class="text-center">
                                <?= $escalao->getIdadeFinal(); ?>
                            </td>
                            <td class="td-opcoes">
                                <ul class="dropdown menu" data-dropdown-menu>
                                    <li>
                                        <a class="text-right" href="javascript:;"><i class="fas fa-2x fa-cog"></i></a>
                                        <ul class="menu text-left">
                                            <li>
                                                <a style="text-decoration:none" href="<?= base_url() . 'admin/escaloes/consultar/' . $escalao->Segmento ?>">
                                                    <i class="fas fa-search-plus fa-1x"></i> Consultar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="Editar" href="<?= base_url() . 'admin/escaloes/editar/' . $escalao->getId() ?>">
                                                    <i class="fas fa-edit fa-1x"></i> Ediar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="confirma-accao" href="<?= base_url() . 'admin/escaloes/eliminar/' . $escalao->getId() ?>">
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













