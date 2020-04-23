<?php
/**
 * @license     https://www.gnu.org/licenses/gpl-3.0.html GNU/GPL-3.0
 * @author      Anthony VIOLET
 * @version     SimpleFM 1.0 - 20/04/2020
 * @since       SimpleFM 1.1 - 23/04/2020
 * @contributor
*/

$begin = microtime(true);

require 'Sessions.php';

require 'utils/functions.php';
require 'Router.php';
require 'utils/Forms.php';
require 'utils/CRUD.php';

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
