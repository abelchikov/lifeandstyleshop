<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
if(!CModule::IncludeModule("iblock"))
	return;
$arTemplateParameters = array(	
	"TEXT_POPULAR_PRODUCTS" => Array(
		"NAME" => GetMessage("TEXT_POPULAR_PRODUCTS"),
		"TYPE" => "TEXT",
		"DEFAULT" => GetMessage("TEXT_POPULAR_PRODUCTS_DEFAULT"),
	),
	"COUNT_ELEMENT_GRID" => Array(
		"NAME" => GetMessage("COUNT_ELEMENT_GRID"),
		"TYPE" => "TEXT",
		"DEFAULT" => "4"
	)
);
?>