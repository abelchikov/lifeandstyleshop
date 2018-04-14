<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<?$frame = $this->createFrame()->begin()?>

<?$display = array_key_exists("DIFFERENT", $_REQUEST) ? 'all' : 'differences' ;?>
<!--noindex-->
    <div class="uni-tabs">
    	<div class="tabs">
            <div class="tab<?=$_REQUEST["DIFFERENT"] == '' ? ' ui-state-active' : '';?>">
                <a rel="nofollow" href="<?=SITE_DIR;?>catalog/compare.php?action=COMPARE&IBLOCK_ID=<?=$arParams["IBLOCK_ID"]?>"><span><?=GetMessage('CATALOG_ALL_CHARACTERISTICS')?></span></a>
            </div>
    		<div class="tab<?=$_REQUEST["DIFFERENT"] != '' ? ' ui-state-active' : '';?>">
                <a rel="nofollow" href="<?=SITE_DIR;?>catalog/compare.php?action=COMPARE&IBLOCK_ID=<?=$arParams["IBLOCK_ID"]?>&DIFFERENT=Y"><span><?=GetMessage('CATALOG_ONLY_DIFFERENT')?></span></a>
            </div>
    		<div class="bottom-line"></div>
    	</div>
    </div>
	<div class="clear"></div>
<!--/noindex-->

<div class="differences_table">
<?if( count( $arResult["ITEMS"] ) > 4 ):?>
	<input type="hidden" name="start_position" value="<?=$arResult["START_POSITION"]?>" />
	<input type="hidden" name="end_position" value="<?=$arResult["END_POSITION"]?>" />
	<div class="left_arrow dec"></div>
	<div class="right_arrow inc"></div>
<?endif;?>
<table>
	<tr>
		<td class="preview"></td>
		<?$position = 0;?>
		<?foreach( $arResult["ITEMS"] as $arItem ){	
		  
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCT_ELEMENT_DELETE_CONFIRM')));
			?>
			<td class="item_td item_<?=$arItem["ID"]?>" <?=$position >= 4 ? 'style="display: none;"' : ''?>>
				<div class="table_item item_ws hover_shadow">
					<div class="remove_item"><a href="<?=SITE_DIR?>catalog/compare.php?action=DELETE_FROM_COMPARE_RESULT&ID=<?=$arItem['ID'];?>" class="delete"></a></div>
					<div class="image">
						<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="thumb_cat uni-image">
							<div class="uni-aligner-vertical"></div>
							
							<?if( !empty($arItem["PREVIEW_PICTURE"]) ){?>
								<?$file = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"],array('width'=>170, 'height'=>170),BX_RESIZE_IMAGE_PROPORTIONAL_ALT);?>
								<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
							<?}else{?>
								<img src="<?=SITE_TEMPLATE_PATH?>/images/noimg/no-img.png" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
							<?}?>
						</a>
						<!--<div class="marks">
							<?if($arItem["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"]){?>
								<span class="mark action">- <?=$arItem["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"];?> %</span>
							<?}?>
							<?if( $arItem["PROPERTIES"]["HIT"]["VALUE"] == true ){?>
								<span class="mark hit">Хит</span>
							<?}?>							
							<?if( $arItem["PROPERTIES"]["NEW"]["VALUE"] == true ){?>
								<span class="mark new">Новинка</span>
							<?}?>
						</div>-->
					</div>
					<a class="desc_name" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>

					<?if( !empty($arItem["OFFERS"]) ){?>
					
						<?
						$count_offers = 0;
						$min_offer_id = -1;
						$min_price = 0;
						
						foreach( $arItem["OFFERS"] as $key_offer => $arOffer ){
							foreach( $arOffer["PRICES"] as $key_price => $arPrice ){
								if( $arPrice["CAN_ACCESS"] == 'Y' && $arPrice["CAN_BUY"] == 'Y' ){
								
									if( $min_offer_id == -1 ){
										$min_offer_id = $key_offer;
										$min_price = $arPrice["PRICE"];
									}elseif( $arPrice["PRICE"] < $min_price ){
										$min_offer_id = $key_offer;
										$min_price = $arPrice["PRICE"];
									}
								}
							}
							$count_offers++;
						}?>
					
						<div class="price_block">
							<?foreach( $arItem["OFFERS"][$min_offer_id]["PRICES"] as $key => $arPrice ){?>
								<?foreach($arItem["PRICES"] as $key=>$price){if($price["VALUE"]<$min_price){$arPrice=$price;}}?>
								<div class="price">
									<?$prefix = count( $arItem["OFFERS"] ) > 1 ? GetMessage("CATALOG_FROM").'&nbsp;' : '';?>
									<span><?=$prefix?><?=FormatCurrency($arPrice["PRICE"], $arPrice["CURRENCY"])?></span>
								</div>
							<?}?>
						</div>
					<?}else{?>
						<div class="price">
							<?$numPrices = count($arParams["PRICE_CODE"]);
							foreach($arItem["PRICES"] as $code=>$arPrice):?>
								<?if($arPrice["CAN_ACCESS"]):?>
									<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
										<div class="discount-price">
											<span><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span>
										</div>
										<div class="old-price">
											<span><?=$arPrice["PRINT_VALUE"]?></span>
										</div>
									<?else:?>
										<div class="discount-price">
											<span><?=$arPrice["PRINT_VALUE"]?></span>
										</div>
									<?endif;?>
								<?endif;?>
							<?endforeach;?>	
						</div>
					<?}?>
					<?if ( $arItem['CAN_BUY'] || $flg_offers ) {
						/*if ('Y' == $arParams['USE_PRODUCT_QUANTITY']){?>
							<div class="bx_catalog_item_controls_blockone">
								<div style="display: inline-block;position: relative;">
									<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
									<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arElement['CATALOG_MEASURE_RATIO']; ?>">
									<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
									<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"><? echo $arItem['CATALOG_MEASURE_NAME']; ?></span>
								</div>
							</div>
						<?}*/?>				
						<a rel="nofollow" class="uni-button solid_button buy" id="buy_<?=$arItem['ID']?>"
							<?if(!$flg_offers){?>
								onclick="return add_to_cart(<?=$arItem['ID']?>,'<?=GetMessage("CATALOG_ADDED")?>',this,1,'<?=$arParams["BASKET_URL"];?>','<?=$arItem['ID']?>','<?=$arParams['IBLOCK_ID']?>','<?=$arParams['IBLOCK_TYPE']?>')"
							<?}else{?>
								href="<?=$arItem["DETAIL_PAGE_URL"]?>"
							<?}?>><?=GetMessage("CATALOG_ADD_TO_BASKET")?>
						</a>
						<a rel="nofollow" href="<?=$arParams["BASKET_URL"];?>" id="buyed_<?=$arItem['ID']?>" class="uni-button solid_button buy buy_added" style="display: none;">
							<?=GetMessage("CATALOG_ADDED")?>
						</a>
						
					<?}?>
				</div>
			</td>
			<?$position++;?>
		<?}?>
		<? if (count($arResult["ITEMS"]) < 4) { ?>
			<? for ($i = 0; $i < 4 - count($arResult["ITEMS"]); $i++) { ?>
				<td class="item_td empty"></td>
			<? } ?>
		<? } ?>
	</tr>
	
	<tr class="properties">
		<td colspan="5">
			<?foreach( $arResult["DISPLAY_PROPERTIES"] as $key => $arProp ):?>
				<div class="property">
					+ <?=$arProp['NAME']?>
				</div>
			<?endforeach;?>
		</td>
	</tr>
	
	<?$prop_count = 1;?>
	<?foreach( $arResult["DISPLAY_PROPERTIES"] as $key => $arProp ){
		
		$arCompare = array();
		foreach($arProp["ITEMS"] as $arElement){
			$arPropertyValue = $arElement["VALUE"];
			
			if(is_array($arPropertyValue))
			{
				sort($arPropertyValue);
				
				$arPropertyValue = implode(" / ", $arPropertyValue);
			}
			$arCompare[] = $arPropertyValue;
		}
        
		$diff = (count(array_unique($arCompare)) > 1 ? true : false);
		if($diff || empty($_REQUEST["DIFFERENT"]) ){?>
			<tr class="hovered prop_<?=$prop_count?>">
				<td class="prop_name"><?=$arProp["NAME"]?><div class="close"></div></td>
				<?$position = 0;?>
				<?foreach( $arResult["ITEMS"] as $arElement ){?>
					<?
						$key = $arElement['ID'];
						$arItem = $arProp['ITEMS'][$key];
					?>
					<? if (is_array($arItem)):?>
						<td class="prop_item item_<?=$key?>" <?=$position >= 4 ? 'style="display: none;"' : ''?>>
							<?if (is_array($arItem["VALUE"])) {
									$prop = implode(" / ",$arItem["VALUE"]);
								} else {$prop = $arItem["DISPLAY_VALUE"];}?>
								<?=$prop?>
						</td>
					<?else:?>
						<td class="prop_item item_<?=$key?>" <?=$position >= 4 ? 'style="display: none;"' : ''?>></td>
					<?endif;?>
					<?$position++;?>
				<?}?>
				<? if (count($arResult["ITEMS"]) < 4) { ?>
					<? for ($i = 0; $i < 4 - count($arResult["ITEMS"]); $i++) { ?>
						<td></td>
					<? } ?>
				<? } ?>
			</tr>
		<?}?>
		<?$prop_count++?>
	<?}?>
</table>
</div>
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.viewed.product", 
	"slider", 
	array(
		"VIEWED_COUNT" => "8",
		"VIEWED_NAME" => "Y",
		"VIEWED_IMAGE" => "Y",
		"VIEWED_PRICE" => "Y",
		"VIEWED_CURRENCY" => "default",
		"VIEWED_CANBUY" => "N",
		"VIEWED_CANBASKET" => "N",
		"VIEWED_IMG_HEIGHT" => "60",
		"VIEWED_IMG_WIDTH" => "70",
		"BASKET_URL" => "/personal/basket.php",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"SET_TITLE" => "N",
		"COMPONENT_TEMPLATE" => "slider",
		"LINE_ELEMENT_COUNT" => "6",
		"VIEWED_TITLE" => GetMessage('VIEWED_PRODUCTS')
	),
	false
);?>
<script type="text/javascript">
	$(document).ready(function() {
		$('.table_item .delete').click(function(e){
			e.preventDefault();
			var k = $(this).attr('href');
			$.post(k)		
			.done(function (Res) {			
				location.reload();
			})	
		});
		$('.differences_table td.prop_name .close').click(function(){
			var index = $(this).parent().parent().index() - 2;
			$(this).parent().parent().css('display', 'none');
			$('.differences_table tr.properties td .property').eq(index).css('display', 'block');
		});
		
		$('.differences_table tr.properties td .property').click(function(){
			var index = $(this).index() + 2;
			$(this).css('display', 'none');
			$('.differences_table tr').eq(index).css('display', 'table-row');
		});
		
		$('.differences_table .left_arrow, .differences_table .right_arrow').on("click", function(){				
			var pos_start = $('input[name$="start_position"]').val();
			var pos_end = $('input[name$="end_position"]').val();
		
			var count_items = $('.differences_table td.item_td').length;

			if( $(this).hasClass('inc') && pos_end < count_items ){
				$('input[name$="start_position"]').val(++pos_start);
				$('input[name$="end_position"]').val(++pos_end);
			}else if( $(this).hasClass('dec') && pos_start > 1 ){
				$('input[name$="start_position"]').val(--pos_start);
				$('input[name$="end_position"]').val(--pos_end);
			}
			
			$('.differences_table td.item_td').each(function(){
				var index = $(this).index();
				if( index < pos_start || index > pos_end ){
					$(this).hide();
				}else{
					$(this).show();
				}
			})
			
			$('.differences_table td.prop_item').each(function(){
				var index = $(this).index();
				if( index < pos_start || index > pos_end ){
					$(this).hide();
				}else{
					$(this).show();
				}
			})
		
		});
	})
</script>
<?$frame->end()?>

