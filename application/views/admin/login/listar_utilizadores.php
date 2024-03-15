<div id="Area-lista-Utilizadores" class="area-listagem">
    <div id="Lista-Logins">
        <div class="row">
            <div class="column large-12">
                <table class="dataTable display responsive" style="width:100%">
                    <thead>
                    <tr>
                        <th class="text-center">Nome</th>
                        <th class="text-center defaultSort">Username</th>
                        <th class="text-center">Tipo de Utilizador</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Foto</th>
                        <th class="th-opcoes"><i class="fas fa-cog fa-2x"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?

                    $utilizador = new Login();

                    foreach ($Utilizadores as $utilizador) {
                        ?>
                        <tr class="tr-accordion">
                            <td class="trigger">
                                <a style="text-decoration:none" href="admin/utilizador/consultar/<?= $utilizador->getSegmento() ?>">
                                    <?= $utilizador->getNome(); ?>
                                </a>
                            </td>
                            <td>
                                <?= $utilizador->getUsername(); ?>
                            </td>
                            <td class="text-center">
                                <?
                                if ($utilizador->getTipoUtilizador() == Login::ADMIN) {
                                    echo "<label class='label primary'>Administrador</label>";
                                } else if ($utilizador->getTipoUtilizador() == Login::UTILIZADOR) {
                                    echo "<label class='label secondary'>Utilizador</label>";
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <?
                                if ($utilizador->getEstado() == Login::ESTADO_ATIVO) {
                                    echo "<label class='label success'>Ativo</label>";
                                } else if ($utilizador->getEstado() == Login::ESTADO_INATIVO) {
                                    echo "<label class='label aler'>Inativo</label>";
                                }
                                ?>
                            </td>

                            <td class="text-center">

                                <? if (empty($utilizador->getFoto())) { ?>
                                    <img  height="50" width="50" class="blog-home-img" src="<?= base_url() ?>ficheiros/imagens/base/default-user.png" alt=""><? } else {
                                    ?>
                                    <img height="50" width="50"  class="blog-home-img" src="<?= base_url() ?><?php echo $utilizador->getCaminhoFoto() ?>" alt=""><? }
                                ?>
                            </td>
                            <td class="td-opcoes">
                                <ul class="dropdown menu" data-dropdown-menu>
                                    <li>
                                        <a class="text-right" href="javascript:;"><i class="fas fa-2x fa-cog"></i></a>
                                        <ul class="menu text-left">
                                            <li>
                                                <a style="text-decoration:none" href="<?= base_url() . 'admin/utilizadores/consultar/' . $utilizador->Segmento ?>">
                                                    <i class="fas fa-search-plus fa-1x"></i> Consultar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="Editar" href="<?= base_url() . 'admin/utilizadores/editar/' . $utilizador->getId() ?>">
                                                    <i class="fas fa-edit fa-1x"></i> Ediar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="Eliminar" href="<?= base_url() . 'admin/utilizadores/eliminar/' . $utilizador->getId() ?>">
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














