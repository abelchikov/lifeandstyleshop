<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?if(CModule::IncludeModule("intec.unimagazin")){
	UniMagazin::InitProtection();
	UniMagazin::ShowInclude(SITE_ID);
}?>
<?$options = UniMagazin::getOptionsValue(SITE_ID);?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.compare.list",
	"top",
	Array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "7",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"DETAIL_URL" => SITE_DIR."catalog/#ELEMENT_CODE#/",
		"COMPARE_URL" =>  SITE_DIR."catalog/compare.php?action=#ACTION_CODE#",
		"NAME" => "CATALOG_COMPARE_LIST",
		"AJAX_OPTION_ADDITIONAL" => "",
		"TYPE" => $options["TYPE_BASKET"]["ACTIVE_VALUE"]
	)
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>