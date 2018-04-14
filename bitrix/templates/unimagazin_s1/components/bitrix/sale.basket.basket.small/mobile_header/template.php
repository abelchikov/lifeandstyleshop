<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    $this->setFrameMode(true);
	$cart_price = 0;
	$cart_quantity = 0;
	$count_compare = 0;
	$compare_list = $_SESSION[$arParams['COMPARE_NAME']][$arParams['IBLOCK_ID_COMPARE']]['ITEMS'];
	if ( !empty($compare_list) ) {
		$arResult['COMPARE_COUNT'] = count($compare_list);	
	}
	$count_compare = $arResult['COMPARE_COUNT'];
	//print_r($arResult);
	if (is_set($arResult["ITEMS"])){
		foreach ($arResult["ITEMS"] as $v) {
			if ($v["DELAY"]=="N" && $v["CAN_BUY"]=="Y") {
				$cart_price = $cart_price + (float)$v["PRICE"]*(int)$v["QUANTITY"];
				$cart_quantity = $cart_quantity  + (int)$v["QUANTITY"];
			}
			$valuta=$v["CURRENCY"];
		}		
	}
	if(CModule::IncludeModule("currency")){  
		if(empty($valuta)){
			$valuta="RUB";
		}
		$cur=CCurrencyLang::GetCurrencyFormat($valuta,LANGUAGE_ID);
		$cur=$cur["FORMAT_STRING"];		
	}
	$cart_price = number_format($cart_price, 0, ",", " ")." ".substr($cur,2);
	$url=$arParams["PATH_TO_BASKET"];
	// $rsBasket = CSaleBasket::GetList(
		// array(
			// "NAME" => "ASC",
			// "ID" => "ASC"
		// ),
		// array(
			// "FUSER_ID" => CSaleBasket::GetBasketUserID(),
			// "LID" => SITE_ID,
			// "ORDER_ID" => "NULL"
		// ),
		// false,
		// false,
		// array("ID", "PRODUCT_ID", "DELAY")
	// );
// while($arBasket = $rsBasket->GetNext()){
	// if( $arBasket["DELAY"] == "Y" ){
		// $delay_items[] = $arBasket["PRODUCT_ID"];
	// }else{
		// $basket_items[] = $arBasket["PRODUCT_ID"];
	// }
// }
$count_delay = 0;
$count_basket_items = 0;
if(!empty($arResult["ITEMS"])){
	foreach($arResult["ITEMS"] as $key => $arItem){
		if($arItem["DELAY"] == "Y") {
			$count_delay++;
		} else {
			$count_basket_items++;
		}
	}
}?>
<!--small_top_basket_js-->
<!--noindex-->
<!--<div class="basket-small<?/*=!empty($arParams['TYPE_BASKET'])?' '.$arParams['TYPE_BASKET']:''*/?>" id="small_top_basket_js">
	<div class="icons">		
		<a href="<?/*=$url*/?>" class="basket clearfix" title="<?/*=GetMessage("TITLE_BASKET_TOP")*/?>">
			<?/*$frame = $this->createFrame()->begin()*/?>
				<?/*if ($count_basket_items > 0):*/?>
					<div class="text-wrapper solid_element">
						<div class="uni-aligner-vertical"></div>
						<div class="text">
							<?/*=$count_basket_items*/?>
						</div>
					</div>
				<?/*endif;*/?>
				<div class="icon"></div>
			<?/*$frame->beginStub()*/?>
				<div class="text-wrapper solid_element">
					<div class="uni-aligner-vertical"></div>
					<div class="text">0</div>
				</div>	
				<div class="icon"></div>
			<?/*$frame->end()*/?>
		</a>			
	</div>
</div>-->
<?$frame = $this->createFrame()->begin()?>
<?=($count_basket_items > 0)? $count_basket_items : "";?>
<?$frame->beginStub()?>
<?$frame->end()?>
<!--/noindex-->
<!--small_top_basket_js-->	