<?php
$escaloes ??= [];

if (count($escaloes) > 0) {
    ?>

    <div id="Area-lista-Utilizadores">
        <div id="Lista-Logins">
            <div class="grid-x align-center align-self-middle">
                <div class="large-12 medium-12 small-12 cell">
                    <h2 class="text-center">Utilizadores</h2>
                    <table class="dataTable display responsive" style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">Designação</th>
                            <th class="text-center defaultSort">Idade Inicial</th>
                            <th class="text-center">Idade Limite</th>
                            <th class="th-opcoes"><i class="fas fa-cog fa-2x"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($escaloes as $escalao) { ?>
                            <tr class="tr-accordion">
                                <td class="trigger">
                                    <a style="text-decoration:none" href="admin/utilizador/consultar/<?= $escalao->Segmento ?>">
                                        <?= $escalao->getDesignacao(); ?>
                                    </a>
                                </td>
                                <td>
                                    <?= $escalao->getIdadeInicial(); ?>
                                </td>
                                <td>
                                    <?= $escalao->getIdadeFinal(); ?>
                                </td>
                                <td class="td-opcoes">
                                    <ul class="dropdown menu" data-dropdown-menu>
                                        <li>
                                            <a class="text-right" href="javascript:;"><i class="fas fa-2x fa-cog"></i></a>
                                            <ul class="menu text-left">
                                                <li>
                                                    <a style="text-decoration:none" href="<?= base_url() . 'admin/projetos/consultar/' . $escalao->Segmento ?>">
                                                        <i class="fas fa-search-plus fa-1x"></i> Consultar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="Editar" href="<?= base_url() . 'admin/editar-projeto/' . $escalao->getId() ?>">
                                                        <i class="fas fa-edit fa-1x"></i> Ediar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="Eliminar" href="<?= base_url() . 'admin/eliminar-projeto/' . $escalao->getId() ?>">
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
    </div>

    <script>
    // <editor-fold defaultstate="collapsed" desc="PopUp Confirmação de eliminação">

    $('.Eliminar').on("click", function(eve) {
        eve.preventDefault();
        notie.confirm({
            text: 'Tem acerteza que quer eliminar este utilizador?<br>Esta acção não pode ser revertida!',
            submitText: 'Sim',
            cancelText: 'Não'
        }, function() {
            $.ajax({//request ajax
                url: $('.Eliminar').attr('href'),
                dataType: "json",
                success: function(response) {
                    if (response.Sucesso == true) {
                        notie.alert({type: 1, text: response.Mensagem})
                    } else {
                        notie.alert({type: 3, text: response.Mensagem})
                    }
                },
                error: function() {
                    notie.alert({type: 3, text: "Erro", stay: true})
                }
            });
        })

    });
    // </editor-fold>
</script>
<? } ?>













