<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title><?= lang('partilhado.seo.title') ?></title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="André Carvalho e Miguel Pinto"/>
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
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"/>

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

    <body class="">

        <!--        <div class="loading loading-active">-->
        <!--            <div class="loading-wrapper">-->
        <!--                <img class="logo" src="--><?php //= base_url() ?><!--/ficheiros/imagens/base/logo-redondo.png">-->
        <!--            </div>-->
        <!--        </div>-->
        <?
        $this->load->model('login');
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
                    <?
                    $CI = &get_instance();
                    if ($this->session->userdata('ModoPrivacidade') == false) { ?>
                        <a class="btn-style trigger-modo-privacidade trigger-modo-privacidade--unlock"
                           href="<?= base_url("/admin/utilizadores/desativaModoPrivacidade") ?>">Modo de Privacidade</a>
                    <? } else { ?>
                        <a class="btn-style trigger-modo-privacidade trigger-modo-privacidade--lock"
                           href="<?= base_url("/admin/utilizadores/ativaModoPrivacidade") ?>">Modo de Privacidade</a>
                    <? } ?>

                    <ul class="dropdown menu" data-dropdown-menu>
                        <li>
                            <a class="text-right" href="javascript:;">
                                <div class="topbar__wrapper-account__inner-wrapper__foto">
                                    <?
                                    if (!empty($this->session->userdata('Foto'))) { ?>
                                        <img width="50" class="menu-img-user" src="<?= base_url(CAMINHO_IMAGENS_DINAMICAS . 'fotos_utilizadores') . "/" . $this->session->userdata('Foto') ?>" alt="">
                                        <?
                                    } else {
                                        ?>
                                        <img width="50" class="menu-img-user" src="<?= base_url('/ficheiros/imagens/base/default-user.png') ?>" alt="">
                                    <? } ?>
                                    <label class="for-dropdown-sub" for="dropdown-sub"><?= $this->session->userdata('Nome') ?></label>
                                </div>
                            </a>
                            <ul class="menu text-left">
                                <li>
                                    <a href="<?= base_url() . 'admin/utilizadores/editar/' . $this->session->userdata('Id') ?>">Editar Conta</a>
                                </li>
                                <li>
                                    <a href="<?= base_url() . "admin/logout" ?>"><i class="fa fa-power-off"></i> Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </div>
        </header>
        <div class="wrapper-main">
            <div id="sidebar">
                <a class="sidebar__mobile-close-button"><i class="fas fa-times"></i></a>
                <ul class="vertical medium-horizontal dropdown menu" data-responsive-menu="accordion medium-dropdown">

                    <li>
                        <a href="<?= base_url() . "home_admin" ?>"><i class="fas fa-chart-line"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= base_url() . "admin/utilizadores" ?>"><i class="fas fa-users-cog"></i> Utilizadores</a>
                    </li>

                    <li>
                        <a href="<?= base_url() . "admin/escaloes" ?>"><i class="fas fa-layer-group"></i> Escalões</a>
                    </li>

                    <li>
                        <a class="dropdown-btn"><i class="fas fa-users"></i> Agregados
                        </a>
                        <div class="dropdown-container">
                            <ul class="menu vertical">
                                <? if ($this->session->userdata('login_efetuado') == true && $this->session->userdata('TipoUtilizador') == Login::ADMIN) { ?>
                                    <li><a href="<?= base_url() . "admin/agregados/importacao" ?>"><i class="fas fa-file-excel"></i> Importar</a></li>
                                <? } ?>
                                <li><a href="<?= base_url() . "admin/agregados" ?>"><i class="fas fa-users"></i> Listar Agregados</a></li>
                                <li><a href="<?= base_url() . "admin/agregados/constituintes/listar" ?>"><i class="fas fa-user"></i> Listar Constituintes</a></li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="<?= base_url() . "admin/produtos" ?>"><i class="fas fa-apple-alt"></i> Produtos</a>
                    </li>

                    <li>
                        <a class="dropdown-btn"><i class="fas fa-stream"></i> Distribuições
                        </a>
                        <div class="dropdown-container">
                            <ul class="menu vertical">
                                <? if ($this->session->userdata('login_efetuado') == true && $this->session->userdata('TipoUtilizador') == Login::ADMIN) { ?>
                                    <li><a href="<?= base_url() . "admin/distribuicoes/distribuicaoPasso1" ?>"><i class="fas fa-cubes"></i> Iniciar Distribuição</a></li>
                                <? } ?>

                                <li><a href="<?= base_url() . "admin/distribuicoes/" ?>"><i class="fas fa-calendar"></i> Listar Datas Distribuições</a></li>
                                <!--                                <li><a href="--><?php //= base_url() . "admin/distribuicoes/constituinte" ?><!--"><i class="fas fa-user"></i> Listar Ativas por Constituinte</a></li>-->
                                <!--                                <li><a href="--><?php //= base_url() . "admin/distribuicoes/agregado" ?><!--"><i class="fas fa-users"></i> Listar Ativas por Agregado</a></li>-->
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <div id="content">
                <div class="content-wrapper">
                    <div class="content__inner-wrapper">
                        <div class="content__inner-wrapper__header">
                            <div class="row">
                                <div class="column large-12">
                                    <div class="content__inner-wrapper__header__wrapper">
                                        <div class="content__inner-wrapper__header__wrapper__coluna-titulos">
                                            <h1 class="content__inner-wrapper__header__wrapper__titulo"><?= isset($tituloArea) ? $tituloArea : 'Titulo Área Por definir' ?></h1>
                                            <h2 class="content__inner-wrapper__header__wrapper__subtitulo"><?= isset($subtituloArea) ? $subtituloArea : 'Subtitulo Área Por definir' ?></h2>
                                        </div>
                                        <div class="content__inner-wrapper__header__wrapper__coluna-acoes">
                                            <?
                                            if (isset($acoes)) {
                                                foreach ($acoes as $acao) {
                                                    ?>
                                                    <a href="<?= $acao['link'] ?>" class="button <?= $acao['class'] ?>"><i class="<?= $acao['icone'] ?>"></i><?= $acao['titulo'] ?></a>
                                                    <?
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <? } ?>

