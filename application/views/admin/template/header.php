<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title><?= lang('partilhado.seo.title') ?></title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Andre Carvalho - andre_98carvalho@hotmail.com"/>
        <meta name="robots" content="noindex">

        <? //FAVICON?>
        <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url() . '/ficheiros/imagens/base/favicon' ?>/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url() . '/ficheiros/imagens/base/favicon' ?>/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url() . '/ficheiros/imagens/base/favicon' ?>/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() . '/ficheiros/imagens/base/favicon' ?>/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url() . '/ficheiros/imagens/base/favicon' ?>/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() . '/ficheiros/imagens/base/favicon' ?>/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url() . '/ficheiros/imagens/base/favicon' ?>/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() . '/ficheiros/imagens/base/favicon' ?>/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() . '/ficheiros/imagens/base/favicon' ?>/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url() . '/ficheiros/imagens/base/favicon' ?>/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() . '/ficheiros/imagens/base/favicon' ?>/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url() . '/ficheiros/imagens/base/favicon' ?>/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() . '/ficheiros/imagens/base/favicon' ?>/favicon-16x16.png">

        <!--        <link rel="stylesheet" href="--><?php //= base_url() . '/ficheiros/css/foundation.min.css' . "?" . CACHE ?><!--">-->
        <link rel="stylesheet" href="<?= base_url() . '/ficheiros/css/app.css' . "?" . CACHE ?>">
        <link rel="stylesheet" href="<?= base_url() . '/ficheiros/plugins/fontawesome/css/all.css' . "?" . CACHE ?>">
        <link rel="stylesheet" href="<?= base_url() . '/ficheiros/plugins/fontawesome/css/fontawesome.min.css' . "?" . CACHE ?>">
        <link rel="stylesheet" href="<?= base_url() . '/ficheiros/plugins/fontawesome/css/brands.min.css' . "?" . CACHE ?>">
        <link rel="stylesheet" type="text/css" href="<?= base_url() . '/ficheiros/plugins/DataTables/datatables.min.css' . "?" . CACHE ?>"/>
        <link rel="stylesheet" href="<?= base_url() . '/ficheiros/css/admin/notie.min.css' . "?" . CACHE ?>">
        <link rel="stylesheet" href="<?= base_url() . '/ficheiros/css/base_admin.css' . "?" . CACHE ?>">


        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
        <? $this->load->helper('gera_password.php'); ?>
        <? $this->load->helper('text_helper.php'); ?>
        <!-- Magnific Popup core CSS file -->
        <link rel="stylesheet" href="<?= base_url() . '/ficheiros/css/magnific-popup/magnific-popup.css' ?>">
        <link rel="stylesheet" href="<?= base_url() . '/ficheiros/css/admin/select2.min.css' ?>">
        <script src="<?= base_url() . '/ficheiros/js/vendor/jquery.min.js' ?>"></script>

        <!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
    </head>

    <body>

        <div class="loading loading-active">
            <div class="loading-wrapper">
                <img class="logo" src="<?= base_url() ?>/ficheiros/imagens/base/logo-redondo.png">
            </div>
        </div>
        <?
        if (!isset($menu) != false) {
        //if($menu != FALSE){
        ?>

        <header id="topbar">
            <div class="topbar__wrapper-logo">
                <a href="<?= base_url() . "admin/home_admin" ?>">
                    <img src="<?= base_url() ?>/ficheiros/imagens/base/logo.svg" id="logo">
                    <img class="hide" src="<?= base_url() ?>/ficheiros/imagens/base/icon.svg" id="icon">
                    <!--                    <span class="open-menu-btn"><span></span></span>-->
                </a>
            </div>
            <div class="topbar__wrapper-account">
                <span class="open-menu-btn"><span></span></span>
                <div class="topbar__wrapper-account__inner-wrapper">
                    <div class="topbar__wrapper-account__inner-wrapper__foto">
                        <a href="javascript:;">
                            <? if (empty($this->session->userdata('Foto'))) { ?>
                                <img width="50" class="menu-img-user" src="<?= base_url() . $this->session->userdata('Foto') ?>" alt=""><? } else {
                                ?>
                                <img width="50" class="menu-img-user" src="<?= base_url() ?>/ficheiros/imagens/base/default-user.png" alt="">
                            <? } ?>

                        </a>
                    </div>


                    <div class="dropdown-container">
                        <input class="dropdown" type="checkbox" id="dropdown" name="dropdown"/>
                        <label class="for-dropdown" for="dropdown">Dropdown Menu <i class="uil uil-arrow-down"></i></label>
                        <div class="section-dropdown">
                            <label class="for-dropdown-sub" for="dropdown-sub"><?= $this->session->userdata('Nome') ?></label>
                            <div><a href="<?= base_url() . "admin/editar-utilizador/" . $this->session->userdata('Id') ?>">Editar Conta</a></div>
                            <div><a href="<?= base_url() . "admin/logout" ?>"><i class="fa fa-power-off"></i> Logout</a></div>
                        </div>
                    </div>

                </div>
            </div>
        </header>
        <div class="wrapper-main">
            <div id="sidebar">
                <ul class="vertical medium-horizontal dropdown menu" data-responsive-menu="accordion medium-dropdown">
                    <li>
                        <a href="<?= base_url() . "admin/utilizadores" ?>">Utilizadores</a>
                        <ul class="menu vertical">
                            <?
                            $this->load->model('login');
                            if ($this->session->userdata('login_efetuado') == true && $this->session->userdata('TipoUtilizador') == Login::ADMIN) {
                            }
                            ?>
                            <li><a href="<?= base_url() . "admin/utilizadores/adicionar" ?>">Novo Utilizador</a></li>
                            <li><a href="<?= base_url() . "admin/utilizadores" ?>">Listar Utilizadores</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= base_url() . "admin/projetos" ?>">Projetos</a>
                        <ul class="menu vertical">
                            <li><a href="<?= base_url() . "admin/adiciona-projeto" ?>">Adicionar</a></li>
                            <li><a href="<?= base_url() . "admin/projetos" ?>">Listar</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= base_url() . "admin/projetos-categorias" ?>">Projetos > Categorias</a>
                        <ul class="menu vertical">
                            <li><a href="<?= base_url() . "admin/adiciona-projeto-categoria" ?>">Adicionar</a></li>
                            <li><a href="<?= base_url() . "admin/projetos-categorias" ?>">Listar</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;">Gestão</a>
                        <ul class="menu vertical">
                            <li><a id="backup-bd" href="<?= base_url() . "admin/backup-bd" ?>">Backup BD</a></li>
                            <li><a id="gera-sitemap" href="<?= base_url() . "admin/gera-sitemap" ?>">Gera SiteMap</a></li>
                            <li><a href="<?= base_url() . "admin/logs" ?>">Logs</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div id="content">
                <div class="content-wrapper">
                    <div class="content__inner-wrapper">
                        <? } ?>

