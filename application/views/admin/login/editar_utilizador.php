<?
$Utilizador ??= null;
?>

<div id="Area-Editar-Utilizador">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="<?= base_url("/admin/utilizadores/editar/" . $Utilizador->getId()) ?>" method="POST" class="form-ajax" enctype="multipart/form-data">
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Nome">Nome</label>
                            <input type="text" name="Nome" placeholder="Nome" value="<?= $Utilizador->getNome() ?>"/>
                        </div>
                    </div>
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Username">Username</label>
                            <input type="text" name="Username" placeholder="Username" value="<?= $Utilizador->getUsername() ?>"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="column large-12 medium-12 small-12">
                        <div class="input-group">
                            <label for="Email">Email</label>
                            <input type="text" name="Email" placeholder="Email" value="<?= $Utilizador->getEmail() ?>"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <div class="flex justify-content-center flex-align-center">
                                <input type="checkbox" id="NovaPassword" name="NovaPassword" class="margin-bottom-0"/>
                                <label for="NovaPassword" class="margin-bottom-0">Alterar Password</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Password">Password</label>
                            <input type="password" id="Password" name="Password" placeholder="Password" disabled/>
                        </div>
                    </div>
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Password">Confirmação de Password</label>
                            <input type="password" id="ConfirmPassword" name="ConfirmPassword" placeholder="Confirm Password" disabled/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column large-6 medium-6 small-12 input-group">
                        <div class="input-group">
                            <label>Tipo Utilizador
                                <select name="TipoUtilizador">
                                    <option value="<?= Login::ADMIN ?>" <?= $Utilizador->getTipoUtilizador() == Login::ADMIN ? 'selected' : '' ?>>Admin</option>
                                    <option value="<?= Login::UTILIZADOR ?>" <?= $Utilizador->getTipoUtilizador() == Login::UTILIZADOR ? 'selected' : '' ?>>Utilizador</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="column large-6 medium-6 small-12 input-group">
                        <div class="input-group">
                            <label>Estado
                                <select name="Estado">
                                    <option value="<?= Login::ESTADO_ATIVO ?>" <?= $Utilizador->getNome() == Login::ESTADO_ATIVO ? 'selected' : '' ?>>Ativo</option>
                                    <option value="<?= Login::ESTADO_INATIVO ?>" <?= $Utilizador->getNome() == Login::ESTADO_INATIVO ? 'selected' : '' ?>>Inativo</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="column large-12 medium-12 small-12 input-group">
                        <div class="input-group">
                            <label for="Foto">Imagem de Perfil</label>
                            <input type="file" id="Foto" name="Foto" value="<?= $Utilizador->getFoto() ?>">
                        </div>
                    </div>
                </div>
                <button class="bottom btn-style" type="submit">Grava</button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#NovaPassword').change(function() {
            if ($(this).is(':checked')) {
                $('#Password').prop('disabled', false);
                $('#ConfirmPassword').prop('disabled', false);
            } else {
                $('#Password').prop('disabled', true);
                $('#ConfirmPassword').prop('disabled', true);
            }
        });
    });
</script>
