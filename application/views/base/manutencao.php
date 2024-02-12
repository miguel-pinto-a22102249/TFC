<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="utf-8">
        <title><?= !isset($Seo["SeoTitle"]) ? lang('partilhado.seo.title') : $Seo["SeoTitle"] ?></title>
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Andre Carvalho - andre_98carvalho@hotmail.com" />
        <meta name="keywords" content="Escola, Condução, Aulas, carros"/>
        <meta name="rating" content="General" />
        <meta name="revisit-after" content="7 days" />
        <meta name="robots" content="index, follow" />
        <meta name="referrer" content="strict-origin" />
        <link rel="canonical" href="<?= base_url() ?>" />

        <? //FAVICON?>
        <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url() . 'ficheiros/imagens/base/favicon' ?>/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url() . 'ficheiros/imagens/base/favicon' ?>/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url() . 'ficheiros/imagens/base/favicon' ?>/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() . 'ficheiros/imagens/base/favicon' ?>/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url() . 'ficheiros/imagens/base/favicon' ?>/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() . 'ficheiros/imagens/base/favicon' ?>/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url() . 'ficheiros/imagens/base/favicon' ?>/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() . 'ficheiros/imagens/base/favicon' ?>/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() . 'ficheiros/imagens/base/favicon' ?>/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?= base_url() . '/ficheiros/imagens/base/favicon' ?>/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() . 'ficheiros/imagens/base/favicon' ?>/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url() . 'ficheiros/imagens/base/favicon' ?>/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() . 'ficheiros/imagens/base/favicon' ?>/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <? //****************************?>

        <!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
    </head>

    <body style="margin:0px;">
        <h1 style="display:none"><?= !isset($Seo["SeoTitle"]) ? lang('partilhado.seo.title') : $Seo["SeoTitle"] ?></h1>
        <div class="barras" style="margin-bottom:30px;">
            <h2 style="color:white; margin:0px;text-align: center">O nosso compromisso é ajudar no teu futuro...</h2>
        </div>
        <div class="wrapper">
            <div style="text-align: center; max-height: 100%;color:white; z-index: 6;">
                <img style="max-width: 100%" alt="Logo - Escola de Condução de Pero Pinheiro " src="<?= base_url() . 'ficheiros/imagens/base/' ?>logo.png">
                <h2 style="text-align: center">Estamos a preparar novidades,<br>
                    o novo Ano será de renovação e novos desafios.<br>
                    Até breve!
                </h2>
                <p>
                    <b>Telefone:</b> <a style="color:white" href="tel:+351219271904">+351 21 927 1904 </a><br>
                    <b>Email:</b> <a style="color:white" href="mailto:info@ecpp.pt">info@ecpp.pt </a><br>
                    <br>
                </p>
                <p>
                    <b>Morada:</b> Av. Manuel Simões Carrasqueira 64 <br>
                    2715-099 Pêro Pinheiro <br>
                    <br>
                    De segunda-feira a sexta-feira das 09:30 até às 19:30 <br>
                    Sábado e domingo Encerrado <br>

                </p>
            </div>
        </div>
        <div class="barras" style="margin-top:30px">
            <p style="color: white">2019 © Escola De Condução Pero Pinheiro, Lda. Todos os direitos reservados</p>
        </div>

        <div class="layer"></div>
    </body>

    <style>

        body{
            font-family: Arial, Helvetica, sans-serif;
            min-height: 100vh;
            background-size: cover;
            background-position: center;
            background-image: url(<?= base_url() . 'ficheiros/imagens/base/' ?>roadtrips_social.jpg);
            line-height: 1.2;
            position: relative;
        }
        .layer{
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: black;
            opacity: 0.4;
            z-index: 1;
        }
        h1,h2,p,a{
            z-index: 3;
        }
        .wrapper{
            z-index: 3;
            min-height: calc(100vh - 200px);
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            padding: 0px 20px;
        }
        .barras{
            position: relative;
            z-index: 3;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            padding:0px  10px;
            text-align: center;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            width: 100%; 
            min-height: 70px;
            background-color: #1D436F;
            -webkit-box-shadow: 0px 3px 20px 11px rgba(0,0,0,0.09);
            box-shadow: 0px 3px 20px 11px rgba(0,0,0,0.09);
        }
        @media screen and (max-width: 600px) {
            .barras{
                z-index: 3;
                padding: 25px  15px;
            }
        }
    </style>

</html>