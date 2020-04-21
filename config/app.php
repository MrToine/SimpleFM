<?php
class ConfigApp {
    static $debug = true;
    static $index_page = ""; // Indique la page d'accueil du site web. Si vide la page sera : controllers/IndexController.php
    static $language = "fr";
    static $dir_controllers = "app"; // Par defaut dans '/controllers/'
    static $dir_models = "app"; // Par defaut dans '/models/'
    static $dir_views = "app"; // Par defaut dans '/views/'. ATTENTION ! Le dossier 'views' à la racine du site web contient des dossiers utilisant directement le Moteur donc ne pas supprimé.
}
