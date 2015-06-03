<?php
//error_reporting(0);
ini_set("max_execution_time", "3600");
//set_time_limit (180); 

require_once "./protected/settings.php";
require_once "./protected/MysqlTestDataGeneratorClass.php";

$app=new MysqlTestDataGeneratorClass;

$app->run();