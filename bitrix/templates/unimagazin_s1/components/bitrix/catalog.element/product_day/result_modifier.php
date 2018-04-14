<?if(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"]))
{
	$basePriceType = CCatalogGroup::GetBaseGroup();
	$basePriceTypeName = $basePriceType["NAME"];

	$arOffersIblock = CIBlockPriceTools::GetOffersIBlock($arResult["IBLOCK_ID"]);
	$OFFERS_IBLOCK_ID = is_array($arOffersIblock)? $arOffersIblock["OFFERS_IBLOCK_ID"]: 0;
	$dbOfferProperties = CIBlock::GetProperties($OFFERS_IBLOCK_ID, Array(), Array("!XML_ID" => "CML2_LINK"));
	$arIblockOfferProps = array();
	$offerPropsExists = false;
	while($arOfferProperties = $dbOfferProperties->Fetch())
	{
		if (!in_array($arOfferProperties["CODE"],$arParams["OFFERS_PROPERTY_CODE"]))
			continue;
		$arIblockOfferProps[] = array("CODE" => $arOfferProperties["CODE"], "NAME" => $arOfferProperties["NAME"]);
		$offerPropsExists = true;
	}

	$notifyOption = COption::GetOptionString("sale", "subscribe_prod", "");
	$arNotify = unserialize($notifyOption);

	$arSku = array();
	$arResult["OFFERS_CATALOG_QUANTITY"] = 0;
	foreach($arResult["OFFERS"] as $arOffer)
	{		
		$arResult["OFFERS_CATALOG_QUANTITY"]  += $arOffer["CATALOG_QUANTITY"];
        foreach($arOffer["PRICES"] as $code=>$arPrice)
        {
            if($arPrice["CAN_ACCESS"])
            {
                if ($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"])
                {
                    $minOfferPrice = $arPrice["DISCOUNT_VALUE"];
                    $minOfferPriceFormat = $arPrice["PRINT_DISCOUNT_VALUE"];
                }
                else
                {
                    $minOfferPrice = $arPrice["VALUE"];
                    $minOfferPriceFormat = $arPrice["PRINT_VALUE"];
                }

                if ($minItemPrice > 0 && $minOfferPrice < $minItemPrice)
                {
                    $minItemPrice = $minOfferPrice;
                    $minItemPriceFormat = $minOfferPriceFormat;
                }
                elseif ($minItemPrice == 0)
                {
                    $minItemPrice = $minOfferPrice;
                    $minItemPriceFormat = $minOfferPriceFormat;
                }
            }
        }
		$arSkuTmp = array();
		$arSkuTmp["CATALOG_QUANTITY"] = $arOffer["CATALOG_QUANTITY"];
		if ($offerPropsExists)
		{
			foreach($arIblockOfferProps as $key => $arCode)
			{
				if (!array_key_exists($arCode["CODE"], $arOffer["PROPERTIES"]))
				{
					$arSkuTmp[] = GetMessage("EMPTY_VALUE_SKU");
					continue;
				}
				if (empty($arOffer["PROPERTIES"][$arCode["CODE"]]["VALUE"]))
					$arSkuTmp[] = GetMessage("EMPTY_VALUE_SKU");
				elseif (is_array($arOffer["PROPERTIES"][$arCode["CODE"]]["VALUE"]))
					$arSkuTmp[] = implode("/", $arOffer["PROPERTIES"][$arCode["CODE"]]["VALUE"]);
				else
					$arSkuTmp[] = $arOffer["PROPERTIES"][$arCode["CODE"]]["VALUE"];
			}
		}
		else
		{
			if (in_array("NAME", $arParams["OFFERS_FIELD_CODE"]))
				$arSkuTmp[] = $arOffer["NAME"];
			else
				break;
		}
		$arSkuTmp["ID"] = $arOffer["ID"];
		if (is_array($arOffer["PRICES"][$basePriceTypeName]))
		{
			if ($arOffer["PRICES"][$basePriceTypeName]["DISCOUNT_VALUE"] < $arOffer["PRICES"][$basePriceTypeName]["VALUE"])
			{
				$arSkuTmp["PRICE"] = $arOffer["PRICES"][$basePriceTypeName]["PRINT_VALUE"];
				$arSkuTmp["DISCOUNT_PRICE"] = $arOffer["PRICES"][$basePriceTypeName]["PRINT_DISCOUNT_VALUE"];
			}
			else
			{
				$arSkuTmp["PRICE"] = $arOffer["PRICES"][$basePriceTypeName]["PRINT_VALUE"];
				$arSkuTmp["DISCOUNT_PRICE"] = "";
			}
		}
		if (CModule::IncludeModule('sale'))
		{
			$dbBasketItems = CSaleBasket::GetList(
				array(
					"ID" => "ASC"
				),
				array(
					"PRODUCT_ID" => $arOffer['ID'],
					"FUSER_ID" => CSaleBasket::GetBasketUserID(),
					"LID" => SITE_ID,
					"ORDER_ID" => "NULL",
				),
				false,
				false,
				array()
			);
			$arSkuTmp["CART"] = "";
			if ($arBasket = $dbBasketItems->Fetch())
			{
				if($arBasket["DELAY"] == "Y")
					$arSkuTmp["CART"] = "delay";
				elseif ($arBasket["SUBSCRIBE"] == "Y" &&  $arNotify[SITE_ID]['use'] == 'Y')
					$arSkuTmp["CART"] = "inSubscribe";
				else
					$arSkuTmp["CART"] = "inCart";
			}
		}
		$arSkuTmp["CAN_BUY"] = $arOffer["CAN_BUY"];
		$arSkuTmp["ADD_URL"] = htmlspecialcharsback($arOffer["ADD_URL"]);
		$arSkuTmp["SUBSCRIBE_URL"] = htmlspecialcharsback($arOffer["SUBSCRIBE_URL"]);
		$arSkuTmp["COMPARE"] = "";
		if (isset($_SESSION[$arParams["COMPARE_NAME"]][$arParams["IBLOCK_ID"]]["ITEMS"][$arOffer["ID"]]))
			$arSkuTmp["COMPARE"] = "inCompare";
		$arSkuTmp["COMPARE_URL"] = htmlspecialcharsback($arOffer["COMPARE_URL"]);
		$arSku[] = $arSkuTmp;
	}
	
    $arResult["MIN_PRODUCT_OFFER_PRICE"] = $minItemPrice;
    $arResult["MIN_PRODUCT_OFFER_PRICE_PRINT"] = $minItemPriceFormat;


	if ((!is_array($arIblockOfferProps) || empty($arIblockOfferProps)) && is_array($arSku) && !empty($arSku))
		$arIblockOfferProps[] = array("CODE" => "TITLE", "NAME" => GetMessage("CATALOG_OFFER_NAME"));
	$arResult["SKU_ELEMENTS"] = $arSku;
	$arResult["SKU_PROPERTIES"] = $arIblockOfferProps;
}

if ($arParams['USE_COMPARE'])
{
	$delimiter = strpos($arParams['COMPARE_URL'], '?') ? '&' : '?';

	//$arResult['COMPARE_URL'] = str_replace("#ACTION_CODE#", "ADD_TO_COMPARE_LIST",$arParams['COMPARE_URL']).$delimiter."id=".$arResult['ID'];

	$arResult['COMPARE_URL'] = htmlspecialcharsbx($APPLICATION->GetCurPageParam("action=ADD_TO_COMPARE_LIST&id=".$arResult['ID'], array("action", "id")));
}?>