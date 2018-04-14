<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
	function Add2BasketCustom($PRODUCT_ID, $count)
	{
		if (CModule::IncludeModule("sale") && CModule::IncludeModule("catalog")) {
		
			$rsElements = CIBlockElement::GetList(array(), array('ID' => $PRODUCT_ID));
			$rsElement = $rsElements->GetNextElement();
						
			if ($rsElement)
			{
				
				$arElement = $rsElement->GetFields();
				$arElement['PROPERTIES'] = $rsElement->GetProperties();
				
				$basket_properties = array();
				
				if (isset($arElement['PROPERTIES']['CML2_LINK']) && !empty($arElement['PROPERTIES']['CML2_LINK']))
				{
					$properties = $arElement['PROPERTIES'];
					unset($properties['CML2_LINK']);
					
					foreach ($properties as $property)
					{
						$basket_property = array();
						$basket_property['NAME'] = $property['NAME'];
						$basket_property['CODE'] = $property['CODE'];
						$basket_property['VALUE'] = $property['VALUE'];
						$basket_property['SORT'] = $property['SORT'];
						array_push($basket_properties, $basket_property);
					}
				}
				
				$arProduct = CSaleBasket::GetList(array(), array(
					'PRODUCT_ID' => $PRODUCT_ID,
					'FUSER_ID' => CSaleBasket::GetBasketUserID(),
					"LID" => SITE_ID,
					"ORDER_ID" => "NULL"
				))->GetNext();
				
				if (!empty($arProduct))
				{
					$basketProductId = $arProduct['ID'];
					
					$arFields = array(
						"DELAY" => "N"
					);
					CSaleBasket::Update($basketProductId, $arFields);
				}
				else
				{
					$basketProductId = Add2BasketByProductID(
						$PRODUCT_ID,
						$count,
						array(),
						$basket_properties
					);
				}
				
				return $basketProductId;
			}
		}
	}
	
	function DrawBasket()
	{
		global $APPLICATION, $options;
		
		$APPLICATION->IncludeComponent(
			"intec:min-buttons.updater", 
			"", 
			array(
				"IBLOCK_TYPE" => "catalog",
				"IBLOCK_ID" => "7",
				"COMPARE_NAME" => "CATALOG_COMPARE_LIST"
			),
			$component,
			array('HIDE_ICONS' => 'Y')
		);
		
		$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "top_basket", array(
			"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
			"PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
			"SHOW_DELAY" => "Y",
			"SHOW_NOTAVAIL" => "Y",
			"SHOW_SUBSCRIBE" => "Y",
            "TYPE_BASKET" => $options["TYPE_BASKET"]["ACTIVE_VALUE"],
            "SHOW_CALL" => "Y",
			"PATH_TO_COMPARE" => SITE_DIR."catalog/compare.php",
			"IBLOCK_TYPE_COMPARE" => "catalog",
			"IBLOCK_ID_COMPARE" => "7",
			"COMPARE_NAME" => "CATALOG_COMPARE_LIST"
			),
			false
		);
	}
?>

<?if (CModule::IncludeModule("catalog")) {
	$action=$_REQUEST["action"];	
	$PRODUCT_ID=$_REQUEST["id"];
	$count=$_REQUEST["count"];
	
	if(CModule::IncludeModule("intec.unimagazin")){
		UniMagazin::InitProtection();
		UniMagazin::ShowInclude(SITE_ID);
	}
	$options = UniMagazin::getOptionsValue(SITE_ID);
	
	if($action == "SHOWBASKET") {
		
		return;
	}
	if ( $action == "ADD_COMPARE" || $action == "DELETE_COMPARE" ) {
		DrawBasket();
	}
	if (($action == "ADD2BASKET" || $action == "BUY") && IntVal($PRODUCT_ID)>0) {
				
		Add2BasketCustom($PRODUCT_ID, $count);
		DrawBasket();
	}else{
		if (CModule::IncludeModule("sale"))	{
	
			if($action=='LIKE') {				
				$dbBasketItems = CSaleBasket::GetList(
					array(
							"NAME" => "ASC",
							"ID" => "ASC"
						),
					array(
							"PRODUCT_ID" => $PRODUCT_ID,
							"FUSER_ID" => CSaleBasket::GetBasketUserID(),
							"LID" => SITE_ID,
							"ORDER_ID" => "NULL"
						),
					false,
					false,
					array("ID", "DELAY")
				);	
				$dbBasketItems=$dbBasketItems->Fetch();							
				if( !empty( $dbBasketItems ) && $dbBasketItems["DELAY"] == "N" ){
					$arFields = array(
						"DELAY" => "Y"
					);
					CSaleBasket::Update($dbBasketItems["ID"], $arFields);
				}else{
					$id = Add2BasketCustom($PRODUCT_ID, $count);
					
					$arFields = array(
						"DELAY" => "Y"
					);
					
					CSaleBasket::Update($id, $arFields);					
				}
				
				DrawBasket();
			}
			if($action=="DELETE_FROM_BASKET") {
				$dbBasketItems = CSaleBasket::GetList(
					array(
							"NAME" => "ASC",
							"ID" => "ASC"
						),
					array(
							"PRODUCT_ID" => $PRODUCT_ID,
							"FUSER_ID" => CSaleBasket::GetBasketUserID(),
							"LID" => SITE_ID,
							"ORDER_ID" => "NULL"
						),
					false,
					false,
					array("ID", "DELAY")
				)->Fetch();
				
				if( !empty( $dbBasketItems ) ){
					CSaleBasket::Delete($dbBasketItems["ID"]);
				}
				
				DrawBasket();
			}
			if($action=="DELETE_ALL_FROM_BASKET") {
				$res = CSaleBasket::GetList(array(), array(
						  'FUSER_ID' => CSaleBasket::GetBasketUserID(),
						  'LID' => SITE_ID,
						  'ORDER_ID' => 'NULL',
						  'DELAY' => 'N',
						  'CAN_BUY' => 'Y'));
				while ($row = $res->fetch()) {
				   CSaleBasket::Delete($row['ID']);
				}
				DrawBasket();
			}
			if($action=="DELETE_ALL_FROM_LIKE") {
				$res = CSaleBasket::GetList(array(), array(
						  'FUSER_ID' => CSaleBasket::GetBasketUserID(),
						  'LID' => SITE_ID,
						  'ORDER_ID' => 'NULL',
						  'DELAY' => 'Y',
						  'CAN_BUY' => 'Y'));
				while ($row = $res->fetch()) {
				   CSaleBasket::Delete($row['ID']);
				}
				DrawBasket();
			}
			if ($action == 'CHANGE_COUNT') {
				$arBasketProduct = CSaleBasket::GetList(array(), array(
					'PRODUCT_ID' => $PRODUCT_ID,
					'FUSER_ID' => CSaleBasket::GetBasketUserID(),
					"LID" => SITE_ID,
					"ORDER_ID" => "NULL"
				))->GetNext();
				
				if (!empty($arBasketProduct))
				{
					$basketProductId = $arProduct['ID'];
					
					$arFields = array(
						"QUANTITY" => $count,
					);
					CSaleBasket::Update($arBasketProduct['ID'], $arFields);
					$arBasketProduct = CSaleBasket::GetList(array(), array(
						'PRODUCT_ID' => $PRODUCT_ID,
						'FUSER_ID' => CSaleBasket::GetBasketUserID(),
						"LID" => SITE_ID,
						"ORDER_ID" => "NULL"
					))->GetNext();
					echo number_format($arBasketProduct['QUANTITY'], 0, '.', '');
				}
			}
		}
	}
}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>