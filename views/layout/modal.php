<!DOCTYPE html>
<html lang="<?php echo ConfigApp::$language; ?>">
    <head>
        <meta charset="utf-8">
        <title><?php echo isset($layout_title)?$layout_title:''; ?> ADMIN - Univers-Passion</title>
        <link rel="stylesheet" href="https://rawgit.com/alsacreations/KNACSS/master/css/knacss-unminified.css" media="all">
        <link rel="stylesheet" href="<?php echo Router::base_url('assets/css/editor.min.css') ?>">
        <!-- Plugins editor CSS -->
        <link rel="stylesheet" href="<?php echo Router::base_url('assets/js/editor/plugins/colors/ui/trumbowyg.colors.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo Router::base_url('assets/js/editor/plugins/emoji/ui/trumbowyg.emoji.min.css'); ?>">
        <style media="screen">
            .sand-color {
                background-color: #B7A176;
            }
            .sand-lite-color {
                background-color: #D1C4A9;
            }
            .gray-900 {
                background-color: #212529;
                color: #e7e9ed;
            }
            .main-page {
                margin: 15px;
                color: #5F553D;
            }
            .header {
                background-image: url('assets/img/website/banner.png');
                width: 100%;
                height: 250px;
                border-bottom: 1px solid grey;
            }
            .bordered-grey {
                border: 1px solid grey;
            }
            .footer {

            }
            .footer-child {
                margin: 15px;
            }
            .subheader {
                height: 50px;
                border-bottom: 1px solid grey;
                background-color: #0033;
            }
            .navigation ul {
                  margin:0;
                  padding: 0;
                  list-style: none;
            }
            .navigation li {
                  display: inline-block;
                  padding: 1rem;
            }

            @media (max-width: 320px) {
                .navigation li {
                    display: block;
                }
            }

            a.light {
                color: #fff;
                text-decoration: none;
            }
            a.light:hover{
                color: #F75151;
            }

            .spacing-5 {
                margin: 5px;
            }

            .padding-5 {
                padding: 5px;
            }
            .alert--info {
                border: 1px solid #0275D8;
            }
            .alert--primary {
                border: 1px solid #014884;
            }
            .alert--success {
                border: 1px solid #197619;
            }
        </style>
    </head>
    <body class="gray-900">
        <section>
            <?php echo $this->Sessions->flash(); ?>
            <?php echo $output ?>
        </section>
    </body>
</html>
