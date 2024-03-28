<div id="Area-Novo-Utilizador">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="/admin/utilizadores/adicionar" method="POST" class="form-ajax" enctype="multipart/form-data">
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Nome">Nome</label>
                            <input type="text" name="Nome" placeholder="Nome"/>
                        </div>
                    </div>
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Username">Nome</label>
                            <input type="text" name="Username" placeholder="Username"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="column large-12 medium-12 small-12">
                        <div class="input-group">
                            <label for="Email">Email</label>
                            <input type="text" name="Email" placeholder="Email"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Password">Password</label>
                            <input type="password" id="Password" name="Password" placeholder="Password"/>
                        </div>
                    </div>
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Password">Confirmação de Password</label>
                            <input type="password" id="ConfirmPassword" name="ConfirmPassword" placeholder="Confirm Password"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column large-6 medium-6 small-12 input-group">
                        <div class="input-group">
                            <label>Tipo Utilizador
                                <select name="TipoUtilizador">
                                    <option value="<?= Login::ADMIN ?>">Admin</option>
                                    <option value="<?= Login::UTILIZADOR ?>">Utilizador</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="column large-6 medium-6 small-12 input-group">
                        <div class="input-group">
                            <label>Estado
                                <select name="Estado">
                                    <option value="<?= Login::ESTADO_ATIVO ?>">Ativo</option>
                                    <option value="<?= Login::ESTADO_INATIVO ?>">Inativo</option>
                                </select>
                            </label>
                        </div>
                    </div>

                    <div class="column large-12 medium-12 small-12 input-group">
                        <div class="input-group">
                            <!--                            <label for="FotoUpload" class="button"><i class="far fa-file-image fa-2x"></i>Upload File</label>-->
                            <input type="file" id="FotoUpload" name="Foto" class="show-for-sr">
                        </div>
                    </div>
                </div>
                <button class="bottom btn-style" type="submit">Cria</button>
            </form>
        </div>
    </div>
</div>
