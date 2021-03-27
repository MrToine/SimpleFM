<?php
/**
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Anthony VIOLET
 * @version     SimpleFM 1.0 - 20/04/2020
 * @since       SimpleFM 1.1 - 23/04/2020
 * @contributor
*/

class ConfigApp {
    static $debug = true;
    static $index_page = ""; // Indique la page d'accueil du site web. Si vide la page sera : controllers/IndexController.php
    static $language = "fr";
    static $dir_controllers = "/app"; // Par defaut dans '/controllers/'
    static $dir_models = "/app"; // Par defaut dans '/models/'
    static $dir_views = "/app"; // Par defaut dans '/views/'. ATTENTION ! Le dossier 'views' à la racine du site web contient des dossiers utilisant directement le Moteur donc ne pas supprimé.
    static $dir_assets = '/assets';
}


// Définition des routes
Router::prefix('temple', 'admin'); // Permet de protéger l'administration en modifiant l'url (xxxx/admin/xxxxxx deviens xxxx/temple/xxxx)
Router::connect('news/:slug-:id', 'news/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
