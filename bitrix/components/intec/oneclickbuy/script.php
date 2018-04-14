<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
header('Content-type: application/json; charset=utf-8');
require(dirname(__FILE__)."/lang/" . LANGUAGE_ID . "/script.php");

use Bitrix\Sale;

if (!function_exists('inputClean')) 
{ 
	function inputClean($input, $sql=false) 
	{
		$input = htmlentities($input, ENT_QUOTES, LANG_CHARSET);
		if(get_magic_quotes_gpc ())	{$input = stripslashes ($input);}
		if ($sql){$input = mysql_real_escape_string ($input);}
		$input = strip_tags($input);
		$input=str_replace ("\n"," ", $input);
		$input=str_replace ("\r","", $input);
		return $input;
	}
}

if (!function_exists('json_encode')) 
{  
    function json_encode($value) 
    {
        if (is_int($value)) { return (string)$value; } 
		elseif (is_string($value)) 
		{
	        $value = str_replace(array('\\', '/', '"', "\r", "\n", "\b", "\f", "\t"),  array('\\\\', '\/', '\"', '\r', '\n', '\b', '\f', '\t'), $value);
	        $convmap = array(0x80, 0xFFFF, 0, 0xFFFF);
	        $result = "";
	        for ($i = mb_strlen($value) - 1; $i >= 0; $i--) 
			{
	            $mb_char = mb_substr($value, $i, 1);
	            if (mb_ereg("&#(\\d+);", mb_encode_numericentity($mb_char, $convmap, "UTF-8"), $match)) { $result = sprintf("\\u%04x", $match[1]) . $result;  } 
				else { $result = $mb_char . $result;  }
	        }
	        return '"' . $result . '"';                
        } 
		elseif (is_float($value)) { return str_replace(",", ".", $value); } 
		elseif (is_null($value)) {  return 'null';} 
		elseif (is_bool($value)) { return $value ? 'true' : 'false';   } 
		elseif (is_array($value)) 
		{
            $with_keys = false;
            $n = count($value);
            for ($i = 0, reset($value); $i < $n; $i++, next($value))  { if (key($value) !== $i) {  $with_keys = true; break;  }  }
        } 
		elseif (is_object($value)) { $with_keys = true; }
		else { return ''; }
        $result = array();
        if ($with_keys)  {  foreach ($value as $key => $v) {  $result[] = json_encode((string)$key) . ':' . json_encode($v); }  return '{' . implode(',', $result) . '}'; } 
		else {  foreach ($value as $key => $v) { $result[] = json_encode($v); } return '[' . implode(',', $result) . ']';  }
    } 
}

if (!function_exists('getJson')) 
{ 
	function getJson($message, $res='N', $error='') 
	{
		global $APPLICATION;
		$result = array(
			'result' => $res=='Y'?'Y':'N',
			'message' => $APPLICATION->ConvertCharset($message, SITE_CHARSET, 'utf-8')
		);
		if (strlen($error) > 0) { $result['err'] = $APPLICATION->ConvertCharset($error, SITE_CHARSET, 'utf-8'); }
		return json_encode($result);
	}
}

if (CModule::IncludeModule('sale')	&& CModule::IncludeModule('iblock') && CModule::IncludeModule('catalog') && CModule::IncludeModule('currency')) 
{
    $user_registered = false;
	$currency = CCurrencyLang::GetByID($_POST['CURRENCY'], LANGUAGE_ID);
	
	$personTypeId = ( !empty($_POST['personTypeId']) && $_POST['personTypeId']>0 ) ? $_POST['personTypeId'] : 1;
	$deliveryId = ( !empty($_POST['deliveryId']) && $_POST['deliveryId']>0 ) ? $_POST['deliveryId'] : 1;
	$paymentId = ( !empty($_POST['paysystemId']) && $_POST['paysystemId']>0 ) ? $_POST['paysystemId'] : 1;

	global $APPLICATION;
	$_POST['ONE_CLICK_BUY']['USER_NAME'] = $APPLICATION->ConvertCharset($_POST['ONE_CLICK_BUY']['USER_NAME'], 'utf-8', SITE_CHARSET);
	$_POST['ONE_CLICK_BUY']['COMMENT'] = $APPLICATION->ConvertCharset($_POST['ONE_CLICK_BUY']['COMMENT'], 'utf-8', SITE_CHARSET);
	
	if (!empty($_POST['ONE_CLICK_BUY']['EMAIL']) && !preg_match('/^[0-9a-zA-Z\-_\.]+@[0-9a-zA-Z\-]+[\.]{1}[0-9a-zA-Z\-]+[\.]?[0-9a-zA-Z\-]+$/', $_POST['ONE_CLICK_BUY']['EMAIL'])) die(getJson(GetMessage('BAD_EMAIL_FORMAT')));
	elseif (!empty($_POST['ONE_CLICK_BUY']['PHONE']) && !preg_match('/^[+0-9\-\(\)\s]+$/', $_POST['ONE_CLICK_BUY']['PHONE'])) die(getJson(GetMessage('NO_PHONE')));
	elseif (empty($_POST['ONE_CLICK_BUY']['USER_NAME'])) die(getJson(GetMessage('NO_USER_NAME')));
	elseif  (!$currency) die(getJson(GetMessage('CURRENCY_NOT_FOUND')));
	
	if (strlen($_POST['CURRENCY']) != 3) $_POST['CURRENCY'] = COption::GetOptionString('sale', 'default_currency', 'RUB');

	global $USER;
	if (!$USER->IsAuthorized()) 
	{
		if (!isset($_POST['ONE_CLICK_BUY']['EMAIL']) || trim($_POST['ONE_CLICK_BUY']['EMAIL']) == '') 
		{
			$login = 'user_' . (microtime(true) * 10000);
			if (strlen(SITE_SERVER_NAME)) { $server_name = SITE_SERVER_NAME; } else { $server_name = $_SERVER["SERVER_NAME"];}
			$_POST['ONE_CLICK_BUY']['EMAIL'] = $login . '@' . $server_name;
			$user_registered = true;
		} 
		else 
		{
			$dbUser = CUser::GetList(($by = 'ID'), ($order = 'ASC'), array('=EMAIL' => trim($_POST['ONE_CLICK_BUY']['EMAIL'])));
			if ($dbUser->SelectedRowsCount() == 0) 
			{
				$login = 'user_' . (microtime(true) * 10000);
				$user_registered = true;
			} 
			elseif ($dbUser->SelectedRowsCount() == 1) 
			{
				$ar_user = $dbUser->Fetch();
				$registeredUserID = $ar_user['ID'];
			} else die(getJson(GetMessage('TOO_MANY_USERS')));
		}

		if ($user_registered) 
		{
			$captcha = COption::GetOptionString('main', 'captcha_registration', 'N');
			if ($captcha == 'Y'){COption::SetOptionString('main', 'captcha_registration', 'N');}
			$userPassword = randString(10);
			$username = explode(' ', trim($_POST['ONE_CLICK_BUY']['USER_NAME']));
			$newUser = $USER->Register($login, $username[0], $username[1], $userPassword,  $userPassword,$_POST['ONE_CLICK_BUY']['EMAIL']);
			if ($captcha == 'Y'){ COption::SetOptionString('main', 'captcha_registration', 'Y');}
			if ($newUser['TYPE'] == 'ERROR') { die(getJson(GetMessage('USER_REGISTER_FAIL'), 'N', $newUser['MESSAGE'])); } 
			else 
			{
				$registeredUserID = $USER->GetID();
				if (!empty($_POST['ONE_CLICK_BUY']['PHONE'])) { $USER->Update($registeredUserID,  array('PERSONAL_PHONE' => $_POST['ONE_CLICK_BUY']['PHONE']));}
				$USER->Logout();
			}
		}
	} else { $registeredUserID = $USER->GetID(); }
	
	\Bitrix\Sale\Notify::setNotifyDisable(true); 
	

	$res = CSaleBasket::GetList(array('SORT' => 'DESC'),
								array('FUSER_ID' => CSaleBasket::GetBasketUserID(), 
										'LID' => SITE_ID, 
										'ORDER_ID' => 'NULL'
								),
								false,
								false,
								array("ID"));
	while ($row = $res->fetch()) {
	   CSaleBasket::Delete($row['ID']);
	}	
	
	$added = Add2BasketByProductID(
		$_POST['PRODUCT_ID'],
		1, 
		array(
		),
		false
	);
	
	if (!$added)
	{
		$strError = '';
		if($ex = $APPLICATION->GetException()) {$strError = $ex->GetString();}
		die(getJson(GetMessage('ITEM_ADD_FAIL'), 'N', $strError));
		
	} 
	else
	{
	//start D7_orderCreate
		$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
		
		$orderListMailtmp = '';
		$arOrderList = $basket->getListOfFormatText();
		foreach ($arOrderList as $OrderList) {
			$orderListMailtmp .= $OrderList.'<br>'; 
		}
		
		$order = Bitrix\Sale\Order::create(SITE_ID, $registeredUserID);
		$order->setPersonTypeId($personTypeId);
		$order->setBasket($basket);
		
		//Добавление отгрузки
		$shipmentCollection = $order->getShipmentCollection();
		$shipment = $shipmentCollection->createItem();
		$shipmentItemCollection = $shipment->getShipmentItemCollection();
		foreach ($basket as $basketItem)
		{
			$item = $shipmentItemCollection->createItem($basketItem);
			$item->setQuantity($basketItem->getQuantity());
		}
		$arDeliveryServiceAll = Bitrix\Sale\Delivery\Services\Manager::getRestrictedObjectsList($shipment);
		$shipmentCollection = $shipment->getCollection();

		if (!empty($arDeliveryServiceAll)) {
			if (array_key_exists($deliveryId, $arDeliveryServiceAll))
			{
				$deliveryObj = $arDeliveryServiceAll[$deliveryId];
			}
			else
			{
				$deliveryObj = reset($arDeliveryServiceAll);
			}

			if ($deliveryObj->isProfile()) {
				$name = $deliveryObj->getNameWithParent();
			} else {
				$name = $deliveryObj->getName();
			}

			$shipment->setFields(array(
				'DELIVERY_ID' => $deliveryObj->getId(),
				'DELIVERY_NAME' => $name,
				'CURRENCY' => $order->getCurrency()
			));

			$shipmentCollection->calculateDelivery();
		}
		
		//Добавление оплаты
		$paymentCollection = $order->getPaymentCollection();
		$payment = $paymentCollection->createItem(
			Bitrix\Sale\PaySystem\Manager::getObjectById($paymentId)
		);
		$order->getDiscount()->calculate();
		$order->setField('COMMENTS', $_POST['ONE_CLICK_BUY']['COMMENT']);
		$order->setField('USER_DESCRIPTION', $_POST['ONE_CLICK_BUY']['COMMENT']);
		$order->setField('USER_ID', $registeredUserID);
		
		//свойства заказа
		$propertyCollection = $order->getPropertyCollection();
		$emailProp = $propertyCollection->getUserEmail();
		if ($emailProp) 
			$emailProp->setValue($_POST['ONE_CLICK_BUY']['EMAIL']);
		
		$phoneProp = $propertyCollection->getPhone();
		if ($phoneProp)
			$phoneProp->setValue($_POST['ONE_CLICK_BUY']['PHONE']);
		
		//Сумма заказа для письма
		$orderPrice = $order->getPrice();
		
		$result = $order->save();
		$orderId = $order->GetId();
	 
		if (!$result->isSuccess())
			{
				die(getJson($result->getErrors(), 'Y'));
			}
	//end D7_orderCreate
		
		}
	$orderListMail .= $orderListMailtmp;
	
	if (!CEventType::GetByID("ONECLICKBUY_ORDER", LANGUAGE_ID)->Fetch()) {
		CEventType::Add(array(
			"LID" => LANGUAGE_ID,
			"EVENT_NAME" => "ONECLICKBUY_ORDER",
			"NAME" => GetMessage("EVENT_TYPE_NAME"),
			"DESCRIPTION" => GetMessage("EVENT_TYPE_DESCRIPTION")
		));
	} else {
		if ($arOrder = CSaleOrder::GetByID($orderId)) {
			$arFields = array(
				"USER_NAME" => $_POST['ONE_CLICK_BUY']['USER_NAME'],
				"USER_PHONE" => $_POST['ONE_CLICK_BUY']['PHONE'],
				"USER_EMAIL" => $_POST['ONE_CLICK_BUY']['EMAIL'],
				"ORDER_ID" => $arOrder["ID"],
				"ORDER_DESCRIPTION" => $_POST['ONE_CLICK_BUY']['COMMENT'],
				"ORDER_LIST" => $orderListMail,
				"PRICE" => $orderPrice,
				"SALE_EMAIL" => COption::GetOptionString("sale", "order_email", "order@".$SERVER_NAME)
			);
	
			$oEvent = new CEvent();
			$oEvent->Send("ONECLICKBUY_ORDER", SITE_ID, $arFields, "N");
		}
	}

	die(getJson(GetMessage('EMPTY_BASKET'), 'Y'));
}
die(getJson(GetMessage('NO_PROPER_DATA')));
?>