<div id="Area-Novo-Utilizador">
    <div class="row">
        <div class="column large-8 medium-8 small-10 form-login-wrapper">
            <form action="/admin/utilizadores/adicionar" method="POST" class="form-ajax" enctype="multipart/form-data">
                <div class="row">
                    <div class="column large-12">
                        <h2 class="titulo-form">Novo Utilizador</h2>
                    </div>
                </div>
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
                    <!--                    <div class="column large-2 medium-2 small-2">-->
                    <!--                        <a href="#test-popup" class="open-popup-link"><i class="fas fa-key fa-2x"></i></a>
                                    </div>-->
                </div>

                <div class="row">
                    <div class="column large-4 medium-6 small-12">
                        <div class="input-group">
                            <label>Tipo Utilizador
                                <select name="TipoUtilizador">
                                    <option value="<?= Login::ADMIN ?>">Admin</option>
                                    <option value="<?= Login::UTILIZADOR ?>">Utilizador</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="column large-4 medium-6 small-12">
                        <div class="input-group">
                            <label>Estado
                                <select name="Estado">
                                    <option value="<?= Login::ESTADO_ATIVO ?>">Ativo</option>
                                    <option value="<?= Login::ESTADO_INATIVO ?>">Inativo</option>
                                </select>
                            </label>
                        </div>
                    </div>

                    <div class="column large-4 medium-6 small-12">
                        <div class="input-group">
                            <label for="FotoUpload" class="button"><i class="far fa-file-image fa-2x"></i>Upload File</label>
                            <input type="file" id="FotoUpload" name="Foto" class="show-for-sr" hidden="">
                        </div>
                    </div>
                </div>

                <button class="bottom btn-style" type="submit">Cria</button>
            </form>
        </div>
    </div>
</div>

<div id="test-popup" class="white-popup mfp-hide">
    <div class="grid-x">
        <div class="column large-12 medium-12 small-12">
            <h3>Gerador de Password</h3>
            <div class="grid-x">
                <div class="column large-5 medium-5 small-12">
                    <label>Tamanho da Password:</label><input type="number" id="length" max="20" required/>
                </div>
                <div class="column large-1 medium-1 small-12"></div>
                <div class="column large-6 medium-6 small-12">
                    <fieldset class="large-7 cell" id="Opcoes">
                        <legend>Opções</legend>
                        <input name="minusculas" id="checkbox1" type="checkbox"><label for="checkbox1">abcdef...</label>
                        <input name="maiusculas" id="checkbox2" type="checkbox"><label for="checkbox2">BCDEFG...</label><br>
                        <input name="numeros" id="checkbox3" type="checkbox"><label for="checkbox3">234567...</label>
                        <input name="simbolos" id="checkbox4" type="checkbox"><label for="checkbox4">!@#$%&...</label>
                    </fieldset>

                </div>
            </div>
            <button class="bottom" id="GeraPassword">Gerar</button>
            <?= generateStrongPassword(12, false, 'lus'); ?>
        </div>
    </div>
</div>




