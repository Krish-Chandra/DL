<?php

$yii=dirname(__FILE__).'/protected/yiiCore/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/console.php';

// remove the following lines when in production mode
//defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER',true);
 

require_once($yii);
Yii::createConsoleApplication($config)->run();
