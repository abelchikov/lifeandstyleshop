<div class="price">
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
<div class="order">
	<div class="valign"></div>
	<?if ($arResult['CAN_BUY']): // Если можно купить?>
		<div class="count">
			<button id="decrease" class="uni-button">-</button>
			<input type="text" name="count" value="<?=$arResult['CATALOG_MEASURE_RATIO']?>" />
			<button id="increase" class="uni-button">+</button>
			<script type="text/javascript">	
				var counter = new CapitalProductCount()
				counter.value = <?=$arResult['CATALOG_MEASURE_RATIO']?>;
				counter.minimum = <?=$arResult['CATALOG_MEASURE_RATIO']?>;
				counter.ratio = <?=$arResult['CATALOG_MEASURE_RATIO']?>;
				counter.maximum = <?=$arResult['CATALOG_QUANTITY']?>;
				<?if ($arResult['CATALOG_CAN_BUY_ZERO'] == "Y" || $arResult['CATALOG_QUANTITY_TRACE'] == "N"):?>
					counter.unlimited = true;
				<?endif;?>
												
				$(document).ready(function(){
														
					$('.count #decrease').click(function(){	
						counter.decrease();
					})
					
					$('.count #increase').click(function(){
						counter.increase();
					})
					
					counter.setControls('.count input[type=text]');
				})
			</script>
		</div>
		<div class="uni-indents-horizontal indent-10"></div>
		<div class="buy">
			<?if ($arParams['OCB_USE'] == 'Y') {?>
			<?$arBuyOneClickParams = array (
				"id"=>$arResult["ID"],
				"name"=>$arResult["NAME"],
				"iblock_type"=>$arParams["IBLOCK_TYPE"],
				"iblock_id"=>$arParams["IBLOCK_ID"],
				"new_price"=>$arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE'],
				"old_price"=> $arResult['MIN_PRICE']['PRINT_VALUE']?"":$arResult['MIN_PRICE']['PRINT_VALUE'],
				"image"=>$arResult['DETAIL_PICTURE']['SRC'],
				"price_id" => $arResult['MIN_BASIS_PRICE']['PRICE_ID'],
				"price" => $arResult['MIN_PRICE']['VALUE'],
				"delivery_id" => $arParams['OCB_TYPE_DELIVERY'],
				"person_id" => $arParams['OCB_TYPE_PERSON'],
				"payment_id" => $arParams['OCB_TYPE_PAYMENT']
			);
			$j_params = CUtil::PhpToJSObject($arBuyOneClickParams);?>
			<a 
				href="javascript:void(0);" 
				class="uni-button one-click-buy" 
				onclick="return add_to_onclick(<?=$j_params?>)"
			>
				<span><?=GetMessage("ONE_CLICK_BUY")?></span>
			</a>
			<?}?>
		</div>
		<div class="uni-indents-horizontal indent-10"></div>
		<div class="buy">			
			<a rel="nofollow" class="uni-button solid_button buy" id="buy_<?=$arResult['ID']?>"
				onclick="return add_to_cart(<?=$arResult['ID']?>,'<?=GetMessage("CATALOG_ADDED")?>',this, counter.value,'<?=$arParams["BASKET_URL"];?>','<?=$arResult['ID']?>','<?=$arParams['IBLOCK_ID']?>','<?=$arParams['IBLOCK_TYPE']?>');"
			><?=GetMessage("CATALOG_ADD_TO_BASKET")?>
			</a>
			<a rel="nofollow" href="<?=$arParams["BASKET_URL"];?>" id="buyed_<?=$arResult['ID']?>" class="uni-button solid_button buy buy_added" style="display: none;">
				<?=GetMessage("CATALOG_ADDED")?>
			</a>
		</div>
		<div class="uni-indents-horizontal indent-20"></div>
	<?endif;?>
	<div class="min-buttons">
		<?if($arParams["DISPLAY_COMPARE"]=="Y"):?>
			<div class="min-button compare">
				<div class="add"
					onclick="add_to_compare(this,'<?=$arParams['IBLOCK_TYPE']?>','<?=$arParams["IBLOCK_ID"]?>','<?=$arParams["COMPARE_NAME"]?>','<?=$arResult['COMPARE_URL']?>')"
					id="textcomp_<?=$arResult["ID"]?>"
					title="<?=GetMessage('COMPARE_TEXT_DETAIL')?>"					
				>
				</div>
				<div  class="remove"
					style="display:none"
					id="addedcomp_<?=$arResult["ID"]?>" 
					onclick="return delete_to_compare(this,'<?=$arParams['IBLOCK_TYPE']?>','<?=$arParams["IBLOCK_ID"]?>','<?=$arParams["COMPARE_NAME"]?>','<?=SITE_DIR?>catalog/compare.php?action=DELETE_FROM_COMPARE_RESULT&ID=<?=$arResult['ID']?>')"
					title="<?=GetMessage('COMPARE_DELETE_TEXT_DETAIL')?>"
				>
				</div>
			</div>
		<?endif?>
		<?if ($arResult['CAN_BUY']):?>
			<div class="min-button like">
				<div class="add"								
					onclick="add_to_like(this,'<?=$arResult['ID']?>',1);"
					id="like_<?=$arResult["ID"]?>"
					title="<?=GetMessage('LIKE_TEXT_DETAIL')?>"
				>
                    <i class="fa fa-star-o"></i>
				</div>
				<div class="remove"
					style="display:none"
					id="liked_<?=$arResult["ID"]?>"								
					onclick="return delete_to_like(this,'<?=$arResult['ID']?>',1);"
					title="<?=GetMessage('LIKE_DELETE_TEXT_DETAIL')?>"
				>
                    <i class="fa fa-star-o"></i>
				</div>
			</div>
		<?endif;?>
	</div>
</div>