<?
	if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
	/** @var array $arCurrentValues */
	use Bitrix\Main\Loader;

	if (!Loader::includeModule("iblock"))
		return;

	$arIBlockType = CIBlockParameters::GetIBlockTypes();

	$arIBlock = array();
	$iblockFilter = (
		!empty($arCurrentValues['IBLOCK_TYPE_COMPARE'])
		? array('TYPE' => $arCurrentValues['IBLOCK_TYPE_COMPARE'], 'ACTIVE' => 'Y')
		: array('ACTIVE' => 'Y')
	);
	$rsIBlock = CIBlock::GetList(array('SORT' => 'ASC'), $iblockFilter);
	while ($arr = $rsIBlock->Fetch())
		$arIBlock[$arr['ID']] = '['.$arr['ID'].'] '.$arr['NAME'];
	unset($arr, $rsIBlock, $iblockFilter);


    $arTemplateParameters = array();
    $arTemplateParameters['SHOW_CALL'] = array(
        'NAME' => GetMessage('SHOW_CALL'),
        'TYPE' => 'checkbox',
        'DEFAULT' => 'Y'
    );
    $arTemplateParameters['TYPE_BASKET'] = array(
        'NAME' => GetMessage('TYPE_BASKET'),
        'TYPE' => 'list',
        'VALUES' => array(
            'top' => GetMessage('TYPE_BASKET_TOP'),
            'header' => GetMessage('TYPE_BASKET_HEADER'),
            'fly' => GetMessage('TYPE_BASKET_FLY')
        ),
        'ADDITIONAL_VALUES' => 'Y',
        'DEFAULT' => 'top'
    );
	
	$arTemplateParameters['IBLOCK_TYPE_COMPARE'] = array(
			'NAME' => GetMessage('IBLOCK_TYPE_COMPARE'),
			'TYPE' => 'LIST',
			'ADDITIONAL_VALUES' => 'Y',
			'VALUES' => $arIBlockType,
			'REFRESH' => 'Y'
    );
	$arTemplateParameters['IBLOCK_ID_COMPARE'] = array(
			'NAME' => GetMessage('IBLOCK_IBLOCK_COMPARE'),
			'TYPE' => 'LIST',
			'ADDITIONAL_VALUES' => 'Y',
			'VALUES' => $arIBlock,
			'REFRESH' => 'Y'
    );
	$arTemplateParameters['COMPARE_NAME'] = array(
			'NAME' => GetMessage('COMPARE_NAME'),
			'TYPE' => 'STRING',
			'DEFAULT' => 'CATALOG_COMPARE_LIST'
	);
?>