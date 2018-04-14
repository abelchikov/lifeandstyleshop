<div class="price">
	<?
        $minPrice = $arResult['OFFERS'][0]['MIN_PRICE']['VALUE'];
        $minPriceDiscount = $arResult['OFFERS'][0]['MIN_PRICE']['DISCOUNT_VALUE'];
        $minPricePrint = $arResult['OFFERS'][0]['MIN_PRICE']['PRINT_VALUE'];
        $minPriceDiscountPrint = $arResult['OFFERS'][0]['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
        
        foreach ($arResult['OFFERS'] as $arOffer)
        {
            if ($arOffer['MIN_PRICE']['VALUE'] < $minPrice)
            {
                $minPrice = $arOffer['MIN_PRICE']['VALUE'];
                $minPriceDiscount = $arOffer['MIN_PRICE']['DISCOUNT_VALUE'];
                $minPricePrint = $arOffer['MIN_PRICE']['PRINT_VALUE'];
                $minPriceDiscountPrint = $arOffer['MIN_PRICE']['PRINT_DISCOUNT_VALUE'];
            }
        }
    ?>
	<?if ($minPrice == $minPriceDiscount):?>
		<div class="current" id="price"><?=GetMessage('CATALOG_PRICE_FROM')?> <?=$minPricePrint?></div>
	<?else:?>
		<div class="current" id="discount_price"><?=GetMessage('CATALOG_PRICE_FROM')?> <?=$minPriceDiscountPrint?></div>
		<?if ($arParams['SHOW_OLD_PRICE'] == 'Y'):?>
			<div class="old" id="price"><?=GetMessage('CATALOG_PRICE_FROM')?> <?=$minPricePrint?></div>
		<?endif;?>
	<?endif;?>
    <?
        unset($minPrice, $minPricePrint, $minPriceDiscount, $minPriceDiscountPrint);
    ?>
</div>