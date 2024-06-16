<?php

if (count($EntidadesDistribuidoras) > 0) {
    ?>
    <div id="Area-Lista-Escaloes" class="area-listagem">
        <div class="row">
            <div class="columns large-12">

                <table class="dataTable display responsive">
                    <thead>
                    <tr>
                        <th class="text-center">Nome</th>
                        <th class="text-center defaultSort">Morada</th>
                        <th class="text-center">Logo</th>
                        <th class="th-opcoes" data-orderable='false'></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?

                    foreach ($EntidadesDistribuidoras as $EntidadeDistribuidora) { ?>
                        <tr class="tr-accordion">
                            <td class="trigger">
                                <a style="text-decoration:none" href="admin/escaloes/consultar/<?= $EntidadeDistribuidora->getSegmento() ?>">
                                    <?= $EntidadeDistribuidora->getNome(); ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <?= $EntidadeDistribuidora->getMorada(); ?>
                            </td>
                            <td class="text-center">
                                <?
                                if (trim($EntidadeDistribuidora->getLogo()) == "" || $EntidadeDistribuidora->getLogo() == null) {
                                    $urlImg = base_url('ficheiros/imagens/base/default.png');
                                } else {
                                    $urlImg = base_url(CAMINHO_IMAGENS_DINAMICAS . 'logos_entidades/' . $EntidadeDistribuidora->getLogo());
                                }
                                ?>
                                <img loading="lazy" height="50px" style="max-width: 150px" src="<?= $urlImg ?>">
                            </td>
                            <td class="td-opcoes">
                                <ul class="dropdown menu" data-dropdown-menu>
                                    <li>
                                        <a class="text-right" href="javascript:;"><i class="fas fa-2x fa-cog"></i></a>
                                        <ul class="menu text-left">
                                            <li>
                                                <a class="btn-consultar-popup-ajax" style="text-decoration:none" href="<?= base_url() . 'admin/entidadesDistribuidoras/consultar/' . $EntidadeDistribuidora->getId() ?>">
                                                    <i class="fas fa-search-plus fa-1x"></i> Consultar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="Editar btn-editar-popup-ajax" href="<?= base_url() . 'admin/entidadesDistribuidoras/viewEditar/' . $EntidadeDistribuidora->getId() ?>">
                                                    <i class="fas fa-edit fa-1x"></i> Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="confirma-accao" href="<?= base_url() . 'admin/entidadesDistribuidoras/eliminar/' . $EntidadeDistribuidora->getId() ?>">
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













