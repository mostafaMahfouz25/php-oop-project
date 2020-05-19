<?php 

define("ROOT",dirname(__FILE__));
define("INC",ROOT.'/includes/');
define("CORE",INC.'/core/');
define("MODELS",INC.'/models/');
define("CONTROLLERS",INC.'/controllers/');
define("LIBS",INC.'/libs/');



/**
 * 
 * Require Files 
 * 
 */

 require_once(CORE.'config.php');
 require_once(CORE.'mysql.class.php');
 require_once(CORE.'raintpl.class.php');
 require_once(CORE.'system.php');


 System::Store("db",new mysql());
 System::Store("tpl",new RainTPL('templates'));
