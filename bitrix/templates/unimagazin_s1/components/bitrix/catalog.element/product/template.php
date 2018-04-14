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
$frame = $this->createFrame()->begin();
global $options;
if (!CModule::IncludeModule("sale")) 
		return;
$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);


//pre($options);

$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ONE_CLICK_BUY' => $strMainID.'_one_click_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && '' != $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);
?>
<?include('parts/Script.php')?>
<?if ($options['CATALOG_PRODUCT_MENU']['ACTIVE_VALUE'] == "Y"):?>
    <div class="left_col">
        <?$APPLICATION->IncludeComponent("bitrix:menu", "catalog_vertical", array(
    		"ROOT_MENU_TYPE" => "catalog",
    		"MENU_CACHE_TYPE" => "N",
    		"MENU_CACHE_TIME" => "3600",
    		"MENU_CACHE_USE_GROUPS" => "Y",
    		"MENU_CACHE_GET_VARS" => array(
    		),
    		"MAX_LEVEL" => "2",
    		"CHILD_MENU_TYPE" => "catalog",
    		"USE_EXT" => "Y",
    		"DELAY" => "N",
    		"ALLOW_MULTI_SELECT" => "N",
    		"HIDE_CATALOG" => "Y",
    		"COUNT_ITEMS_CATALOG" => "8"
    		),
    		false
    	);?> 
    	<div class="clear"></div>
    </div>
    <div class="right_col">
<?endif;?>
<div class="item<?=$options['CATALOG_PRODUCT_MENU']['ACTIVE_VALUE'] == "Y"?' with-menu':''?>" id="<? echo $arItemIDs['ID']; ?>">
<?
reset($arResult['MORE_PHOTO']);
?>
	<?if ($arParams['SHOW_TITLE'] == 'Y'):?>
		<div class="row">
			<div class="title" style="font-size: 28px;">
				<?=$arResult["NAME"];?>
			</div>
		</div>
		<div class="uni-indents-vertical indent-20"></div>
	<?endif;?>
	<?if ($arParams['PRODUCT_OF_DAY_SHOW'] == 'Y'):?>
		<?if (!empty($arResult["PROPERTIES"]["DAY_PROD"]["VALUE"])):?>
			<?include('parts/ProductOfDay.php')?>
		<?endif;?>
	<?endif;?>
	<div class="row">
		<div class="image-slider">
			<div class="image-box">
				<div class="wrapper">
					<div class="marks">
                        <?if( $arResult["PROPERTIES"]["RECOMMEND"]["VALUE"] ){?>
                            <span class="mark recommend"><?=GetMessage('MARK_RECOMEND')?></span>
                        <?}?>
                        <?if( $arResult["PROPERTIES"]["NEW"]["VALUE"] ){?>
                            <span class="mark new"><?=GetMessage('MARK_NEW')?></span>
                        <?}?>
                        <?if($arResult["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"] && $arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'){?>
                            <span class="mark action">- <?=$arResult["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"];?> %</span>
                        <?}?>
                        <?if( $arResult["PROPERTIES"]["HIT"]["VALUE"] ){?>
                            <span class="mark hit"><?=GetMessage('MARK_HIT')?></span>
                        <?}?>
                    </div>
					<div class="slider-images" id="slider_images">
                        <? 
                            $noimg = false;
                            $first  = true;
                            if (empty($arResult['PREVIEW_PICTURE']) && empty($arResult['DETAIL_PICTURE'])) $noimg = true;
                        ?>
						<?foreach ($arResult['MORE_PHOTO'] as $photo):?>
                            <?if ($first && $noimg):?>
								<?$photo['SRC'] = SITE_TEMPLATE_PATH."/images/noimg/no-img.png"?>
                                <a class="image">
    								<img class="noimg" src="<?=$photo['SRC']?>" />
    								<div class="valign"></div>
                                </a>
                            <?else:?>
    							<a 
									rel='images' 
									<?if ($options['CATALOG_PRODUCT_IMAGE_VIEW']['ACTIVE_VALUE'] != 'WITHOUT_EFFECTS'):?>
										<?=$options['CATALOG_PRODUCT_IMAGE_VIEW']['ACTIVE_VALUE'] == 'WITH_FANCY'?' href="'.$photo['SRC'].'"':''?>
									<?endif;?>
									class="image<?=$options['CATALOG_PRODUCT_IMAGE_VIEW']['ACTIVE_VALUE'] == 'WITH_FANCY'?' fancy':''?><?=$options['CATALOG_PRODUCT_IMAGE_VIEW']['ACTIVE_VALUE'] == 'WITH_ZOOM'?' zoom':''?><?=$options['CATALOG_PRODUCT_IMAGE_VIEW']['ACTIVE_VALUE'] == 'WITHOUT_EFFECTS'?' noeffect':''?>"
								>
    								<img src="<?=$photo['SRC']?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>"/>
    								<div class="valign"></div>
    							</a>
                            <?endif;?>
                            <?$first = false?>
						<?endforeach;?>
					</div>
					<?if ($options['CATALOG_SKU_VIEW']['ACTIVE_VALUE'] == 'DYNAMIC' && !empty($arResult['JS_OFFERS'])):?>
						<?foreach ($arResult['JS_OFFERS'] as $arOffer):?>
							<?if ($arOffer['SLIDER_COUNT'] > 0):?>
								<div class="slider-images" id="slider_images_<?=$arOffer['ID']?>" style="display: none;">
									<?foreach($arOffer['SLIDER'] as $photo):?>
										<a 
											rel='images_<?$arOffer['ID']?>' 
											<?if ($options['CATALOG_PRODUCT_IMAGE_VIEW']['ACTIVE_VALUE'] != 'WITHOUT_EFFECTS'):?>
												<?=$options['CATALOG_PRODUCT_IMAGE_VIEW']['ACTIVE_VALUE'] == 'WITH_FANCY'?' href="'.$photo['SRC'].'"':''?>
											<?endif;?> 
											class="image<?=$options['CATALOG_PRODUCT_IMAGE_VIEW']['ACTIVE_VALUE'] == 'WITH_FANCY'?' fancy':''?><?=$options['CATALOG_PRODUCT_IMAGE_VIEW']['ACTIVE_VALUE'] == 'WITH_ZOOM'?' zoom':''?><?=$options['CATALOG_PRODUCT_IMAGE_VIEW']['ACTIVE_VALUE'] == 'WITHOUT_EFFECTS'?' noeffect':''?>"
										>
											<img src="<?=$photo['SRC']?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>"/>
											<div class="valign"></div>
										</a>
									<?endforeach;?>
								</div>
							<?endif;?>
						<?endforeach;?>
					<?endif;?>
					<?if ($options['CATALOG_PRODUCT_IMAGE_VIEW']['ACTIVE_VALUE'] == 'WITH_ZOOM'):?>
						<script type="text/javascript">
                            $(document).ready(function(){
                                $('.image-slider .image-box .wrapper a.image').not('.noimg').zoom({magnify:1.5});
                            });
						</script>
					<?endif;?>
				</div>
			</div>
			<div class="clear"></div>
			<?if ($arResult['SHOW_SLIDER']):?>
				<script type="text/javascript">
					var slider = new CapitalProductSlider('.image-slider', '#slider', '#slider_images');
				</script>
				<div class="list" id='slider'>
					<div class="buttons<?=((count($arResult['MORE_PHOTO']) <= 4 && $options['CATALOG_PRODUCT_MENU']['ACTIVE_VALUE'] == "N")||(count($arResult['MORE_PHOTO']) <= 2 && $options['CATALOG_PRODUCT_MENU']['ACTIVE_VALUE'] == "Y"))?' hidden':''?>">
						<div class="valign"></div>
						<div class="wrapper">
							<div class="button uni-slider-button-small uni-slider-button-left" id="left" onClick="slider.scroll('right'); return false;"><div class="icon"></div></div>
							<div class="button uni-slider-button-small uni-slider-button-right" id="right" onClick="slider.scroll('left'); return false;"><div class="icon"></div></div>
						</div>
					</div>
					<div class="items">
						<?if (count($arResult['MORE_PHOTO']) > 1) {?>
							<?foreach($arResult['MORE_PHOTO'] as $photo) {?>
								<div class="image" onClick="slider.show(this); return false;">
									<div class="wrapper">
										<div>
											<div>
												<div class="valign"></div>
												<img src="<?=$photo['SRC']?>" />
											</div>
										</div>
									</div>
								</div>
							<?}?>
						<?}?>
					</div>
				</div>
				<?if ($options['CATALOG_SKU_VIEW']['ACTIVE_VALUE'] == 'DYNAMIC' && !empty($arResult['JS_OFFERS'])):?>
					<?foreach ($arResult['JS_OFFERS'] as $arOffer):?>
						<?if ($arOffer['SLIDER_COUNT'] > 0):?>
							<script type="text/javascript">
								var slider<?=$arOffer['ID']?> = new CapitalProductSlider('.image-slider', '#slider_<?=$arOffer['ID']?>', '#slider_images_<?=$arOffer['ID']?>');
							</script>
							<div class="list" id="slider_<?=$arOffer['ID']?>" style="display: none;">
								<div class="buttons<?=(($arOffer['SLIDER_COUNT'] <= 4 && $options['CATALOG_PRODUCT_MENU']['ACTIVE_VALUE'] == "N")||($arOffer['SLIDER_COUNT'] <= 2 && $options['CATALOG_PRODUCT_MENU']['ACTIVE_VALUE'] == "Y"))?' hidden':''?>">
									<div class="valign"></div>
									<div class="wrapper">
										<div class="button uni-slider-button-small uni-slider-button-left" onClick="slider<?=$arOffer['ID']?>.scroll('right'); return false;"><div class="icon"></div></div>
										<div class="button uni-slider-button-small uni-slider-button-right" id="right" onClick="slider<?=$arOffer['ID']?>.scroll('left'); return false;"><div class="icon"></div></div>
									</div>
								</div>
								<div class="items">
									<?if (count($arOffer['SLIDER']) > 1) {?>
										<?foreach($arOffer['SLIDER'] as $photo) {?>
											<div class="image" onClick="slider<?=$arOffer['ID']?>.show(this); return false;">
												<div class="wrapper">
													<div>
														<div>
															<div class="valign"></div>
															<img src="<?=$photo['SRC']?>"/>
														</div>
													</div>
												</div>
											</div>
										<?}?>
									<?}?>
								</div>
							</div>
						<?endif;?>
					<?endforeach;?>
				<?endif;?>
			<?endif;?>
		</div>
		<div class="information">
            <?if (!empty($arResult['PROPERTIES']['BRAND']['VALUE'])):?>
                <?$brand = $arResult['PROPERTIES']['BRAND']['VALUE']?>
                <a class="brand" href="<?=$brand['DETAIL_PAGE_URL']?>">
                    <div class="uni-aligner-vertical"></div>
                    <img src="<?=$brand['PREVIEW_PICTURE']['SRC']?>" />
                </a>
            <?endif;?>
			<?if ((($options['CATALOG_SKU_VIEW']['ACTIVE_VALUE'] != 'LIST') || empty($arResult['OFFERS'])) || !empty($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'])): // ���� ���� ��� Offers ��� ��� SKU �� LIST ��� ���� �������?>
				<div class="row">
					<?if (!empty($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'])):?>
						<div class="article"><?=GetMessage('PRODUCT_ARTICLE')?>: <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?></div>
					<?endif;?>
					<?if (($options['CATALOG_SKU_VIEW']['ACTIVE_VALUE'] != 'LIST' || empty($arResult['OFFERS'])) && ($arResult['CATALOG_QUANTITY_TRACE'] == "Y" || $arResult['OFFERS'][0]['CATALOG_QUANTITY_TRACE']== 'Y')):?>
						<div class="state available" id="quantity_available" style="<?=$arResult['CATALOG_AVAILABLE'] != 'Y'?'display: none;':''?>">
							<div class="icon"></div>
							<?=GetMessage('PRODUCT_HAVE')?>
							<?if ($arParams['SHOW_MAX_QUANTITY'] == 'Y'):?>
								<span id="quantity_box" <?=$arResult['CATALOG_QUANTITY'] == 0?'style="display: none;"':''?>><span id="quantity"><?=$arResult['CATALOG_QUANTITY']?></span> <span id="quantity_prefix"><?=$arResult['CATALOG_MEASURE_NAME']?></span>.</span>
							<?endif;?>
						</div>
						<div class="state unavailable" id="quantity_unavailable" style="<?=$arResult['CATALOG_AVAILABLE'] == 'Y'?'display: none;':''?>">
							<div class="icon"></div>
							<?=GetMessage('PRODUCT_NOT_HAVE')?>
						</div>
					<?endif;;?>
				</div>
				<div class="uni-indents-vertical indent-25"></div>
			<?endif;?>
			<?if (empty($arResult['OFFERS'])): // ���� ��� OFFERS?>
				<div class="row">
					<?include('parts/OrderNoOffers.php')?>
				</div>
			<?endif;?>
			<?if (($options['CATALOG_SKU_VIEW']['ACTIVE_VALUE'] == 'LIST') && !empty($arResult['OFFERS'])): // ���� ���� Offers � ��� SKU - LIST?>
				<div class="row">
                    <?include('parts/OrderWithOffersSKUList.php')?>
                </div>
			<?endif;?>
			<?if ($options['CATALOG_SKU_VIEW']['ACTIVE_VALUE'] == 'DYNAMIC' && !empty($arResult['OFFERS'])): // ���� ���� Offers � ��� SKU - DYNAMIC?>
				<div class="row">
					<?include('parts/OrderWithOffersSKUDynamic.php')?>
				</div>
			<?endif;?>
		</div>
        <?if ($options['CATALOG_PRODUCT_MENU']['ACTIVE_VALUE'] == "Y"):?><div class="clear"></div><?endif;?>
        <div class="information with-menu">
            <?if (!empty($arResult['PREVIEW_TEXT'])):?>
				<div class="uni-indents-vertical indent-25"></div>
				<div class="row">
					<div class="description uni-text-default">
						<?=$arResult['PREVIEW_TEXT']?>
					</div>
				</div>
			<?endif;?>
            <?if ($options['CATALOG_PRODUCT_MIN_PROPERTIES']['ACTIVE_VALUE'] == "Y"):?>
                <?include('parts/PropertiesMinimal.php')?>
            <?endif;?>
        </div>
        <?
        $properties = $arResult['DISPLAY_PROPERTIES'];
        unset($properties['CML2_ARTICLE']); // Удаляем артикул
        ?>
        <?if ($options['CATALOG_PRODUCT_VIEW']['ACTIVE_VALUE'] == "WITH_TABS_UP"){?>
            <div class="information <?=($options['CATALOG_PRODUCT_MENU']['ACTIVE_VALUE'] == "Y")?'with-menu':''?>">
                <div class="uni-indents-vertical indent-25"></div>
                <div class="row">
                    <?include('parts/ViewWithTabsUp.php')?>
                </div>
            </div>
        <?}?>
		<div class="clear"></div>
	</div>
    <?if ($options['CATALOG_SKU_VIEW']['ACTIVE_VALUE'] == 'LIST' && isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])){?>
        <div class="uni-indents-vertical indent-50"></div>
        <div class="row" style="overflow-x: auto;">
            <?include('parts/SKUList.php')?>
        </div>
    <?}?>
    <?if ($options['CATALOG_PRODUCT_VIEW']['ACTIVE_VALUE'] == "WITH_TABS"){?>
        <div class="uni-indents-vertical indent-50"></div>
        <div class="row">
            <?include('parts/ViewWithTabs.php')?>
        </div>
    <?} else if ($options['CATALOG_PRODUCT_VIEW']['ACTIVE_VALUE'] == "WITHOUT_TABS"){?>
        <div class="row">
            <?include('parts/ViewWithoutTabs.php')?>
        </div>
    <?}else if ($options['CATALOG_PRODUCT_VIEW']['ACTIVE_VALUE'] == "WITH_TABS_UP"){?>
        <?if (is_array($arResult["PROPERTIES"]["EXPANDABLES"]["VALUE"]) && count($arResult["PROPERTIES"]["EXPANDABLES"]["VALUE"]) > 0){?>
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
                        )
                    );?>
                </div>
                <div class="clear"></div>
            </div>
        <?}?>
    <?}?>
	<?if (!empty($arResult["PROPERTIES"]["ASSOCIATED"]["VALUE"])):?>
		<div class="uni-indents-vertical indent-50"></div>
		<div class="row">
			<?$GLOBALS["arrFilter"] = array("ID" => $arResult["PROPERTIES"]["ASSOCIATED"]["VALUE"]);?> 		 	
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
					"FLEXISEL_ID" => "associatedList",
					"TITLE" => GetMessage('PRODUCT_GOING_GOODS'),
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
	<?endif;?>
	<div class="uni-indents-vertical indent-50"></div>
	<div class="row">
		<?$APPLICATION->IncludeComponent(
			"bitrix:sale.viewed.product", 
			"slider", 
			array(
				"VIEWED_COUNT" => "8",
				"VIEWED_NAME" => "Y",
				"VIEWED_IMAGE" => "Y",
				"VIEWED_PRICE" => "Y",
				"VIEWED_CURRENCY" => (($arParams['CONVERT_CURRENCY'] == 'Y') ? $arParams['VIEWED_CURRENCY'] : 'default'),
				"VIEWED_CANBUY" => "N",
				"VIEWED_CANBASKET" => "N",
				"VIEWED_IMG_HEIGHT" => "60",
				"VIEWED_IMG_WIDTH" => "70",
				"BASKET_URL" => "/personal/basket.php",
				"ACTION_VARIABLE" => "action",
				"PRODUCT_ID_VARIABLE" => "id",
				"SET_TITLE" => "N",
				"COMPONENT_TEMPLATE" => "slider",
				"LINE_ELEMENT_COUNT" => '4',
				"VIEWED_TITLE" => GetMessage('PRODUCT_YOU_LOOKED')
			),
			$component
		);?>
	</div>
	<?if ($options['CATALOG_PRODUCT_VIEW']['ACTIVE_VALUE'] == "WITHOUT_TABS"):?>
		<?if(is_numeric($arParams['REVIEWS_IBLOCK_ID'])):?>
			<div class="uni-indents-vertical indent-50"></div>
			<div class="row">
				<div class="title"><?=GetMessage('PRODUCT_REVIEWS')?></div>
				<div class="uni-indents-vertical indent-15"></div>
				<div id="reviews" class="item_description">
					<?$APPLICATION->IncludeComponent(
						"intec:reviews", 
						"reviews", 
						array(
							"IBLOCK_TYPE" => "reviews",
							"IBLOCK_ID" => $arParams['REVIEWS_IBLOCK_ID'],
							"ELEMENT_ID" => $arResult['ID'],
							"DISPLAY_REVIEWS_COUNT" => $arParams['MESSAGES_PER_PAGE']
						),
						$component
					);?>
				</div>
				<div class="clear"></div>
			</div>
		<?endif;?>
	<?endif;?>
</div>
<?if ($options['CATALOG_PRODUCT_MENU']['ACTIVE_VALUE'] == "Y"):?>
    </div>
<?endif;?>
		<div style="clear: both;"></div>
<?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
	foreach ($arResult['JS_OFFERS'] as &$arOneJS)
	{
		if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE'])
		{
			$arOneJS['PRICE']['PRINT_DISCOUNT_DIFF'] = GetMessage('ECONOMY_INFO', array('#ECONOMY#' => $arOneJS['PRICE']['PRINT_DISCOUNT_DIFF']));
			$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];
		}
		$strProps = '';
			if (!empty($arOneJS['DISPLAY_PROPERTIES']))
			{
				foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp)
				{
					$strProps .= '<dt>'.$arOneProp['NAME'].'</dt><dd>'.(
						is_array($arOneProp['VALUE'])
						? implode(' / ', $arOneProp['VALUE'])
						: $arOneProp['VALUE']
					).'</dd>';
				}
			}
		$arOneJS['DISPLAY_PROPERTIES'] = $strProps;
	}
	if (isset($arOneJS))
		unset($arOneJS);
	$arJSParams = array(
		'CONFIG' => array(
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
			'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
			'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE']
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
			'CURRENT_PATH' => $this->GetFolder(),
			'ONE_CLICK_BUY' => $arItemIDs['ONE_CLICK_BUY'],
		),
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'NAME' => $arResult['~NAME']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $arSkuProps
	);
}
else
{
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
	{
?>
<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
<?
		if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
		{
			foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
			{
?>
	<input
		type="hidden"
		name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
		value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>"
	>
<?
				if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
					unset($arResult['PRODUCT_PROPERTIES'][$propID]);
			}
		}
		$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
		if (!$emptyProductProperties)
		{
?>
	<table>
<?
			foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo)
			{
?>
	<tr><td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
	<td>
<?
				if(
					'L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE']
					&& 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']
				)
				{
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><label><input
							type="radio"
							name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"
							value="<? echo $valueID; ?>"
							<? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>
						><? echo $value; ?></label><br><?
					}
				}
				else
				{
					?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><option
							value="<? echo $valueID; ?>"
							<? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>
						><? echo $value; ?></option><?
					}
					?></select><?
				}
?>
	</td></tr>
<?
			}
?>
	</table>
<?
		}
?>
</div>
<?
	}
	$arJSParams = array(
		'CONFIG' => array(
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
			'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
			'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE']
		),
		'VISUAL' => array(
			'ID' => $arItemIDs['ID']			
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'PICT' => $arFirstPhoto,
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'PRICE' => $arResult['MIN_PRICE'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
			'BUY_URL' => $arResult['~BUY_URL'],
		),
		'BASKET' => array(
			'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL']
		)
	);
	unset($emptyProductProperties);
}

?>
<script type="text/javascript">
$("#tabs").tabs();

<?if ($options['CATALOG_SKU_VIEW']['ACTIVE_VALUE'] == 'DYNAMIC' && !empty($arResult['OFFERS'])):?>
	product.structure = <? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>;
	product.structure['ID'] = <?=$arResult['ID']?>;
	product.selectors.offer.offers = ".offers";
	product.selectors.offer.offer = ".offer";
	product.selectors.offer.items = ".items";
	product.selectors.offer.item = ".item";
	product.selectors.price = "#price";
    product.selectors.skuProp = "#sku_prop";
	product.selectors.priceDiscount = "#discount_price";
	product.selectors.quantity = "#quantity";
	product.selectors.quantityPrefix = "#quantity_prefix";
	product.selectors.quantityBox = "#quantity_box";
	product.selectors.quantityAvailable = "#quantity_available";
	product.selectors.quantityUnavailable = "#quantity_unavailable";
	product.selectors.buyButton = '.buy .buy';
	product.selectors.buyOneClickButton = '.buy .one-click-buy';
	product.selectors.buyBlock = '.buy-block';
	product.selectors.minButtons = '.min-buttons';
	product.selectors.minButtonCompare = '.compare';
	product.selectors.minButtonLike = '.like';
	product.selectors.slider = '.image-slider';
	product.selectors.sliderList = '.list';
	product.selectors.sliderImages = '.slider-images';
	product.setOfferFirst();
<?endif;?>

BX.message({
	MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCE_CATALOG_BUY')); ?>',
	MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCE_CATALOG_ADD')); ?>',
	MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCE_CATALOG_NOT_AVAILABLE')); ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE') ?>'
});
//params
	//@id
	//@name
	//@iblock_type
	//@iblock_id
	//@new_price
	//@old_price
	//@image
	function add_to_onclick(params){		
		//$(thiselem).unbind('click').removeAttr("onclick").attr("href", href);
		//$(thiselem).html(text);
		//$(thiselem).addClass('added');	
		var oneclickBuyPopup = BX.PopupWindowManager.create("OneClickBuy"+params.id, null, {
			autoHide: true,			
			offsetLeft: 0,
			offsetTop: 0,
			overlay : true,
			draggable: {restrict:true},
			closeByEsc: true,
			closeIcon: { right : "20px", top : "11px"},
			content: '<div style="width:586px;height:435px; text-align: center;"><span style="position:absolute;left:50%; top:50%"><img src="<?=SITE_DIR?>images/please_wait.gif"/></span></div>',
			events: {
				onAfterPopupShow: function()
				{
					BX.ajax.post(
						'<?=SITE_DIR?>ajax/one_click_buy.php',
						{ 
							"IBLOCK_TYPE":params.iblock_type,
							"IBLOCK_ID":params.iblock_id,
							"ELEMENT_ID":params.id,
							"NAME_PRODUCT":params.name,
							"NEW_PRICE":params.new_price,
							"OLD_PRICE":params.old_price,
							"IMAGE":params.image,
							"PRICE_ID":params.price_id,
							"PRICE":params.price,
							"DEFAULT_PERSON_TYPE": params.person_id,
							"DEFAULT_DELIVERY": params.delivery_id,
							"DEFAULT_PAYMENT": params.payment_id
						},
						BX.delegate(function(result)
						{
							this.setContent(result)
						},
						this)
					);
				}
			}
		});
		oneclickBuyPopup.show();	
	}
</script>
<?$frame->end()?>