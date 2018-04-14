<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Currency;
if (!\Bitrix\Main\Loader::includeModule('iblock'))
	return;
$boolCatalog = \Bitrix\Main\Loader::includeModule('catalog');
$boolSale = \Bitrix\Main\Loader::includeModule('sale');

$arSKU = false;
$boolSKU = false;
if ($boolCatalog && (isset($arCurrentValues['IBLOCK_ID']) && 0 < intval($arCurrentValues['IBLOCK_ID'])))
{
	$arSKU = CCatalogSKU::GetInfoByProductIBlock($arCurrentValues['IBLOCK_ID']);
	$boolSKU = !empty($arSKU) && is_array($arSKU);
}

$arThemes = array();
if (\Bitrix\Main\ModuleManager::isModuleInstalled('bitrix.eshop'))
{
	$arThemes['site'] = GetMessage('CPT_BC_TPL_THEME_SITE');
}

$arThemes['blue'] = GetMessage('CPT_BC_TPL_THEME_BLUE');
$arThemes['green'] = GetMessage('CPT_BC_TPL_THEME_GREEN');
$arThemes['red'] = GetMessage('CPT_BC_TPL_THEME_RED');
$arThemes['wood'] = GetMessage('CPT_BC_TPL_THEME_WOOD');
$arThemes['yellow'] = GetMessage('CPT_BC_TPL_THEME_YELLOW');
$arThemes['black'] = GetMessage('CP_BC_TPL_THEME_BLACK');

$arViewModeList = array(
	'LIST' => GetMessage('CPT_BC_SECTIONS_VIEW_MODE_LIST'),
	'LINE' => GetMessage('CPT_BC_SECTIONS_VIEW_MODE_LINE'),
	'TEXT' => GetMessage('CPT_BC_SECTIONS_VIEW_MODE_TEXT'),
	'TILE' => GetMessage('CPT_BC_SECTIONS_VIEW_MODE_TILE')
);

$arFilterViewModeList = array(
	"VERTICAL" => GetMessage("CPT_BC_FILTER_VIEW_MODE_VERTICAL"),
	"HORIZONTAL" => GetMessage("CPT_BC_FILTER_VIEW_MODE_HORIZONTAL")
);

$arTemplateParameters = array();

$arTemplateParameters['USE_CAPTCHA'] = array(
	"PARENT" => "HIDDEN",
	"TYPE" => "CUSTOM",
	"DESCRIPTION" => ""
);
$arTemplateParameters['REVIEW_AJAX_POST'] = array(
	"PARENT" => "HIDDEN",
	"TYPE" => "CUSTOM",
	"DESCRIPTION" => ""
);
$arTemplateParameters['PATH_TO_SMILE'] = array(
	"PARENT" => "HIDDEN",
	"TYPE" => "CUSTOM",
	"DESCRIPTION" => ""
);
$arTemplateParameters['FORUM_ID'] = array(
	"PARENT" => "HIDDEN",
	"TYPE" => "CUSTOM",
	"DESCRIPTION" => ""
);
$arTemplateParameters['URL_TEMPLATES_READ'] = array(
	"PARENT" => "HIDDEN",
	"TYPE" => "CUSTOM",
	"DESCRIPTION" => ""
);
$arTemplateParameters['SHOW_LINK_TO_FORUM'] = array(
	"PARENT" => "HIDDEN",
	"TYPE" => "CUSTOM",
	"DESCRIPTION" => ""
);

if (isset($arCurrentValues['IBLOCK_ID']) && 0 < intval($arCurrentValues['IBLOCK_ID']))
{
	$arAllPropList = array();
	$arFilePropList = array(
		'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
	);
	$arListPropList = array(
		'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
	);
	$arHighloadPropList = array(
		'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
	);
	$rsProps = CIBlockProperty::GetList(
		array('SORT' => 'ASC', 'ID' => 'ASC'),
		array('IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], 'ACTIVE' => 'Y')
	);
	while ($arProp = $rsProps->Fetch())
	{
		$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];
		if ('' == $arProp['CODE'])
			$arProp['CODE'] = $arProp['ID'];
		$arAllPropList[$arProp['CODE']] = $strPropName;
		if ('F' == $arProp['PROPERTY_TYPE'])
			$arFilePropList[$arProp['CODE']] = $strPropName;
		if ('L' == $arProp['PROPERTY_TYPE'])
			$arListPropList[$arProp['CODE']] = $strPropName;
		if ('S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($arProp))
			$arHighloadPropList[$arProp['CODE']] = $strPropName;
	}

	$arTemplateParameters['ADD_PICT_PROP'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_ADD_PICT_PROP'),
		'TYPE' => 'LIST',
		'MULTIPLE' => 'N',
		'ADDITIONAL_VALUES' => 'N',
		'REFRESH' => 'N',
		'DEFAULT' => '-',
		'VALUES' => $arFilePropList
	);
	
	if ($boolSKU)
	{
		$arDisplayModeList = array(
			'N' => GetMessage('CP_BC_TPL_DML_SIMPLE'),
			'Y' => GetMessage('CP_BC_TPL_DML_EXT')
		);
		$arTemplateParameters['PRODUCT_DISPLAY_MODE'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BC_TPL_PRODUCT_DISPLAY_MODE'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'Y',
			'DEFAULT' => 'N',
			'VALUES' => $arDisplayModeList
		);
		$arAllOfferPropList = array();
		$arFileOfferPropList = array(
			'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
		);
		$arTreeOfferPropList = array(
			'-' => GetMessage('CP_BC_TPL_PROP_EMPTY')
		);
		$rsProps = CIBlockProperty::GetList(
			array('SORT' => 'ASC', 'ID' => 'ASC'),
			array('IBLOCK_ID' => $arSKU['IBLOCK_ID'], 'ACTIVE' => 'Y')
		);
		while ($arProp = $rsProps->Fetch())
		{
			if ($arProp['ID'] == $arSKU['SKU_PROPERTY_ID'])
				continue;
			$arProp['USER_TYPE'] = (string)$arProp['USER_TYPE'];
			$strPropName = '['.$arProp['ID'].']'.('' != $arProp['CODE'] ? '['.$arProp['CODE'].']' : '').' '.$arProp['NAME'];
			if ('' == $arProp['CODE'])
				$arProp['CODE'] = $arProp['ID'];
			$arAllOfferPropList[$arProp['CODE']] = $strPropName;
			if ('F' == $arProp['PROPERTY_TYPE'])
				$arFileOfferPropList[$arProp['CODE']] = $strPropName;
			if ('N' != $arProp['MULTIPLE'])
				continue;
			if (
				'L' == $arProp['PROPERTY_TYPE']
				|| 'E' == $arProp['PROPERTY_TYPE']
				|| ('S' == $arProp['PROPERTY_TYPE'] && 'directory' == $arProp['USER_TYPE'] && CIBlockPriceTools::checkPropDirectory($arProp))
			)
				$arTreeOfferPropList[$arProp['CODE']] = $strPropName;
		}
		$arTemplateParameters['OFFER_ADD_PICT_PROP'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BC_TPL_OFFER_ADD_PICT_PROP'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'N',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $arFileOfferPropList
		);
		$arTemplateParameters['OFFER_TREE_PROPS'] = array(
			'PARENT' => 'VISUAL',
			'NAME' => GetMessage('CP_BC_TPL_OFFER_TREE_PROPS'),
			'TYPE' => 'LIST',
			'MULTIPLE' => 'Y',
			'ADDITIONAL_VALUES' => 'N',
			'REFRESH' => 'N',
			'DEFAULT' => '-',
			'VALUES' => $arTreeOfferPropList
		);
	}
}

$arTemplateParameters['DETAIL_DISPLAY_NAME'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_DETAIL_DISPLAY_NAME'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'Y'
);

$detailPictMode = array(
	'IMG' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_IMG'),
	'POPUP' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_POPUP'),
	/*	'MAGNIFIER' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_MAGNIFIER'),
		'GALLERY' => GetMessage('DETAIL_DETAIL_PICTURE_MODE_GALLERY') */
);

$arTemplateParameters['DETAIL_DETAIL_PICTURE_MODE'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_DETAIL_DETAIL_PICTURE_MODE'),
	'TYPE' => 'LIST',
	'DEFAULT' => 'IMG',
	'VALUES' => $detailPictMode
);

$arTemplateParameters['DETAIL_ADD_DETAIL_TO_SLIDER'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_DETAIL_ADD_DETAIL_TO_SLIDER'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N'
);

$displayPreviewTextMode = array(
	'H' => GetMessage('CP_BC_TPL_DETAIL_DISPLAY_PREVIEW_TEXT_MODE_HIDE'),
	'E' => GetMessage('CP_BC_TPL_DETAIL_DISPLAY_PREVIEW_TEXT_MODE_EMPTY_DETAIL'),
	'S' => GetMessage('CP_BC_TPL_DETAIL_DISPLAY_PREVIEW_TEXT_MODE_SHOW')
);

$arTemplateParameters['DETAIL_DISPLAY_PREVIEW_TEXT_MODE'] = array(
	'PARENT' => 'DETAIL_SETTINGS',
	'NAME' => GetMessage('CP_BC_TPL_DETAIL_DISPLAY_PREVIEW_TEXT_MODE'),
	'TYPE' => 'LIST',
	'VALUES' => $displayPreviewTextMode,
	'DEFAULT' => 'E'
);

if ($boolCatalog)
{
/*	$arTemplateParameters['PRODUCT_SUBSCRIPTION'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_PRODUCT_SUBSCRIPTION'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	); */
	$arTemplateParameters['SHOW_DISCOUNT_PERCENT'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_SHOW_DISCOUNT_PERCENT'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y',
	);
	$arTemplateParameters['SHOW_OLD_PRICE'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_SHOW_OLD_PRICE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	);
	$arTemplateParameters['DETAIL_SHOW_MAX_QUANTITY'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_DETAIL_SHOW_MAX_QUANTITY'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
	);
	
	//Купить в 1 клик
	$typePersonsList = array();
	$arTypePersons = CSalePersonType::GetList(array(), array('ACTIVE' => 'Y', 'SID'=>SITE_ID), false, false, array('ID', 'NAME'));
	while ($typePerson = $arTypePersons->Fetch()) {
		$typePersonsList[$typePerson['ID']] = '['.$typePerson['ID'].'] '.$typePerson['NAME'];
	}
	
	$typeDeliveryList = array();
	$arTypeDelivery = CSaleDelivery::GetList(array(), array('ACTIVE' => 'Y', 'SID'=>SITE_ID), false, false, array('ID', 'NAME'));
	while ($typeDelivery = $arTypeDelivery->Fetch()) {
		$typeDeliveryList[$typeDelivery['ID']] = '['.$typeDelivery['ID'].'] '.$typeDelivery['NAME'];
	}
	
	$typePaymentList = array();
	$arTypePayment = CSalePaySystem::GetList(array(), array('ACTIVE' => 'Y'), false, false, array('ID', 'NAME'));
	while ($typePayment = $arTypePayment->Fetch()) {
		$typePaymentList[$typePayment['ID']] = '['.$typePayment['ID'].'] '.$typePayment['NAME'];
	}
	
	$arTemplateParameters['OCB_USE'] = array(
		'NAME' => GetMessage('OCB_USE'),
		'REFRESH' => 'Y',
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'Y',
	);
	
	if ($arCurrentValues['OCB_USE'] == 'Y') {
		$arTemplateParameters['OCB_TYPE_PERSON'] = array(
			'NAME' => GetMessage('OCB_TYPE_PERSON'),
			'TYPE' => 'LIST',
			'VALUES' => $typePersonsList
		);
		$arTemplateParameters['OCB_TYPE_DELIVERY'] = array(
			'NAME' => GetMessage('OCB_TYPE_DELIVERY'),
			'TYPE' => 'LIST',
			'VALUES' => $typeDeliveryList
		);
		$arTemplateParameters['OCB_TYPE_PAYMENT'] = array(
			'NAME' => GetMessage('OCB_TYPE_PAYMENT'),
			'TYPE' => 'LIST',
			'VALUES' => $typePaymentList
		);
	}
	//Купить в 1 клик end
}

if (isset($arCurrentValues['DETAIL_USE_VOTE_RATING']) && 'Y' == $arCurrentValues['DETAIL_USE_VOTE_RATING'])
{
	$arTemplateParameters['DETAIL_VOTE_DISPLAY_AS_RATING'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_DETAIL_VOTE_DISPLAY_AS_RATING'),
		'TYPE' => 'LIST',
		'VALUES' => array(
			'rating' => GetMessage('CP_BC_TPL_DVDAR_RATING'),
			'vote_avg' => GetMessage('CP_BC_TPL_DVDAR_AVERAGE'),
		),
		'DEFAULT' => 'rating'
	);
}

/* Отзывы */
$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock = array();
$iblockFilter = (
	!empty($arCurrentValues['REVIEWS_IBLOCK_TYPE'])
	? array('TYPE' => $arCurrentValues['REVIEWS_IBLOCK_TYPE'], 'ACTIVE' => 'Y')
	: array('ACTIVE' => 'Y')
);
$rsIBlock = CIBlock::GetList(array('SORT' => 'ASC'), $iblockFilter);
while ($arr = $rsIBlock->Fetch())
	$arIBlock[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
unset($arr, $rsIBlock, $iblockFilter);

$arTemplateParameters['REVIEWS_IBLOCK_TYPE'] = array(
	"PARENT" => "REVIEW_SETTINGS",
	"NAME" => GetMessage("REVIEWS_IBLOCK_TYPE"),
	"TYPE" => "LIST",
	"VALUES" => $arIBlockType,
	"REFRESH" => "Y"
);

$arTemplateParameters['REVIEWS_IBLOCK_ID'] = array(
	"PARENT" => "REVIEW_SETTINGS",
	"NAME" => GetMessage("REVIEWS_IBLOCK_IBLOCK"),
	"TYPE" => "LIST",
	"ADDITIONAL_VALUES" => "Y",
	"VALUES" => $arIBlock,
	"REFRESH" => "Y"
);

/* - Отзывы - */

$arTemplateParameters['GRID_CATALOG_ROOT_SECTIONS_COUNT'] = array(
	"PARENT" => "SECTIONS_SETTINGS",
	"NAME" => GetMessage('GRID_CATALOG_ROOT_SECTIONS_COUNT'),
	"TYPE" => "STRING",
	"ADDITIONAL_VALUES" => "Y",
	"DEFAULT" => "5"
);

$arTemplateParameters['GRID_CATALOG_SECTIONS_COUNT'] = array(
	"PARENT" => "SECTIONS_SETTINGS",
	"NAME" => GetMessage('GRID_CATALOG_SECTIONS_COUNT'),
	"TYPE" => "STRING",
	"ADDITIONAL_VALUES" => "Y",
	"DEFAULT" => "4"
);

$arTemplateParameters['DETAIL_USE_COMMENTS'] = array(
	'PARENT' => 'VISUAL',
	'NAME' => GetMessage('CP_BC_TPL_DETAIL_USE_COMMENTS'),
	'TYPE' => 'CHECKBOX',
	'DEFAULT' => 'N',
	'REFRESH' => 'Y'
);

if (IsModuleInstalled("highloadblock"))
{
	$arTemplateParameters['DETAIL_BRAND_USE'] = array(
		'PARENT' => 'VISUAL',
		'NAME' => GetMessage('CP_BC_TPL_DETAIL_BRAND_USE'),
		'TYPE' => 'CHECKBOX',
		'DEFAULT' => 'N',
		'REFRESH' => 'Y'
	);

	if (isset($arCurrentValues['DETAIL_BRAND_USE']) && 'Y' == $arCurrentValues['DETAIL_BRAND_USE'])
	{
		$arTemplateParameters['DETAIL_BRAND_PROP_CODE'] = array(
			'PARENT' => 'VISUAL',
			"NAME" => GetMessage("CP_BC_TPL_DETAIL_PROP_CODE"),
			"TYPE" => "LIST",
			'PARENT' => 'VISUAL',
			"VALUES" => $arHighloadPropList
		);
	}
}

if (isset($arCurrentValues['SHOW_TOP_ELEMENTS']) && 'Y' == $arCurrentValues['SHOW_TOP_ELEMENTS'])
{
	$arTopViewModeList = array(
		'BANNER' => GetMessage('CPT_BC_TPL_VIEW_MODE_BANNER'),
		'SLIDER' => GetMessage('CPT_BC_TPL_VIEW_MODE_SLIDER'),
		'SECTION' => GetMessage('CPT_BC_TPL_VIEW_MODE_SECTION')
	);
	$arTemplateParameters['TOP_VIEW_MODE'] = array(
		'PARENT' => 'TOP_SETTINGS',
		'NAME' => GetMessage('CPT_BC_TPL_TOP_VIEW_MODE'),
		'TYPE' => 'LIST',
		'VALUES' => $arTopViewModeList,
		'MULTIPLE' => 'N',
		'DEFAULT' => 'SECTION',
		'REFRESH' => 'Y'
	);
	if (isset($arCurrentValues['TOP_VIEW_MODE']) && ('SLIDER' == $arCurrentValues['TOP_VIEW_MODE'] || 'BANNER' == $arCurrentValues['TOP_VIEW_MODE']))
	{
		$arTemplateParameters['TOP_ROTATE_TIMER'] = array(
			'PARENT' => 'TOP_SETTINGS',
			'NAME' => GetMessage('CPT_BC_TPL_TOP_ROTATE_TIMER'),
			'TYPE' => 'STRING',
			'DEFAULT' => '30'
		);
	}
}
if (isset($arCurrentValues['CONVERT_CURRENCY']) && $arCurrentValues['CONVERT_CURRENCY'] == 'Y')
	{
		$arTemplateParameters['VIEWED_CURRENCY'] = array(
			'PARENT' => 'PRICES',
			'NAME' => GetMessage('CP_BC_VIEWED_CURRENCY'),
			'TYPE' => 'LIST',
			'VALUES' => Currency\CurrencyManager::getCurrencyList(),
			'DEFAULT' => Currency\CurrencyManager::getBaseCurrency(),
			"ADDITIONAL_VALUES" => "Y",
		);
	}
?>