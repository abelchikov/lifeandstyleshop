<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?
    $bCatalogIncluded = CModule::IncludeModule('catalog');

    if ($bCatalogIncluded) {
    	$arPriceTypes = CCatalogIBlockParameters::getPriceTypesList();
    } else {
    	$arPriceTypes = array();
    }

    $arTemplateParameters = array(
		"USE_GREY_BGN" => Array(
			"NAME" => GetMessage("USE_GREY_BGN"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		)
	);
    
    $arTemplateParameters["PRICE_CODE"] = array(
    	"NAME" => GetMessage("PRICE_CODE"),
    	"TYPE" => "LIST",
    	"MULTIPLE" => "Y",
    	"VALUES" => $arPriceTypes,
    );
?>