<?php
if($this->Sessions->isLogged()) {
    $link_log = "logout";
    $link_profile = "profile/";
    $view_profile = "Espace membre";
}else{
    $link_log = "login";
    $link_profile = "";
    $view_profile = "";
}
?>
<!DOCTYPE html>
<html lang="<?php echo ConfigApp::$language; ?>" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title><?php echo isset($layout_title)?$layout_title:''; ?> Univers-Passion</title>
        <link rel="stylesheet" href="https://rawgit.com/alsacreations/KNACSS/master/css/knacss-unminified.css" media="all">
        <link rel="stylesheet" href="<?php echo Router::base_url('assets/css/editor.min.css') ?>">
        <!-- Plugins editor CSS -->
        <link rel="stylesheet" href="<?php echo Router::base_url('assets/js/editor/plugins/colors/ui/trumbowyg.colors.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo Router::base_url('assets/js/editor/plugins/emoji/ui/trumbowyg.emoji.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo Router::base_url('assets/css/generic.css') ?>">
    </head>
    <body class="gray-900">
        <section>
            <section class="grid-6 has-gutter sand-color">
                <div></div>
                <div class="col-4 sand-lite-color bordered-grey">
                    <div class="header"></div>
                    <div class="subheader">
                        <nav class="navigation">
                              <ul>
                                <li><a href="<?php echo Router::url(''); ?>">Accueil</a></li>
                                <li>Forum</li>
                                <li><a href="<?php echo Router::url('users/'.$link_log); ?>"><?php echo ($this->Sessions->isLogged())?'Déconnexion':'Connexion/Inscription'; ?></a></li>
                                <li><a href="<?php echo Router::url('users/'.$link_profile); ?>"><?php echo $view_profile ?></a></li>
                                <?php
                                if($this->Sessions->isLogged()){
                                    if($this->Sessions->user('role') == "admin") {
                                        echo '<li><a href="'.Router::url('admin/home').'">Panel Admin</a></li>';
                                    }
                                }
                                ?>
                              </ul>
                            </nav>
                    </div>
                    <div class="main-page">
                        <?php echo $this->Sessions->flash(); ?>
                        <?php echo $output; ?>
                    </div>
                </div>
                <div></div>
                <div class="col-6 gray-900 footer">
                    <div class="grid-4 has-gutter">
                        <div class="footer-child"v>
                            <h5>Liens utiles</h5>
                            <ul class="unstyled">
                                <li>lien</li>
                                <li>lien</li>
                                <li>lien</li>
                                <li>lien</li>
                                <li>lien</li>
                                <li>lien</li>
                            </ul>
                        </div>
                        <div class="footer-child">
                            <h5>Le site web</h5>
                            <ul class="unstyled">
                                <li>lien</li>
                                <li>lien</li>
                                <li>lien</li>
                                <li>lien</li>
                            </ul>
                        </div>
                        <div class="footer-child">
                            <h5>HUB</h5>
                            <ul class="unstyled">
                                <li> <a href="<?php echo Router::url('admin/home') ?>">Administrateurs</a> </li>
                                <li>lien</li>
                            </ul>
                        </div>
                        <div class="footer-child">
                            <h5>Partenaires</h5>
                            <ul class="unstyled">
                                <li>lien</li>
                                <li>lien</li>
                                <li>lien</li>
                                <li>lien</li>
                                <li>lien</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </body>
    <!-- Import jQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script type="text/javascript" src="<?php echo Router::base_url('assets/js/editor/trumbowyg.min.js'); ?>"></script>
    <!-- Plugins Editor -->
    <script type="text/javascript" src="<?php echo Router::base_url('assets/js/editor/plugins/colors/trumbowyg.colors.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo Router::base_url('assets/js/editor/plugins/emoji/trumbowyg.emoji.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo Router::base_url('assets/js/editor/plugins/fontsize/trumbowyg.fontsize.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo Router::base_url('assets/js/editor/plugins/mention/trumbowyg.mention.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo Router::base_url('assets/js/editor/plugins/pasteimage/trumbowyg.pasteimage.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo Router::base_url('assets/js/editor/plugins/upload/trumbowyg.upload.min.js'); ?>"></script>
    <!-- Init Trumbowyg -->
    <script>
        // Doing this in a loaded JS file is better, I put this here for simplicity
        $('.wysiwg').trumbowyg({
            btnsDef: {
                upload_p: {
                    fn: function() {
                         window.open("<?php echo Router::url('admin/medias/index/'.$id); ?>", "Upload", "menubar=no, status=no, scrollbars=no, menubar=no, width=500, height=500");
                    },
                    ico: 'upload'
                }
            },
            btns: [
                ['viewHTML'],
                ['emoji'],
                ['strong', 'em', 'del'],
                ['fontsize'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['foreColor', 'backColor'],
                ['upload_p', 'insertImage'],
                //['upload'],
                //['mention'],
                ['link'],
                ['unorderedList', 'orderedList'],
                ['horizontalRule'],
                ['removeformat'],
            ],
            plugins: {
                upload: {
                    serverPath: '',
                    fileFieldName: 'image',
                }
            },
            changeActiveDropdownIcon: true
        });
    </script>
</html>
