<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!CModule::IncludeModule("iblock"))
	return;
$arTemplateParameters = array(
	"DATE_PRODUCT_DAY" => Array(
		"NAME" => GetMessage("DATE_PRODUCT_DAY"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"TEXT_PRODUCT_DAY" => Array(
		"NAME" => GetMessage("TEXT_PRODUCT_DAY"),
		"TYPE" => "TEXT",
		"DEFAULT" => GetMessage("TEXT_PRODUCT_DAY_DEFAULT"),
	),
	"HREF_TO_DETAIL" => Array(
		"NAME" => GetMessage("HREF_TO_DETAIL"),
		"TYPE" => "TEXT",
		"DEFAULT" => SITE_DIR."product_day/",
	)
);
?>