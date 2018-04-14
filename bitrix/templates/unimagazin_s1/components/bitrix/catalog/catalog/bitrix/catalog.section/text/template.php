<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
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

//$APPLICATION->SetAdditionalCSS($templateFolder."/style.css", true);

?>
<?if (!empty($arResult['ITEMS'])) {?>
	<? if ($arParams["DISPLAY_TOP_PAGER"]) { ?>
		<?= $arResult["NAV_STRING"] ?>
		<div class="uni-indents-vertical indent-20"></div>
	<? } ?>
    <div class="catalog-section">
    	<?
			$frame = $this->createFrame()->begin();
			$strElementEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT");
			$strElementDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE");
			$arElementDeleteParams = array("CONFIRM" => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
			
			foreach ($arResult["ITEMS"] as $cell => $arElement) {
			
				$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], $strElementEdit);
				$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], $strElementDelete, $arElementDeleteParams);
				$strMainID = $this->GetEditAreaId($arElement['ID']);
				
				$arItemIDs = array(
					'ID' => $strMainID,
					'PICT' => $strMainID.'_pict',
					'SECOND_PICT' => $strMainID.'_secondpict',
		
					'QUANTITY' => $strMainID.'_quantity',
					'QUANTITY_DOWN' => $strMainID.'_quant_down',
					'QUANTITY_UP' => $strMainID.'_quant_up',
					'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
					'BUY_LINK' => $strMainID.'_buy_link',
					'SUBSCRIBE_LINK' => $strMainID.'_subscribe',
		
					'PRICE' => $strMainID.'_price',
					'DSC_PERC' => $strMainID.'_dsc_perc',
					'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',
		
					'PROP_DIV' => $strMainID.'_sku_tree',
					'PROP' => $strMainID.'_prop_',
					'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
					'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
				);
		?>	
    		
        	<div class="element hover_shadow" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
        		<div class="name">
        			<div><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></div>
        		</div>	
        		<?
					$flg_offers=0;
					$flg_offers_can_buy = false;
        			$newprice = preg_replace( "/^([\d\s\.\,]+)(.*)$/", '$1<span>$2</span>', $arElement["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"] );
        			$oldprice = "";
        			if( $arElement['MIN_PRICE']['DISCOUNT_VALUE'] < $arElement['MIN_PRICE']['VALUE'] ) {
        				$oldprice= preg_replace ( "/^([\d\s\.\,]+)(.*)$/", '$1<span>$2</span>', $arElement["MIN_PRICE"]["PRINT_VALUE"] );
        			}	
        			if( !empty($arElement["OFFERS"]) ){
        				$flg_offers=1;		
						
						$arOffer = current($arElement['OFFERS']);
						$newpricenum = $arOffer['MIN_PRICE']['DISCOUNT_VALUE'];
						$newprice = preg_replace( "/^([\d\s\.\,]+)(.*)$/", '$1<span>$2</span>', $arOffer['MIN_PRICE']["PRINT_DISCOUNT_VALUE"]);
						if( $arOffer['MIN_PRICE']['DISCOUNT_VALUE'] < $arOffer['MIN_PRICE']['VALUE'] ) {
							$oldprice= preg_replace ( "/^([\d\s\.\,]+)(.*)$/", '$1<span>$2</span>', $arOffer["MIN_PRICE"]["PRINT_VALUE"] );
						}
							
						foreach ($arElement["OFFERS"] as $arOffer)
						{
							if ($newpricenum > $arOffer['MIN_PRICE']['DISCOUNT_VALUE']) {
								$newpricenum = $arOffer['MIN_PRICE']['DISCOUNT_VALUE'];
								$newprice = preg_replace( "/^([\d\s\.\,]+)(.*)$/", '$1<span>$2</span>', $arOffer['MIN_PRICE']["PRINT_DISCOUNT_VALUE"]);
								if( $arOffer['MIN_PRICE']['DISCOUNT_VALUE'] < $arOffer['MIN_PRICE']['VALUE'] ) {
									$oldprice= preg_replace ( "/^([\d\s\.\,]+)(.*)$/", '$1<span>$2</span>', $arOffer["MIN_PRICE"]["PRINT_VALUE"] );
								}
							}
							if ($arOffer['CAN_BUY'])
							{
								$flg_offers_can_buy = true;
							}
						}
						
        				$newprice="<span>".GetMessage("CT_BCS_TPL_MESS_PRICE_FROM")." </span>".$newprice;
						
                        if (!empty($oldprice))
                            $oldprice = GetMessage("CT_BCS_TPL_MESS_PRICE_FROM").' '.$oldprice;
        		}?>	
        		<div class="buys">		
        			<div class="price">
        				<div class="new"><?=$newprice?></div>
        				<?if($oldprice!=""){?>
        					<div class="old"><?=$oldprice?></div>
        				<?}?>				
        			</div>
                    <div class="min-buttons">
                        <?if (!$flg_offers && ($arElement['CAN_BUY'] || $arParams["DISPLAY_COMPARE"]=="Y")):?>
            				<?if ($arElement['CAN_BUY']):?>
            					<div class="min-button like">
            						<div class="add"								
            							onclick="add_to_like(this,'<?=$arElement['ID']?>',1);"
            							id="like_<?=$arElement["ID"]?>"
            							title="<?=GetMessage('LIKE_TEXT_DETAIL')?>"
            						>
                                        <i class="fa fa-star-o"></i>
            						</div>
            						<div class="remove"
            							style="display:none"
            							id="liked_<?=$arElement["ID"]?>"								
            							onclick="return delete_to_like(this,'<?=$arElement['ID']?>',1);"
            							title="<?=GetMessage('LIKE_DELETE_TEXT_DETAIL')?>"
            						>
                                        <i class="fa fa-star-o"></i>
            						</div>
            					</div>
                            <?endif?>
							<?if($arParams["DISPLAY_COMPARE"]=="Y"):?>
            					<div class="min-button compare">
            						<div class="add"
            							onclick="add_to_compare(this,'<?=$arParams['IBLOCK_TYPE']?>','<?=$arParams["IBLOCK_ID"]?>','<?=$arParams["COMPARE_NAME"]?>','<?=$arElement['COMPARE_URL']?>')"
            							id="textcomp_<?=$arElement["ID"]?>"		
										title="<?=GetMessage('COMPARE_TEXT_DETAIL')?>"
            						>
            							<?//echo GetMessage("CATALOG_COMPARE")?>
            						</div>
            						<div  class="remove"
            							style="display:none"
            							id="addedcomp_<?=$arElement["ID"]?>" 
            							onclick="return delete_to_compare(this,'<?=$arParams['IBLOCK_TYPE']?>','<?=$arParams["IBLOCK_ID"]?>','<?=$arParams["COMPARE_NAME"]?>','<?=SITE_DIR?>catalog/compare.php?action=DELETE_FROM_COMPARE_RESULT&ID=<?=$arElement['ID']?>')"
										title="<?=GetMessage('COMPARE_DELETE_TEXT_DETAIL')?>"
									>
            							<?//echo GetMessage("CATALOG_COMPARED")?>
            						</div>
            					</div>
            				<?endif?>
                        <?endif?>
                    </div>
        			<?if ( $arElement['CAN_BUY'] || ($flg_offers && $flg_offers_can_buy)) {?>
						<div class="buy">
							<a rel="nofollow" class="uni-button solid_button buy" id="buy_<?=$arElement['ID']?>"
								<?if(!$flg_offers){?>
									onclick="return add_to_cart(<?=$arElement['ID']?>,'<?=GetMessage("CATALOG_ADDED")?>',this,<?=$arElement['CATALOG_MEASURE_RATIO']?>,'<?=$arParams["BASKET_URL"];?>','<?=$arElement['ID']?>','<?=$arParams['IBLOCK_ID']?>','<?=$arParams['IBLOCK_TYPE']?>')"
								<?}else{?>
									href="<?=$arElement["DETAIL_PAGE_URL"]?>"
								<?}?>>
								<?if (!$flg_offers):?>
									<?=GetMessage("CATALOG_ADD_TO_BASKET")?>
								<?else:?>
									<?=GetMessage("CATALOG_EXTEND")?>
								<?endif;?>
							</a>
							<a rel="nofollow" href="<?=$arParams["BASKET_URL"];?>" id="buyed_<?=$arElement['ID']?>" class="uni-button solid_button buy buy_added" style="display: none;">
								<?=GetMessage("CATALOG_ADDED")?>
							</a>
        				</div>
        			<?} else{?>
						<div class="state unavailable">
							<?=GetMessage('PRODUCT_NOT_HAVE')?>
						</div>
        			<?}?>
        			<div class="clear"></div>
        		</div>
        		<div class="clear"></div>
        	</div>
    	<? } ?>
    	<?$frame->end()?>
    </div>
    <div class="clear"></div>
	<? if ($arParams["DISPLAY_BOTTOM_PAGER"]) { ?>
		<div class="uni-indents-vertical indent-20"></div>
		<?= $arResult["NAV_STRING"] ?>
	<? } ?>
<? } ?>
    
