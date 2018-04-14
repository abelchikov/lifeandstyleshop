<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?if (!CModule::IncludeModule("sale") || !CModule::IncludeModule("catalog")) die();?>
<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "mobile_header", array(
	"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
	"PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
	"SHOW_NOTAVAIL" => "Y",
	"SHOW_SUBSCRIBE" => "Y"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>