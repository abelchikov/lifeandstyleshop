<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->ShowAjaxHead();?>
<?if(SITE_CHARSET=="windows-1251"){
	$_REQUEST["NAME_PRODUCT"]=iconv("UTF-8","windows-1251",$_REQUEST["NAME_PRODUCT"]);
	$_REQUEST["NEW_PRICE"]=iconv("UTF-8","windows-1251",$_REQUEST["NEW_PRICE"]);
	$_REQUEST["OLD_PRICE"]=iconv("UTF-8","windows-1251",$_REQUEST["OLD_PRICE"]);
}?>
<?$APPLICATION->IncludeComponent("intec:oneclickbuy", "shop", array(
		"IBLOCK_TYPE" => $_REQUEST["IBLOCK_TYPE"],
		"IBLOCK_ID" => $_REQUEST["IBLOCK_ID"],
		"ELEMENT_ID" => $_REQUEST["ELEMENT_ID"],
		"USE_QUANTITY" => "N",
		"SEF_FOLDER" => SITE_DIR."catalog/",
		"PROPERTIES" => array(
			0 => "USER_NAME",
			1 => "PHONE",
			2 => "EMAIL",
			3 => "COMMENT"
		),
		"REQUIRED" => array(
			0 => "USER_NAME",
			1 => "PHONE",
		),
		"DEFAULT_PERSON_TYPE" => $_REQUEST['DEFAULT_PERSON_TYPE'],
		"DEFAULT_DELIVERY" => $_REQUEST['DEFAULT_DELIVERY'],
		"DEFAULT_PAYMENT" => $_REQUEST['DEFAULT_PAYMENT'],
		"DEFAULT_CURRENCY" => "RUB",
		"PRICE_ID" => "1",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000",
		"USE_SKU" => "Y",
		"IMAGE" => $_REQUEST["IMAGE"],
		"NAME_PRODUCT" => $_REQUEST["NAME_PRODUCT"],
		"NEW_PRICE" =>$_REQUEST["NEW_PRICE"],
		"OLD_PRICE" => $_REQUEST["OLD_PRICE"],
		"PRICE" => $_REQUEST["PRICE"]
	),
	false
);?> 
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>