<?php
/*#################################################################################################################
#                                                                                                                 #
# Author : VIOLET Anthony                                                                                         #
# Created : `Date.today.strftime('%D')`                                                                           #
# Updated : `Date.today.strftime('%D')`                                                                           #
# Licence : General Public License (GPL)                                                                          #
#                                                                                                                 #
#################################################################################################################*/
$begin = microtime(true);

require 'Sessions.php';

require 'functions.php';
require 'Router.php';
require 'Forms.php';

require ROOT.DS.'config'.DS.'app.php';
require ROOT.DS.'config'.DS.'database.php';

require 'Request.php';
require 'Controller.php';
require 'Model.php';
require 'Dispatcher.php';
?>
<div style="position:fixed; bottom:0; background-color:#900; color:#fff; line-height: 30px; height:30px; left:0; right:0; padding-left:10px;">
    <?php echo 'Page générée en '.round(microtime(true) - $begin, 5).' secondes.'; ?>
</div>
