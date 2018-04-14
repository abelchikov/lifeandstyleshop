<div class="row">
	<div class="price minimal">
		<?if ($arResult['MIN_PRICE']['VALUE'] == $arResult['MIN_PRICE']['DISCOUNT_VALUE']):?>
			<div class="current" id="price"><?=$arResult['MIN_PRICE']['PRINT_VALUE']?></div>
		<?else:?>
			<div class="current" id="discount_price"><?=$arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></div>
			<?if ($arParams['SHOW_OLD_PRICE'] == 'Y'):?>
				<div class="old" id="price"><?=$arResult['MIN_PRICE']['PRINT_VALUE']?></div>
			<?endif;?>
		<?endif;?>
	</div>
    <div class="uni-indents-vertical indent-25"></div>
    <?if ($arResult['SHOW_OFFERS_PROPS']) {?>
        <dl class="prop_sku" id="sku_prop">

        </dl>
    <?}?>
	<div class="uni-indents-vertical indent-25"></div>
	<div class="offers">
		<?foreach ($arResult['SKU_PROPS'] as &$arProp):?>
			<?if (!isset($arResult['OFFERS_PROP'][$arProp['CODE']]))
				continue;
			
			$arSkuProps[] = array(
				'ID' => $arProp['ID'],
				'SHOW_MODE' => $arProp['SHOW_MODE'],
				'VALUES_COUNT' => $arProp['VALUES_COUNT']
			);?>
			<?if ($arProp['SHOW_MODE'] == 'TEXT'):?>
				<div class="offer text" id="<?=$arItemIDs['PROP'].$arProp['ID']; ?>_offer">
					<div class="header"><?=htmlspecialcharsex($arProp['NAME'])?>:</div>
					<div class="scroller">
						<div class="items" id="<?='PROP_'.$arProp['ID']?>">
							<?foreach ($arProp['VALUES'] as $arOneValue):?>
								<div class="item hover-shadow" id="<?='PROP_'.$arProp['ID'].'_'.$arOneValue['ID']?>" onClick="product.selectWithProperty('<?='PROP_'.$arProp['ID']?>', <?=$arOneValue['ID']?>); return false;">
									<span>
										<?=htmlspecialcharsbx($arOneValue['NAME'])?>
									</span>
								</div>
							<?endforeach;?>
						</div>
					</div>
				</div>
			<?elseif ($arProp['SHOW_MODE'] == 'PICT'):?>
				<div class="offer picture" id="<?=$arItemIDs['PROP'].$arProp['ID']; ?>_cont">
					<span class="header"><?=htmlspecialcharsex($arProp['NAME'])?>:</span>
					<div class="scroller">
						<div class="items" id="<?=$arItemIDs['PROP'].$arProp['ID']; ?>" style="width: <? echo $strWidth; ?>;margin-left:0%;">
							<?foreach ($arProp['VALUES'] as $arOneValue):?>
								<div class="item hover-shadow" id="<?='PROP_'.$arProp['ID'].'_'.$arOneValue['ID']?>" onClick="product.selectWithProperty('<?='PROP_'.$arProp['ID']?>', <?=$arOneValue['ID']?>); return false;">
									<?if ($arOneValue['NA']):?>
										<span style="margin-left: 7px; margin-right: 7px;">
											-
										</span>
									<?else:?>
										<div class="image">
											<img src="<?=$arOneValue['PICT']['SRC']?>"/>
										</div>
									<?endif;?>
								</div>
							<?endforeach;?>
						</div>
					</div>
				</div>
			<?endif;?>
		<?endforeach;?>
		<?unset($arProp);?>	
	</div>
</div>
<div class="uni-indents-vertical indent-25"></div>
<div class="order">
	<div class="valign"></div>
	<div class="buy-block">
		<div class="count">
			<button id="decrease" class="uni-button">-</button>
			<input type="text" name="count" value="<?=$arResult['CATALOG_MEASURE_RATIO']?>" />
			<button id="increase" class="uni-button">+</button>
			<script type="text/javascript">	
				product.count.value = <?=$arResult['CATALOG_MEASURE_RATIO']?>;
				product.count.minimum = <?=$arResult['CATALOG_MEASURE_RATIO']?>;
				product.count.ratio = <?=$arResult['CATALOG_MEASURE_RATIO']?>;
				product.count.maximum = <?=$arResult['CATALOG_QUANTITY']?>;
				<?if ($arResult['CATALOG_CAN_BUY_ZERO'] == "Y" || $arResult['CATALOG_QUANTITY_TRACE'] == "N"):?>
					product.count.unlimited = true;
				<?endif;?>
												
				$(document).ready(function(){
														
					$('.count #decrease').click(function(){	
						product.count.decrease();
					})
					
					$('.count #increase').click(function(){
						product.count.increase();
					})
					
					product.count.setControls('.count input[type=text]');
				})
			</script>
		</div>
		<div class="uni-indents-horizontal indent-10"></div>
		<div class="buy">
			<?if ($arParams['OCB_USE'] == 'Y') {?>
			<?foreach ($arResult['OFFERS'] as $arOffer):?>
				<?if (!empty($arOffer['PREVIEW_PICTURE'])):?>
					<?$photo = CFile::ResizeImageGet($arOffer['PREVIEW_PICTURE'], array('width' => 170, 'height' => 170), BX_RESIZE_IMAGE_PROPORTIONAL)?>							
				<?elseif(!empty($arOffer['MORE_PHOTO'])):?>
						<?$photo['src'] = $arOffer['MORE_PHOTO'][0]['SRC']?>
				<?else:?>
					<?$photo = array()?>
					<?if (!empty($arResult['DETAIL_PICTURE'])):?>
						<?$photo['src'] = $arResult['DETAIL_PICTURE']['SRC']?>
					<?elseif(!empty($arResult['PREVIEW_PICTURE'])):?>
						<?$photo['src'] = $arResult['PREVIEW_PICTURE']['SRC']?>
					<?else:?>
						<?$photo['src'] = SITE_TEMPLATE_PATH.'/images/noimg/noimg_quadro.jpg'?>
					<?endif;?>
				<?endif;?>
				<?$arBuyOneClickParams = array (
					"id"=>$arOffer["ID"],
					"name"=> $arResult["NAME"],
					"iblock_type"=>$arParams["IBLOCK_TYPE"],
					"iblock_id"=>$arParams["IBLOCK_ID"],
					"new_price"=> $arOffer['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
					"old_price"=> $arOffer['MIN_PRICE']['PRINT_VALUE']?"":$arOffer['MIN_PRICE']['PRINT_VALUE'],
					"image"=> $photo['src'],
					"price_id" => $arResult['MIN_BASIS_PRICE']['PRICE_ID'],
					"price" => $arOffer['MIN_PRICE']['VALUE'],
					"delivery_id" => $arParams['OCB_TYPE_DELIVERY'],
					"person_id" => $arParams['OCB_TYPE_PERSON'],
					"payment_id" => $arParams['OCB_TYPE_PAYMENT']
				);
				$j_params = CUtil::PhpToJSObject($arBuyOneClickParams);?>
				<a 
					href="javascript:void(0);" 
					id="one_click_buy_dynamic_<?=$arOffer['ID']?>"
					class="uni-button one-click-buy" 
					onclick="return add_to_onclick(<?=$j_params?>)"
					style="display: none;"
				>
					<span><?=GetMessage("ONE_CLICK_BUY")?></span>
				</a>
			<?endforeach;?>
			<?}?>
		</div>
		<div class="uni-indents-horizontal indent-10"></div>
		<div class="buy">	
			<?foreach ($arResult['OFFERS'] as $arOffer):?>
				<a rel="nofollow" class="uni-button solid_button buy" id="buy_dynamic_<?=$arOffer['ID']?>"
						onclick="return product.addToCart();"
						style="display: none;"
					><?=GetMessage("CATALOG_ADD_TO_BASKET")?>
				</a>
				<a rel="nofollow" href="<?=$arParams["BASKET_URL"];?>" id="buyed_dynamic_<?=$arOffer['ID']?>" class="uni-button solid_button buy buy_added" style="display: none;">
					<?=GetMessage("CATALOG_ADDED")?>
				</a>
			<?endforeach;?>
		</div>
		<div class="uni-indents-horizontal indent-20"></div>
	</div>
	<?foreach ($arResult['OFFERS'] as $arOffer):?>
		<div class="min-buttons" id="min_buttons_<?=$arOffer['ID']?>" style="display: none;">
			<?if($arParams["DISPLAY_COMPARE"]=="Y"):?>
				<div class="min-button compare">
					<div class="add"
						onclick="add_to_compare(this,'<?=$arParams['IBLOCK_TYPE']?>','<?=$arParams["IBLOCK_ID"]?>','<?=$arParams["COMPARE_NAME"]?>','<?=$arOffer['COMPARE_URL']?>')"
						id="textcomp_<?=$arOffer["ID"]?>"		
						title="<?=GetMessage('COMPARE_TEXT_DETAIL')?>"
					>
					</div>
					<div  class="remove"
						style="display:none"
						id="addedcomp_<?=$arOffer["ID"]?>" 
						onclick="return delete_to_compare(this,'<?=$arParams['IBLOCK_TYPE']?>','<?=$arParams["IBLOCK_ID"]?>','<?=$arParams["COMPARE_NAME"]?>','<?=SITE_DIR?>catalog/compare.php?action=DELETE_FROM_COMPARE_RESULT&ID=<?=$arOffer['ID']?>')"
						title="<?=GetMessage('COMPARE_DELETE_TEXT_DETAIL')?>"
					>
					</div>
				</div>
			<?endif?>
			<div class="min-button like">
				<div class="add"								
					onclick="return product.addToLike()"
					id="like_dynamic_<?=$arOffer["ID"]?>"
					title="<?=GetMessage('LIKE_TEXT_DETAIL')?>"
				>
                    <i class="fa fa-star-o"></i>
				</div>
				<div class="remove"
					style="display:none"
					id="liked_dynamic_<?=$arOffer["ID"]?>"								
					onclick="return product.deleteToLike();"
					title="<?=GetMessage('LIKE_DELETE_TEXT_DETAIL')?>"
				>
                    <i class="fa fa-star-o"></i>
				</div>
			</div>
		</div>
	<?endforeach;?>
</div>