<?php

if (count($Produtos) > 0) {
    $this->load->model('Entidade_Distribuidora');

    $EntidadesDistribuidoras = (new Entidade_Distribuidora())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);

    ?>
    <div id="Area-Lista-Escaloes" class="area-listagem">
        <div class="row">
            <div class="columns large-12">

                <table class="dataTable display responsive">
                    <thead>
                    <tr>
                        <th class="text-center">Nome</th>
                        <th class="text-center">Entidade Distribuidora</th>
                        <th class="text-center">Categoria</th>
                        <th class="text-center">Detalhes</th>
                        <th class="text-center defaultSort">Stock Atual</th>
                        <th class="text-center">Estado</th>
                        <th class="th-opcoes" data-orderable='false'></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?

                    foreach ($Produtos as $produto) {
                        ?>
                        <tr class="tr-accordion">
                            <td class="text-center">
                                <?= $produto->getNome(); ?>
                            </td>
                            <td class="text-center">
                                <?
                                if ($produto->getIdEntidadeDistribuidora() != null) {
                                    echo $EntidadesDistribuidoras[$produto->getIdEntidadeDistribuidora()]->getNome();
                                } ?>
                            </td>
                            <td class="text-center">
                                <?= $produto->getDesignacaoCategoria(); ?>
                            </td>
                            <td class="text-center">
                                <?= $produto->getDetalhes(); ?>
                            </td>
                            <td class="text-center">
                                <?= $produto->getStockAtual(); ?>
                            </td>
                            <td class="text-center">
                                <?= $produto->getDesignacaoEstado(); ?>
                            </td>
                            <td class="td-opcoes">
                                <ul class="dropdown menu" data-dropdown-menu>
                                    <li>
                                        <a class="text-right" href="javascript:;"><i class="fas fa-2x fa-cog"></i></a>
                                        <ul class="menu text-left">
                                            <li>
                                                <a class="btn-consultar-popup-ajax" style="text-decoration:none" href="<?= base_url() . 'admin/produtos/consultar/' . $produto->getId() ?>">
                                                    <i class="fas fa-search-plus fa-1x"></i> Consultar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="Editar btn-editar-popup-ajax" href="<?= base_url() . 'admin/produtos/viewEditar/' . $produto->Id ?>">
                                                    <i class="fas fa-edit fa-1x"></i> Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="confirma-accao" href="<?= base_url() . 'admin/produtos/eliminar/' . $produto->Id ?>">
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













