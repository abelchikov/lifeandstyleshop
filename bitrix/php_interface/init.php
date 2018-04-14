<?php
function pre($arr){
	global $USER;
	if($USER->IsAdmin() && $USER->GetID() == "4"){
		echo "<pre>";print_r($arr);echo "</pre>";
	}
}
function log_to_file($mass, $file){
	file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/log" . $file, print_r($mass, true), FILE_APPEND);
}

function logg($mass){
	log_to_file($mass, "/test.log");
}


require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/tools/lifetools.php");





require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/tools/import.php");
?>