<?php
/*################################################################################################
#                                                                                                #
# Author : VIOLET Anthony                                                                        #
# Created : 20/04/2020                                                                           #                                                                        #
# Licence : General Public License (GPL)                                                         #
#                                                                                                #
################################################################################################*/

define('PATH_APP', dirname(__FILE__));
define('ROOT', dirname(PATH_APP));
define('DS', DIRECTORY_SEPARATOR);
define('KERNEL', ROOT.DS.'kernel');
define('BASE_URL', dirname(dirname($_SERVER['SCRIPT_NAME'])));

require_once KERNEL.DS.'init.php';

new Dispatcher();

?>
