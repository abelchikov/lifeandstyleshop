<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="product_element_pop">
	<?$flg_offers=0;
		$flg_tax=0;
		if(empty($arResult["OFFERS"])){	
			if(is_array($arResult["PRICES"])){			
				foreach($arResult["PRICES"] as $price){			
					$newprice_v=$price["DISCOUNT_VALUE_NOVAT"];
					$newprice=preg_replace("/^([\d\s\.\,]+)(.*)$/", '$1<span>$2</span>',$price["PRINT_DISCOUNT_VALUE_NOVAT"]);				
					if((int)$price["DISCOUNT_DIFF"]!=0){
						$oldprice_v=$price["VALUE_NOVAT"];
						$oldprice=preg_replace("/^([\d\s\.\,]+)(.*)$/", '$1<span>$2</span>',$price["PRINT_VALUE_NOVAT"]);
						$tax=(int)(($oldprice_v-$newprice_v)/$oldprice_v*100);			
						$flg_tax=1;
						$economy=$price["PRINT_DISCOUNT_DIFF"];
					}
					break;
				}
			}
		}else{
			$oldprice="";
			$flg_offers=1;
			$newprice=preg_replace("/^([\d\s\.\,]+)(.*)$/", '$1<span>$2</span>',$arResult["MIN_PRICE"]["PRINT_DISCOUNT_VALUE_NOVAT"]);
			$newprice_v=$arResult["MIN_PRICE"]["DISCOUNT_VALUE_NOVAT"];
			if((int)$arResult["MIN_PRICE"]["DISCOUNT_DIFF"]!=0){
				$oldprice_v=$arResult["MIN_PRICE"]["VALUE_NOVAT"];
				$oldprice=preg_replace("/^([\d\s\.\,]+)(.*)$/", '$1<span>$2</span>',$arResult["MIN_PRICE"]["PRINT_VALUE_NOVAT"]);
				$tax=(int)(($oldprice_v-$newprice_v)/$oldprice_v*100);	
				$flg_tax=1;
				$economy=$arResult["MIN_PRICE"]["PRINT_DISCOUNT_DIFF"];
				
			}
		}?>
	<div class="title">
		<?=GetMessage("PRODUCT_ADDED");?>
	</div>
	<div class="left_col_product">		
		<?if(!empty($arResult["DETAIL_PICTURE"]["SRC"])){
			$file = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"],array('width'=>177, 'height'=>143),"BX_RESIZE_IMAGE_PROPORTIONAL_ALT");
			$src=$file['src'];
		}else{
			$src=SITE_TEMPLATE_PATH."/images/noimg/noimg_quadro.jpg";
		}?>
		<div class="img_product" style="background-image:url(<?=$src?>)">	
			<div class="marks">
				<?if( $arResult["PROPERTIES"]["STOCK"]["VALUE"] ){?>
					<span class="mark share"></span>
				<?}?>
				<?if( $arResult["PROPERTIES"]["HIT"]["VALUE"] ){?>
					<span class="mark hit"></span>
				<?}?>			
				<?if( $arResult["PROPERTIES"]["NEW"]["VALUE"] ){?>
					<span class="mark new"></span>
				<?}?>
			</div>
		</div>
		<div class="clear"></div>		
	</div>
	<div class="right_col_product">
		<div class="name_product"><a href="<?=$arResult['DETAIL_PAGE_URL']?>"><?=$arResult['NAME']?></a></div>
		<div class="price_block">
			<div class="new_price"><?=$newprice?></div>
			<?if($oldprice!=""){?>
				<div class="old_price"><?=$oldprice?></div>
			<?}?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div class="buttons">
		<div class="continue" onclick="closePopup()"><?=GetMessage("CONTINUE")?></div>
		<a class="to_basket" href="<?=$arParams["BASKET_URL"]?>"><?=GetMessage("TO_BASKET")?></a>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
<script type="text/javasript">
	function closePopup() {		
		$('.popup-window-overlay').hide();
		$('#QuickView'+<?=$arResult["ID"]?>).hide();
	}
</script>
