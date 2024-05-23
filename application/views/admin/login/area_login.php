<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title><?= lang('partilhado.seo.title') ?></title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?= base_url() . '/ficheiros/css/foundation.min.css' ?>">
        <link rel="stylesheet" href="<?= base_url() . '/ficheiros/css/app.css' ?>">
        <link rel="stylesheet" href="<?= base_url() . '/ficheiros/css/base_admin.css' ?>">
        <link rel="stylesheet" href="<?= base_url() . '/ficheiros/plugins/fontawesome/css/all.css' ?>">
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
        <?
        $this->load->helper('gera_password.php');
        $this->load->library('form_validation');
        ?>
        <!-- Magnific Popup core CSS file -->
        <link rel="stylesheet" href="<?= base_url() . '/ficheiros/css/magnific-popup/magnific-popup.css' ?>">

        <!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
    </head>
    <body>
        <?
        $images = [
            1 => "aaron-burden-cEukkv42O40-unsplash.jpg",
            2 => "adam-kool-ndN00KmbJ1c-unsplash.jpg",
            3 => "bruno-soares-NKbfh8Ro_Bw-unsplash.jpg",
            4 => "frank-mckenna-OD9EOzfSOh0-unsplash.jpg",
            5 => "hermansyah-7uXn7nudorc-unsplash.jpg",
            6 => "israel-oliveira-4tPhzZY5Kzk-unsplash.jpg",
            7 => "luca-bravo-VowIFDxogG4-unsplash.jpg",
            8 => "luis-fernando-felipe-alves-dVBs3hKQrNo-unsplash.jpg",
            9 => "maico-pereira-5drSp70oRmY-unsplash.jpg",
            10 => "nick-perez-duvq92-VCZ4-unsplash.jpg",
            11 => "niko-photos-tGTVxeOr_Rs-unsplash.jpg",
            12 => "paulo-henrique-k9ktFE2vvyQ-unsplash.jpg",
            13 => "paulo-henrique-MohWtJlXtOU-unsplash.jpg",
            14 => "robert-lukeman-_RBcxo9AU-U-unsplash.jpg",
            15 => "sean-oulashin-KMn4VEeEPR8-unsplash.jpg",
            16 => "wolf-schram-FEBket79y9c-unsplash.jpg",
        ];
        $the_image = base_url() . 'ficheiros/imagens/base/fundos_admin/' . $images[rand(1, 16)];
        ?>
        <div id="Area-Login" style="background-image: url(<?= $the_image ?>)">
            <div class="grid-x align-center text-cente">
                <div class="xlarge-3 large-4 medium-8 small-10 cell titulo-wrapper">
                    <div class="titulo-border">
                        <h1>FomeZer0</h1>
                        <h3><?= lang("admin.titulo.login"); ?></h3>
                    </div>
                </div>
            </div>
            <?
            $this->load->model('login');
            if ($this->session->userdata('login_efetuado') == true) {
                ?>
                <meta http-equiv="refresh" content="0.1; <?= base_url() ?>home_admin">
            <? } ?>
            <div class="grid-x align-center text-center align-self-middle">
                <div class="large-4 medium-8 small-10 cell form-login-wrapper">
                    <div class="titulo-login">
                        <h3><i class="fas fa-sign-in-alt"></i> Login</h3></div>
                    <form class="form-login" action="<?= base_url() ?>admin/login" method="POST" autocomplete="true">
                        <div style="margin-bottom: -10px;">
                            <? if (isset($erro) && $erro == true) { ?>
                                <div class="error-box margin-bottom-25">
                                    A conta indicada não existe. <br>Por favor introduza uma conta diferente.
                                </div>
                            <? } else if (isset($erro) && $erro == false) { ?>
                                <div class="success-box margin-bottom-25">
                                    Login efectuado com sucesso!
                                </div>
                            <? } ?>
                            <input type="text" name="Username"/>
                            <?= form_error() ? form_error('Username', '<div class="error">', '</div>') : ""; ?>
                            <input type="password" name="Password"/>
                            <?= form_error() ? form_error('Password', '<div class="error">', '</div>') : ""; ?>
                        </div>
                        <div class="text-left padding-bottom-20">
                            <a href="#popup-reset-password" class="open-popup-reset-password">Reset password</a>
                        </div>
                        <button class="bottom btn-style" type="submit">Login</button>
                    </form>
                </div>
                <p class="margin-top-15 margin-bottom-100 color-white" style="width: 100%; font-size: 12px;"><?= date("Y") ?> - power by André Carvalho & Miguel Pinto </p>
            </div>
            <div id="popup-reset-password" class="white-popup parent-container" style="display:none">
                <div class="titulo-popup">
                    <h3><?= lang("admin.login.reset_password.titulo") ?></h3>
                </div>
                <div class="popup-wrapper">
                    <form id="Form-reset-password" class="form-login" action="<?= base_url() ?>resetPassword" method="POST" style="position: relative;">
                        <div id="loading-wrapper">
                            <div id="loading"></div>
                        </div>
                        <div class="grid-x align-center text-center align-self-middle">
                            <div class="large-12 medium-12 small-12 cell text-center">
                                <p><?= lang("admin.login.reset_password.texto") ?></p>
                                <div class="input-group">
                                    <span class="input-group-label"><i class="fas fa-user"></i></span>
                                    <input class="input-group-field input-icon" type="text" id="UsernameResetPassword" name="UsernameResetPassword"/>
                                    <?= form_error() ? form_error('UsernameResetPassword', '<div class="error">', '</div>') : ""; ?>
                                </div>
                            </div>
                        </div>
                        <div class="grid-x align-center text-center align-self-middle">
                            <div class="large-12 medium-12 small-12 cell text-center margin-bottom-10">
                                <button class="bottom btn-style" id="btn-reset-password" type="submit"><?= lang("admin.login.reset_password.botao") ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </body>
    <!--<script type = "text/javascript" src = "<?= base_url() . '/ficheiros/plugins/DataTables/datatables.min.js' . "?" . config_item('gestao.assets_version'); ?>" ></script>-->
    <!--<script src="<?= base_url() . '/ficheiros/plugins/tinymce/js/tinymce.min.js' . "?" . config_item('gestao.assets_version'); ?>"></script>-->
    <script src="<?= base_url() . "/ficheiros/js/vendor/jquery.min.js" ?>"></script>
    <script src="<?= base_url() . "/ficheiros/js/vendor/what-input.js" ?>"></script>
    <script src="<?= base_url() . "/ficheiros/js/vendor/foundation.js" ?>"></script>
    <!-- Magnific Popup core JS file -->
    <script src="<?= base_url() . '/ficheiros/js/magnific-popup/jquery.magnific-popup.js' ?>"></script>
    <!--<script src="./ficheiros/js/base_admin.js"></script>-->

</html>