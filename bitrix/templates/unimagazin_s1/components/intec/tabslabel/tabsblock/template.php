<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>

<?$thisID  = 'tabsblock_bgn';
$thisID2 = 'tabsblock_bgn_size';
$use_bgn_grey = ($arParams['USE_GREY_BGN']=='Y' && $options["TYPE_MAIN_PAGE"]["ACTIVE_VALUE"] != "normal");
?>
<div class="tabs_block standart_block <?=$use_bgn_grey?'tabsblock_bgn':''?>" id="<?=$thisID?>">
	<div class="tabsblock_bgn_wrapper">
		<div id="tabs_block">
			<ul class="clearfix nav title_f">
				<?if($arParams["ENABLE_STOCK"] == "Y"){?>
					<li>
						<a href="#tabs-1">
							<?=GetMessage("MESS_STOCK");?>
						</a>
					</li>
				<?}?>
				<?if($arParams["ENABLE_HIT"] == "Y"){?>
					<li>
						<a href="#tabs-2">
							<?=GetMessage("MESS_HIT");?>
						</a>
					</li>
				<?}?>
				<?if($arParams["ENABLE_NEWS"] == "Y"){?>
					<li>
						<a href="#tabs-3">
							<?=GetMessage("MESS_NEW");?>
						</a>
					</li>
				<?}?>
				<?if($arParams["ENABLE_RECOMMEND"] == "Y"){?>
					<li>
						<a href="#tabs-4">
							<?=GetMessage("MESS_RECOMMEND");?>
						</a>
					</li>
				<?}?>			
			</ul>		
			<?if($arParams["ENABLE_STOCK"] == "Y"){?>
				<div id="tabs-1">
					<?
					if($res = CCatalogDiscount::GetDiscountSectionsList(array(), array(), false, false, array())){
						$arSectionDicrount = array();
						while($ob = $res->GetNext()){
							$arFilter = Array("SECTION_ID" => $ob['SECTION_ID'], 'INCLUDE_SUBSECTIONS' => 'Y');
							$res2 = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, array());
							while($ob2 = $res2->GetNext())
							{
								$arSectionDicrount[] = $ob2['ID'];
							}
						}
					}
					if($res = CCatalogDiscount::GetDiscountProductsList(array(), array(), false, false, array())){
						$arCardDiscount = array();
						while($ob = $res->GetNext()){
							$itemDiscount = CCatalogSku::GetProductInfo($ob['PRODUCT_ID']);
							$arCardDiscount[] = $itemDiscount['ID'];
						}
					} 
					$arrF = array_merge($arSectionDicrount, $arCardDiscount);
					$GLOBALS["arrStockFilter"] = array("ID" => $arrF); ?>
					<?if(!empty($arrF)){?>
					<?$APPLICATION->IncludeComponent(
						"bitrix:catalog.top", 
						"uni_popular_slider", 
						array(
							"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
							"IBLOCK_ID" => $arParams["IBLOCK_ID"],
							"ELEMENT_SORT_FIELD" => "RAND",
							"ELEMENT_SORT_ORDER" => "asc",
							"ELEMENT_SORT_FIELD2" => "id",
							"ELEMENT_SORT_ORDER2" => "desc",
							"FILTER_NAME" => "arrStockFilter",
							"HIDE_NOT_AVAILABLE" => "N",
							"ELEMENT_COUNT" => $arParams["ELEMENT_COUNT"],
							"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
							"PROPERTY_CODE" => array(
								0 => "",
								1 => "HIT",
								2 => "NEW",
								3 => "STOCK",
								4 => "RECOMMEND",
								5 => "",
							),
							"OFFERS_FIELD_CODE" => array(
								0 => "",
								1 => "",
							),
							"OFFERS_PROPERTY_CODE" => array(
								0 => "",
								1 => "",
							),
							"OFFERS_SORT_FIELD" => "sort",
							"OFFERS_SORT_ORDER" => "asc",
							"OFFERS_SORT_FIELD2" => "id",
							"OFFERS_SORT_ORDER2" => "desc",
							"OFFERS_LIMIT" => "6",
							"SECTION_ID_VARIABLE" => "SECTION_ID",
							"CACHE_TYPE" => "A",
							"CACHE_TIME" => "36000000",
							"CACHE_GROUPS" => "Y",
							"DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
							"COMPARE_NAME" => $arParams["COMPARE_NAME"],
							"CACHE_FILTER" => "N",
							"PRICE_CODE" => $arParams['PRICE_CODE'],
							"USE_PRICE_COUNT" => "N",
							"SHOW_PRICE_COUNT" => "1",
							"PRICE_VAT_INCLUDE" => "Y",
							"CONVERT_CURRENCY" => "N",
							"BASKET_URL" => "/personal/basket.php",
							"ACTION_VARIABLE" => "action",
							"PRODUCT_ID_VARIABLE" => "id",
							"USE_PRODUCT_QUANTITY" => "N",
							"ADD_PROPERTIES_TO_BASKET" => "Y",
							"PRODUCT_PROPS_VARIABLE" => "prop",
							"PARTIAL_PRODUCT_PROPERTIES" => "N",
							"PRODUCT_PROPERTIES" => array(
							),
							"OFFERS_CART_PROPERTIES" => "",
							"PRODUCT_QUANTITY_VARIABLE" => "quantity",
							"COMPONENT_TEMPLATE" => "uni_popular_slider",
							"COMPARE_PATH" => "",
							"PRODUCT_DISPLAY_MODE" => "Y",
						),
						false					
					);?>
					<?}?>
				</div>
			<?}?>
			<?if($arParams["ENABLE_HIT"] == "Y"){?>
				<div id="tabs-2">
					<?$GLOBALS["arrHitFilter"] = array("!PROPERTY_HIT" => false); ?>
					<?$APPLICATION->IncludeComponent(
						"bitrix:catalog.top", 
						"uni_popular_slider", 
						array(
							"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
							"IBLOCK_ID" => $arParams["IBLOCK_ID"],
							"ELEMENT_SORT_FIELD" => "RAND",
							"ELEMENT_SORT_ORDER" => "asc",
							"ELEMENT_SORT_FIELD2" => "id",
							"ELEMENT_SORT_ORDER2" => "desc",
							"FILTER_NAME" => "arrHitFilter",
							"HIDE_NOT_AVAILABLE" => "N",
							"ELEMENT_COUNT" => $arParams["ELEMENT_COUNT"],
							"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
							"PROPERTY_CODE" => array(
								0 => "",
								1 => "HIT",
								2 => "NEW",
								3 => "STOCK",
								4 => "RECOMMEND",
								5 => "",
							),
							"OFFERS_FIELD_CODE" => array(
								0 => "",
								1 => "",
							),
							"OFFERS_PROPERTY_CODE" => array(
								0 => "",
								1 => "",
							),
							"OFFERS_SORT_FIELD" => "sort",
							"OFFERS_SORT_ORDER" => "asc",
							"OFFERS_SORT_FIELD2" => "id",
							"OFFERS_SORT_ORDER2" => "desc",
							"OFFERS_LIMIT" => "6",
							"SECTION_ID_VARIABLE" => "SECTION_ID",
							"CACHE_TYPE" => "A",
							"CACHE_TIME" => "36000000",
							"CACHE_GROUPS" => "Y",
							"DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
							"COMPARE_NAME" => $arParams["COMPARE_NAME"],
							"CACHE_FILTER" => "N",
							"PRICE_CODE" => $arParams['PRICE_CODE'],
							"USE_PRICE_COUNT" => "N",
							"SHOW_PRICE_COUNT" => "1",
							"PRICE_VAT_INCLUDE" => "Y",
							"CONVERT_CURRENCY" => "N",
							"BASKET_URL" => "/personal/basket.php",
							"ACTION_VARIABLE" => "action",
							"PRODUCT_ID_VARIABLE" => "id",
							"USE_PRODUCT_QUANTITY" => "N",
							"ADD_PROPERTIES_TO_BASKET" => "Y",
							"PRODUCT_PROPS_VARIABLE" => "prop",
							"PARTIAL_PRODUCT_PROPERTIES" => "N",
							"PRODUCT_PROPERTIES" => array(
							),
							"OFFERS_CART_PROPERTIES" => "",
							"PRODUCT_QUANTITY_VARIABLE" => "quantity",
							"COMPONENT_TEMPLATE" => "uni_popular_slider",
							"COMPARE_PATH" => "",
							"PRODUCT_DISPLAY_MODE" => "Y",
						),
						false,
						array("HIDE_ICONS" => "Y")
					);?>
				</div>
			<?}?>
			<?if($arParams["ENABLE_NEWS"] == "Y"){?>
				<div id="tabs-3">
					<?$GLOBALS["arrNewFilter"] = array("!PROPERTY_NEW" => false);?>
					<?$APPLICATION->IncludeComponent(
						"bitrix:catalog.top", 
						"uni_popular_slider", 
						array(
							"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
							"IBLOCK_ID" => $arParams["IBLOCK_ID"],
							"ELEMENT_SORT_FIELD" => "RAND",
							"ELEMENT_SORT_ORDER" => "asc",
							"ELEMENT_SORT_FIELD2" => "id",
							"ELEMENT_SORT_ORDER2" => "desc",
							"FILTER_NAME" => "arrNewFilter",
							"HIDE_NOT_AVAILABLE" => "N",
							"ELEMENT_COUNT" => $arParams["ELEMENT_COUNT"],
							"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
							"PROPERTY_CODE" => array(
								0 => "",
								1 => "HIT",
								2 => "NEW",
								3 => "STOCK",
								4 => "RECOMMEND",
								5 => "",
							),
							"OFFERS_FIELD_CODE" => array(
								0 => "",
								1 => "",
							),
							"OFFERS_PROPERTY_CODE" => array(
								0 => "",
								1 => "",
							),
							"OFFERS_SORT_FIELD" => "sort",
							"OFFERS_SORT_ORDER" => "asc",
							"OFFERS_SORT_FIELD2" => "id",
							"OFFERS_SORT_ORDER2" => "desc",
							"OFFERS_LIMIT" => "6",
							"SECTION_ID_VARIABLE" => "SECTION_ID",
							"CACHE_TYPE" => "A",
							"CACHE_TIME" => "36000000",
							"CACHE_GROUPS" => "Y",
							"DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
							"COMPARE_NAME" => $arParams["COMPARE_NAME"],
							"CACHE_FILTER" => "N",
							"PRICE_CODE" => $arParams['PRICE_CODE'],
							"USE_PRICE_COUNT" => "N",
							"SHOW_PRICE_COUNT" => "1",
							"PRICE_VAT_INCLUDE" => "Y",
							"CONVERT_CURRENCY" => "N",
							"BASKET_URL" => "/personal/basket.php",
							"ACTION_VARIABLE" => "action",
							"PRODUCT_ID_VARIABLE" => "id",
							"USE_PRODUCT_QUANTITY" => "N",
							"ADD_PROPERTIES_TO_BASKET" => "Y",
							"PRODUCT_PROPS_VARIABLE" => "prop",
							"PARTIAL_PRODUCT_PROPERTIES" => "N",
							"PRODUCT_PROPERTIES" => array(
							),
							"OFFERS_CART_PROPERTIES" => "",
							"PRODUCT_QUANTITY_VARIABLE" => "quantity",
							"COMPONENT_TEMPLATE" => "uni_popular_slider",
							"COMPARE_PATH" => "",
							"PRODUCT_DISPLAY_MODE" => "Y",
						),
						false,
						array("HIDE_ICONS" => "Y")
					);?>
				</div>
			<?}?>
			<?if($arParams["ENABLE_RECOMMEND"] == "Y"){?>
				<div id="tabs-4">
					<?$GLOBALS["arrRecFilter"] = array("!PROPERTY_RECOMMEND" => false);?>
					<?$APPLICATION->IncludeComponent("bitrix:catalog.top", "uni_popular_slider", array(
	"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ELEMENT_SORT_FIELD" => "RAND",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "arrRecFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"ELEMENT_COUNT" => $arParams["ELEMENT_COUNT"],
		"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "HIT",
			2 => "NEW",
			3 => "STOCK",
			4 => "RECOMMEND",
			5 => "",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFERS_LIMIT" => "6",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"DISPLAY_COMPARE" => $arParams["DISPLAY_COMPARE"],
		"COMPARE_NAME" => $arParams["COMPARE_NAME"],
		"CACHE_FILTER" => "N",
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"BASKET_URL" => "/personal/basket.php",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"USE_PRODUCT_QUANTITY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => "",
		"OFFERS_CART_PROPERTIES" => "",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"COMPONENT_TEMPLATE" => "uni_popular_slider",
		"COMPARE_PATH" => "",
		"PRODUCT_DISPLAY_MODE" => "Y"
	),
	false,
	array(
	"HIDE_ICONS" => "N",
		"ACTIVE_COMPONENT" => "N"
	)
);?>
				</div>
			<?}?>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#tabs_block").tabs();
	})
</script>
<?if ($use_bgn_grey){?>
	<div class="tabslable_bgn_size" id="<?=$thisID2?>"></div>
	<script>
		function tabslabel_bgn() {
			$tilesHeight<?=$thisID?> = $('#<?=$thisID?>').outerHeight(false);
			$('#<?=$thisID2?>').css('height', $tilesHeight<?=$thisID?>);
		}
		setTimeout(tabslabel_bgn, 1000);
		$(window).resize(function() {
			$tilesHeight<?=$thisID?> = $('#<?=$thisID?>').outerHeight(false);
			$('#<?=$thisID2?>').css('height', $tilesHeight<?=$thisID?>);
		});
	</script>
<?}?>