<?php
$this->load->model('Entidade_Distribuidora');

if (count($Agregados) > 0) {
    ?>
    <div id="Area-Lista-Escaloes" class="area-listagem">
        <div class="row">
            <div class="columns large-12">
                <table class="dataTable display responsive">
                    <thead>
                    <tr>
                        <th class="text-center">NISS Constituinte Principal</th>
                        <th class="text-center defaultSort">Entidade Distribuidora</th>
                        <th class="text-center defaultSort">Grupo</th>
                        <th class="text-center">Estado</th>
                        <th class="th-opcoes" data-orderable='false'></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?

                    foreach ($Agregados as $agregado) { ?>
                        <tr class="tr-accordion">
                            <td class="trigger">
                                <a style="text-decoration:none" href="admin/agregado/consultar/<?= $agregado->getSegmento() ?>">
                                    <? if ($this->session->userdata('ModoPrivacidade') == false) { ?>
                                        xxx xxx <?= substr($agregado->getNissConstituintePrincipal(), 6, 9); ?>
                                        <?
                                    } else {
                                        echo $agregado->getNissConstituintePrincipal();
                                    } ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <?
                                $IdsEntidadesDistribuidoras = json_decode($agregado->getIdsEntidadesDistribuidoras());
                                //                                var_dump($IdsEntidadesDistribuidoras);
                                if ($IdsEntidadesDistribuidoras != null) {
                                    $EntidadesDistribuidoras = (new Entidade_Distribuidora())->obtemElementos(null, ['Estado' => ESTADO_ATIVO]);
                                    if (is_array($IdsEntidadesDistribuidoras)) {
                                        $entidades = '';
                                        foreach ($EntidadesDistribuidoras as $EntidadeDistribuidora) {
                                            if (in_array($EntidadeDistribuidora->getId(), $IdsEntidadesDistribuidoras)) {
                                                $entidades .= $EntidadeDistribuidora->getNome() . ', ';
                                            }
                                        }
                                        echo substr($entidades, 0, -2);
                                    } else {
                                        echo $EntidadesDistribuidoras[$IdsEntidadesDistribuidoras]->getNome();
                                    }
                                }
                                ?>
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
                                                <a class="btn-consultar-popup-ajax" style="text-decoration:none" href="<?= base_url() . 'admin/agregados/consultarAgregado/' . $agregado->getId() ?>">
                                                    <i class="fas fa-search-plus fa-1x"></i> Consultar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="Editar btn-editar-popup-ajax" href="<?= base_url() . 'admin/agregados/viewEditarAgregado/' . $agregado->getId() ?>">
                                                    <i class="fas fa-edit fa-1x"></i> Editar
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













