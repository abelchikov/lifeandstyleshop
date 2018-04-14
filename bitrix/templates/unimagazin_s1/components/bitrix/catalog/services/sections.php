<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
global $options;

if (strlen($options["SERVICES_CATALOG_DEFAULT_VIEW"]["ACTIVE_VALUE"]) > 0)
{
	$view = $options["SERVICES_CATALOG_DEFAULT_VIEW"]["ACTIVE_VALUE"];
}
else
{
	$view = $options["SERVICES_CATALOG_DEFAULT_VIEW"]["DEFAULT_VALUE"];
}

switch ($_COOKIE['SERVICES_CATALOG_VIEW'])
{
	case 'LIST' : $view = $_COOKIE['SERVICES_CATALOG_VIEW']; break;
	case 'TILE' : $view = $_COOKIE['SERVICES_CATALOG_VIEW']; break;
	case 'TEXT' : $view = $_COOKIE['SERVICES_CATALOG_VIEW']; break;
}

switch ($_GET['view'])
{
	case 'LIST' : $view = $_GET['view']; break;
	case 'TILE' : $view = $_GET['view']; break;
	case 'TEXT' : $view = $_GET['view']; break;
}

setcookie('SERVICES_CATALOG_VIEW', $view);

?>
<div class="left_col"><?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"VIEW_MODE" => "MENU",
		"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
		"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
		"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
	),
	$component,
	array("HIDE_ICONS" => "Y")
);
?>
</div>
<div class="right_col clearfix">
		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.section.list",
			"",
			array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
				"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"VIEW_MODE" => $view,
				"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
				"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
				"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
                "LINE_SECTION_COUNT" => $arParams["LINE_SECTION_COUNT"]
			),
			$component//,
			//array("HIDE_ICONS" => "Y")
		);?>
</div>
<div class="clear"></div>