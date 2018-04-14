<?

$arInfo = CCatalogSKU::GetInfoByProductIBlock($arParams["IBLOCK_ID"]);

if ($arInfo)
{
	foreach( $arResult["ITEMS"] as $key => $arItem ):
		$rsOffers = CIBlockElement::GetList(array(),array("IBLOCK_ID" => $arInfo["IBLOCK_ID"], "PROPERTY_".$arInfo["SKU_PROPERTY_ID"] => $arItem["ID"]), false, false, array("ID", "CATALOG_QUANTITY"));
		while ($arOffer = $rsOffers->GetNext()){
			$rsPrice = CPrice::GetList( array(), array( "PRODUCT_ID" => $arOffer["ID"] ) );
			while( $arPrice = $rsPrice->GetNext() ){
				$arOffer["PRICES"][] = $arPrice;
			}
			$arResult["ITEMS"][$key]["OFFERS"][] = $arOffer;
			$dbProductDiscounts = CCatalogDiscount::GetList(array(), array("PRODUCT_ID" => $arOffer["ID"]));
			while( $arProductDiscounts = $dbProductDiscounts->GetNext() ){
				if( $arProductDiscounts["VALUE_TYPE"] == "F" ){
					$i = 0;
					foreach( $arResult["ITEMS"][$key]["OFFERS"] as $item_offer ){
						$j = 0;
						foreach( $item_offer["PRICES"] as $item_prices ){
							$arResult["ITEMS"][$key]["OFFERS"][$i]["PRICES"][$j]["DISCOUNT_PRICE"] = $item_prices["PRICE"] - $arProductDiscounts["VALUE"];
							$j++;
						}
						$i++;
					}
				}elseif( $arProductDiscounts["VALUE_TYPE"] == "P" ){
					$i = 0;
					foreach( $arResult["ITEMS"][$key]["OFFERS"] as $item_offer ){
						$j = 0;
						foreach( $item_offer["PRICES"] as $item_prices ){
							$arResult["ITEMS"][$key]["OFFERS"][$i]["PRICES"][$j]["DISCOUNT_PRICE"] = $item_prices["PRICE"] - ( $item_prices["PRICE"] / 100 * $arProductDiscounts["VALUE"] );
							$j++;
						}
						$i++;
					}
				}
			}
		}
	endforeach;
}

// Подмена картинок SKU
foreach( $arResult["ITEMS"] as $key => $arItem ):
	
	$rsElement = CIBlockElement::GetList(array(), array("ID" => $arItem['ID']), false);
	
	if ($rsElement):
		$arElement = $rsElement->GetNext();
		if (!empty($arElement["PREVIEW_PICTURE"])):
            $arResult["ITEMS"][$key]["PREVIEW_PICTURE"] = CFile::GetByID($arElement["PREVIEW_PICTURE"])->GetNext();
			$arResult["ITEMS"][$key]["PREVIEW_PICTURE"]['SRC'] = CFile::GetPath($arElement["PREVIEW_PICTURE"]);
		endif;
        
		if (!empty($arElement["DETAIL_PICTURE"])):
            $arResult["ITEMS"][$key]["DETAIL_PICTURE"] = CFile::GetByID($arElement["DETAIL_PICTURE"])->GetNext();
			$arResult["ITEMS"][$key]["DETAIL_PICTURE"]['SRC'] = CFile::GetPath($arElement["DETAIL_PICTURE"]);
        endif;
	endif;
endforeach;

$prop = array();
$prop_arr = array();

foreach( $arResult["ITEMS"] as $arItem ):
	foreach( $arItem["DISPLAY_PROPERTIES"] as $arProp ):
		if( !empty($arProp["VALUE"]) ):
			$prop_arr[$arProp["ID"]] = $arProp["ID"];
		endif;
	endforeach;
    foreach( $arItem["OFFER_DISPLAY_PROPERTIES"] as $arProp ):
		if( !empty($arProp["VALUE"]) ):
			$prop_arr[$arProp["ID"]] = $arProp["ID"];
		endif;
	endforeach;
endforeach;

foreach( $arResult["ITEMS"] as $arItem ):
	foreach( $arItem["DISPLAY_PROPERTIES"] as $arProp ):
		if( array_key_exists($arProp["ID"], $prop_arr) ):
			$prop[$arProp["CODE"]]["NAME"] = $arProp["NAME"];
			$prop[$arProp["CODE"]]["ITEMS"][$arItem["ID"]] = $arProp;
		endif;
	endforeach;
    foreach( $arItem["OFFER_DISPLAY_PROPERTIES"] as $arProp ):
		if( array_key_exists($arProp["ID"], $prop_arr) ):
			$prop[$arProp["CODE"]]["NAME"] = $arProp["NAME"];
            $arProp["VALUE"] = $arProp["DISPLAY_VALUE"];
			$prop[$arProp["CODE"]]["ITEMS"][$arItem["ID"]] = $arProp;
		endif;
	endforeach;
endforeach;

$arResult["DISPLAY_PROPERTIES"] = $prop;

$arResult["START_POSITION"] = 1;
$arResult["END_POSITION"] = 4;?>