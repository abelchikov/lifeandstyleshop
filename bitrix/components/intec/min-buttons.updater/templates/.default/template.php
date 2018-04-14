<?$this->setFrameMode(true)?>
<?$frame = $this->createFrame()->begin()?>
<?if (\Bitrix\Main\Loader::includeModule("catalog") && \Bitrix\Main\Loader::includeModule("sale")) {?>
<script type="text/javascript">
    if (window.frameCacheVars !== undefined) 
    {
            BX.addCustomEvent("onFrameDataReceived" , function(json) {
                updateButtonsState();
            });
    } else {
            BX.ready(function() {
                updateButtonsState();
            });
    }
    //BX.addCustomEvent("onFrameDataReceived", updateButtonsState());
    /*BX.ready(function(){ 
        updateButtonsState();
    })*/
	/*Обновление кнопок при загрузке*/
    function updateButtonsState() {
		<?
		$rsBasket = CSaleBasket::GetList(
			array(
					"NAME" => "ASC",
					"ID" => "ASC"
				),
			array(
					"FUSER_ID" => CSaleBasket::GetBasketUserID(),
					"LID" => SITE_ID,
						"ORDER_ID" => "NULL"
				),
			false,
			false,
			array("ID", "PRODUCT_ID", "DELAY")
		);
		while($arBasket = $rsBasket->GetNext() ){
			if( $arBasket["DELAY"] == "Y" ){
				$delay_items[] = $arBasket["PRODUCT_ID"];
			}else{
				$basket_items[] = $arBasket["PRODUCT_ID"];
			}
		}	
		?>$('.min-button.compare .add').show();<?
		?>$('.min-button.compare .remove').hide();<?
		?>$('.min-button.like .add').show();<?
		?>$('.min-button.like .remove').hide();<?
		?>$('.buy > .buy').show();<?
		?>$('.buy > .buy.buy_added').hide();<?
		if(is_array($_SESSION[$arParams["COMPARE_NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"])){
			foreach($_SESSION[$arParams["COMPARE_NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"] as $id)
			{?>
				$('#deletecomp_<?=$id["PARENT_ID"]?>').show();
				$('#addcomp_<?=$id["PARENT_ID"]?>').hide();
				$('#textcomp_<?=$id["PARENT_ID"]?>').hide();
				$('#addedcomp_<?=$id["PARENT_ID"]?>').show();
			<?}
			if(is_array($delay_items) && !empty($delay_items)) {
				foreach($delay_items as $val) {?>
					$('#liked_<?=$val?>').show();				
					$('#like_<?=$val?>').hide();
				<?}
			}
		}
		if( is_array($basket_items) && !empty($basket_items)) {
			foreach($basket_items as $val) {?>
				$('#buyed_<?=$val?>').show();				
				$('#buy_<?=$val?>').hide();
			<?}
		}?>
		if ('product' in window) {
			product.updateControls();
		}
    }
</script>
<?}?>
<?$frame->end()?>