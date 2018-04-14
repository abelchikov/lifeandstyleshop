<?if (strlen($arResult['DETAIL_TEXT']) > 0): // ��������� ��������?>
	<div class="uni-indents-vertical indent-50"></div>
    <div class="row">
		<div class="title"><?=GetMessage('PRODUCT_DESCRIPTION')?></div>
        <div class="uni-indents-vertical indent-25"></div>
		<div id="description" class="item_description uni-text-default">
			<?=$arResult['DETAIL_TEXT']?>
		</div>
		<div class="clear"></div>
	</div>
<?endif;?>
<?if (!empty($properties)):?>
	<div class="uni-indents-vertical indent-50"></div>
	<div class="row">
		<div class="title"><?=GetMessage('PRODUCT_PROPERTIES')?></div>
		<div class="uni-indents-vertical indent-25"></div>
		<div id="properties" class="item_description">
			<div class="properties">
				<?foreach ($properties as $property):?>
					<div class="property">
						<div class="name">
							<?=$property['NAME']?>
						</div>
						<?if (!is_array($property['VALUE'])) {?>
						<div class="value">
							<?=$property['DISPLAY_VALUE']?>
						</div>
						<?} else {?>
							<div class="value">
							<?=implode(', ', $property['VALUE'])?>
						</div>
						<?}?>
					</div>
				<?endforeach;?>
			</div>
		</div>
		<div class="clear"></div>
	</div>
<?endif;?>
<?if (!empty($arResult['PROPERTIES']['INSTRUCTIONS']['VALUE'])):?>
	<div class="uni-indents-vertical indent-50"></div>
	<div class="row">
		<div class="title"><?=GetMessage('PRODUCT_DOCUMENTS')?></div>
		<div class="uni-indents-vertical indent-25"></div>
		<?include('Documents.php')?>
		<div class="clear"></div>
	</div>
<?endif;?>
<?if (is_array($arResult["PROPERTIES"]["EXPANDABLES"]["VALUE"]) && count($arResult["PROPERTIES"]["EXPANDABLES"]["VALUE"]) > 0):?>
	<div class="uni-indents-vertical indent-50"></div>
	<div class="row">
		<div id="expandables" class="item_description">
			<?$GLOBALS["arrFilter"] = array("ID" => $arResult["PROPERTIES"]["EXPANDABLES"]["VALUE"]);?> 		 	
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				"slider",
				Array(
					"AJAX_MODE" => "N",
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"SECTION_ID" => "",
					"SECTION_CODE" => "",
					"SECTION_USER_FIELDS" => array(),
					"ELEMENT_SORT_FIELD" => "sort",
					"ELEMENT_SORT_ORDER" => "asc",
					"FILTER_NAME" => "arrFilter",
					"FLEXISEL_ID" => "expandablesList",
					"TITLE" => GetMessage('ACCESSORIES_TITLE'),
					"INCLUDE_SUBSECTIONS" => "Y",
					"SHOW_ALL_WO_SECTION" => "Y",
					"SECTION_URL" => "",
					"DETAIL_URL" => "",
					"BASKET_URL" => "/personal/cart/",
					"ACTION_VARIABLE" => "action",
					"PRODUCT_ID_VARIABLE" => "id",
					"PRODUCT_QUANTITY_VARIABLE" => "quantity",
					"PRODUCT_PROPS_VARIABLE" => "prop",
					"SECTION_ID_VARIABLE" => "SECTION_ID",
					"META_KEYWORDS" => "-",
					"META_DESCRIPTION" => "-",
					"BROWSER_TITLE" => "-",
					"ADD_SECTIONS_CHAIN" => "N",
					"DISPLAY_COMPARE" => "N",
					"SET_TITLE" => "N",
					"SET_STATUS_404" => "N",
					"PAGE_ELEMENT_COUNT" => "10",
					"LINE_ELEMENT_COUNT" => '4',
					"PROPERTY_CODE" => array(0=>"HIT",1=>"RECOMMEND",2=>"NEW",3=>"",),
					"OFFERS_FIELD_CODE" => array("ID"),
					"OFFERS_PROPERTY_CODE" => array(),
					"OFFERS_SORT_FIELD" => "sort",
					"OFFERS_SORT_ORDER" => "asc",
					"OFFERS_LIMIT" => "2",
					"PRICE_CODE" => array(0=>"BASE"),
					"USE_PRICE_COUNT" => "N",
					"SHOW_PRICE_COUNT" => "1",
					"PRICE_VAT_INCLUDE" => "Y",
					"USE_PRODUCT_QUANTITY" => "N",
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "36000000",
					"CACHE_FILTER" => "N",
					"CACHE_GROUPS" => "Y",
					"DISPLAY_TOP_PAGER" => "N",
					"DISPLAY_BOTTOM_PAGER" => "N",
					"PAGER_TITLE" => "",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => "shop",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"CONVERT_CURRENCY" => "N",
					"OFFERS_CART_PROPERTIES" => array(),
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "Y",
					"AJAX_OPTION_HISTORY" => "N"
				),
			$component
			);?>
		</div>
		<div class="clear"></div>
	</div>
<?endif;?>