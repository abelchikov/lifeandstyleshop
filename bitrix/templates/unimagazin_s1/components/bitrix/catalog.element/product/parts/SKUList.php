<table class="prices" cellspacing="0" cellpadding="0" border="0">
	<tr class="header">
		<td></td>
		<?if ($arResult['CATALOG_QUANTITY_TRACE'] == 'Y'):?><td><?=GetMessage('PRODUCT_SKULIST_HAVE')?></td><?endif;?>
		<?foreach($arResult['SKU_PROPS'] as $arSkuProp):?>
			<?foreach($arResult['OFFERS'] as $arOffer):?>
				<?if (!empty($arOffer['TREE']['PROP_'.$arSkuProp['ID']])):?>
					<td><?=$arSkuProp['NAME']?></td>
					<?break;?>
				<?endif;?>
			<?endforeach;?>
		<?endforeach;?>
		<td><?=GetMessage('PRODUCT_SKULIST_PRICE')?></td>
		<td></td>
		<td></td>
        <td></td>
		<td></td>
	</tr>
	<?foreach($arResult['OFFERS'] as $arOffer):?>
		<?if (!empty($arOffer['PREVIEW_PICTURE'])):?>
			<?$photo = CFile::ResizeImageGet($arOffer['PREVIEW_PICTURE'], array('width' => 170, 'height' => 170), BX_RESIZE_IMAGE_PROPORTIONAL)?>							
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
		<tr class="rows">
			<td>
				<div class="image">
					<div class='valign'></div>
					<img src="<?=$photo['src']?>" />
				</div>
			</td>
			<?if ($arResult['CATALOG_QUANTITY_TRACE'] == 'Y'):?><td>
				<div class="state available" style="<?=$arOffer['CATALOG_AVAILABLE'] != 'Y'?'display: none;':''?>">
					<div class="icon"></div>
					<?=GetMessage('PRODUCT_HAVE')?>
					<?if ($arParams['SHOW_MAX_QUANTITY'] == 'Y' && $arOffer['CATALOG_QUANTITY'] > 0):?>
						<?=$arOffer['CATALOG_QUANTITY']?> <?=$arOffer['CATALOG_MEASURE_NAME']?>.
					<?endif;?>
				</div>
				<div class="state unavailable" style="<?=$arOffer['CATALOG_AVAILABLE'] == 'Y'?'display: none;':''?>">
					<div class="icon"></div>
					<?=GetMessage('PRODUCT_NOT_HAVE')?>
				</div>
			</td><?endif;?>
			<?foreach($arResult['SKU_PROPS'] as $arSkuProp):?>
				<?$value = $arSkuProp['VALUES'][$arOffer['TREE']['PROP_'.$arSkuProp['ID']]]['NAME']?>
				<?if (!empty($value)):?>
					<td><div><span class="sku-adaptiv-title"><?=$arSkuProp['NAME']?>:</span> <?=$value?></div></td>
				<?endif;?>
			<?endforeach;?>
			<td class="price"><div><?=$arOffer['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></div></td>
			<td style="width: 130px; white-space: nowrap;">
				<?if ($arOffer['CAN_BUY']):?>
					<div class="count" id="count<?=$arOffer['ID']?>" style="margin-left: 5px; margin-right: 5px;">
						<button id="decrease" class="uni-button">-</button>
						<input type="text" name="count" value="<?=$arResult['CATALOG_MEASURE_RATIO']?>" />
						<button id="increase" class="uni-button">+</button>
						<script type="text/javascript">	
							var count<?=$arOffer['ID']?> = new CapitalProductCount();
							count<?=$arOffer['ID']?>.value = <?=$arOffer['CATALOG_MEASURE_RATIO']?>;
							count<?=$arOffer['ID']?>.minimum = <?=$arOffer['CATALOG_MEASURE_RATIO']?>;
							count<?=$arOffer['ID']?>.ratio = <?=$arOffer['CATALOG_MEASURE_RATIO']?>;
							count<?=$arOffer['ID']?>.maximum = <?=$arOffer['CATALOG_QUANTITY']?>;
							<?if ($arOffer['CATALOG_CAN_BUY_ZERO'] == "Y" || $arOffer['CATALOG_QUANTITY_TRACE'] == "N"):?>
								count<?=$arOffer['ID']?>.unlimited = true;
							<?endif;?>
															
							$(document).ready(function(){
																	
								$('#count<?=$arOffer['ID']?> #decrease').click(function(){	
									count<?=$arOffer['ID']?>.decrease();
								})
								
								$('#count<?=$arOffer['ID']?> #increase').click(function(){
									count<?=$arOffer['ID']?>.increase();
								})
								
								count<?=$arOffer['ID']?>.setControls('#count<?=$arOffer['ID']?> input[type=text]');
							})
						</script>
					</div>
				<?endif;?>
			</td>
            <td style="width: 216px;">
                <?if ($arOffer['CAN_BUY']):?>
                    <div class="buy" style="margin-left: 5px; margin-right: 5px;">
            			<?if ($arParams['OCB_USE'] == 'Y') {?>
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
            				class="uni-button one-click-buy" 
            				onclick="return add_to_onclick(<?=$j_params?>)"
							style="width: 206px;"
            			>
            				<span><?=GetMessage("ONE_CLICK_BUY")?></span>
            			</a>
						<?}?>
            		</div>
                <?endif;?>
            </td>
			<td style="width: 184px;">
				<?if ($arOffer['CAN_BUY']):?>
					<div class="buy" style="margin-right: 5px; margin-left: 5px;">			
							<a rel="nofollow" class="uni-button solid_button buy" style="width: 174px;" id="buy_<?=$arOffer['ID']?>"
								onclick="add_to_cart(<?=$arOffer['ID']?>,'<?=GetMessage("CATALOG_ADDED")?>',$(this),count<?=$arOffer['ID']?>.value,'<?=$arParams["BASKET_URL"];?>','<?=$arOffer['ID']?>','<?=$arParams['IBLOCK_ID']?>','<?=$arParams['IBLOCK_TYPE']?>')"><?=GetMessage("CATALOG_ADD_TO_BASKET")?>
							</a>
							<a rel="nofollow" href="<?=$arParams["BASKET_URL"];?>" id="buyed_<?=$arOffer['ID']?>" class="uni-button solid_button buy buy_added" style="width: 174px; display: none;">
								<?=GetMessage("CATALOG_ADDED")?>
							</a>
					</div>
				<?endif;?>
			</td>
			<td style="width: 66px; white-space: nowrap; text-align: right;">
				<?if($arParams["DISPLAY_COMPARE"]=="Y"):?>
					<div class="min-buttons" style="height: 36px;">
                        <div class="uni-aligner-vertical"></div>
						<?if ($arOffer['CAN_BUY']):?>
							<div class="min-button like">
								<div class="add"								
									onclick="add_to_like(this,'<?=$arOffer['ID']?>',1);"
									id="like_<?=$arOffer["ID"]?>"
									title="<?=GetMessage('LIKE_TEXT_DETAIL')?>"
								>
								</div>
								<div class="remove"
									style="display:none"
									id="liked_<?=$arOffer["ID"]?>"								
									onclick="return delete_to_like(this,'<?=$arOffer['ID']?>',1);"
									title="<?=GetMessage('LIKE_DELETE_TEXT_DETAIL')?>"
								>
								</div>
							</div>
						<?endif;?>
						<div class="min-button compare" style="margin-left: 10px;">
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
					</div>
				<?endif?>
			</td>
		</tr>
	<?endforeach;?>
</table>