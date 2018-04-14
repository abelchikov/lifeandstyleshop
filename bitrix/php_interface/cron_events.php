<?php
//$_SERVER['DOCUMENT_ROOT'] = realpath(dirname(__FILE__).'/. ./..');
//$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

$_SERVER["DOCUMENT_ROOT"] = "/home/bitrix/www";
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS',true);
define('BX_NO_ACCELERATOR_RESET', true);
define('CHK_EVENT', true);

require($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/include/prolog_before.php');

@set_time_limit(120);
ini_set('max_execution_time', 120);
@ignore_user_abort(true);

CAgent::CheckAgents();
CEvent::CheckEvents();
define("BX_CRONTAB_SUPPORT", true);
define("BX_CRONTAB", true) ;
CAgent::CheckAgents();
CEvent::CheckEvents();

if (CModule::IncludeModule("subscribe"))
{
	$cPosting = new CPosting;
	$cPosting->AutoSend();
}

require($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/tools/backup.php');
?>
