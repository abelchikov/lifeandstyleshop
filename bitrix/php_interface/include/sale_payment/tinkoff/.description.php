<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?><?

include(GetLangFileName(dirname(__FILE__)."/", "/tinkoff.php"));

$psTitle = GetMessage("SALE_TINKOFF_TITLE");
$psDescription = GetMessage("SALE_TINKOFF_DESCRIPTION");

$taxationsList = array(
    'osn' => array('NAME' => GetMessage('SALE_TINKOFF_TAXATION_OSN')),
    'usn_income' => array('NAME' => GetMessage('SALE_TINKOFF_TAXATION_USN_IMCOME')),
    'usn_income_outcome' => array('NAME' => GetMessage('SALE_TINKOFF_TAXATION_USN_IMCOME_OUTCOME')),
    'envd' => array('NAME' => GetMessage('SALE_TINKOFF_TAXATION_ENVD')),
    'esn' => array('NAME' => GetMessage('SALE_TINKOFF_TAXATION_ESN')),
    'patent' => array('NAME' => GetMessage('SALE_TINKOFF_TAXATION_PATENT')),
);

$vatList = array(
    'none' => array('NAME' => GetMessage('SALE_TINKOFF_VAT_NONE')),
    'vat0' => array('NAME' => GetMessage('SALE_TINKOFF_VAT_ZERO')),
    'vat10' => array('NAME' => GetMessage('SALE_TINKOFF_VAT_REDUCED')),
    'vat18' => array('NAME' => GetMessage('SALE_TINKOFF_VAT_STANDARD')),
);

$arPSCorrespondence = array(

    "ORDER_ID" => array(
    		"NAME" => GetMessage("SALE_TINKOFF_ORDER_ID_NAME"),
    		"DESCR" => GetMessage("SALE_TINKOFF_ORDER_ID_DESCR"),
    		"VALUE" => "ID",
    		"TYPE" => "ORDER"
    	),
    	"SHOULD_PAY" => array(
    		"NAME" => GetMessage("SALE_TINKOFF_SHOULD_PAY_NAME"),
    		"DESCR" => GetMessage("SALE_TINKOFF_DESC_SHOULD_PAY_DESCR"),
    		"VALUE" => "SHOULD_PAY",
    		"TYPE" => "ORDER"
    	),
    	"PAYMENT_DESCRIPTION" => array(
    		"NAME" => GetMessage("SALE_TINKOFF_DESCRIPTION_NAME"),
    		"DESCR" => GetMessage("SALE_TINKOFF_DESCRIPTION_DESCR"),
    		"VALUE" => GetMessage("SALE_TINKOFF_DESCRIPTION_VALUE"),
    		"TYPE" => ""
    	),
	"TINKOFF_PAYMENT_URL" => array(
        "NAME" => GetMessage("SALE_TINKOFF_PAYMENT_URL_NAME"),
        "DESCR" => GetMessage("SALE_TINKOFF_PAYMENT_URL_DESCR"),
        "VALUE" => "https://securepay.tinkoff.ru/rest/",
        "TYPE" => ""
    ),
    "SHOP_SECRET_WORD" => array(
                 "NAME" => GetMessage("SALE_TINKOFF_SHOP_SECRET_WORD_NAME"),
                 "DESCR" => GetMessage("SALE_TINKOFF_SHOP_SECRET_WORD_DESCR"),
                 "VALUE" => "",
                 "TYPE" => ""
    ),
     "TERMINAL_ID" => array(
        	"NAME" => GetMessage("SALE_TINKOFF_TERMINAL_ID_NAME"),
        	"DESCR" => GetMessage("SALE_TINKOFF_TERMINAL_ID_DESCR"),
        	"VALUE" => "",
        	"TYPE" => ""
    ),
    "ENABLE_TAXATION" => array(
                    "NAME" => GetMessage("SALE_TINKOFF_ENABLE_TAXATION_NAME"),
                    "DESCR" => GetMessage("SALE_TINKOFF_ENABLE_TAXATION_DESCR"),
                    "TYPE" => "SELECT",
                    "VALUE" => array(
                        '0' => array('NAME' => 'Нет'),
                        '1' => array('NAME' => 'Да'),
                    ),
                    'DEFAULT' => '0'
        ),
        "TAXATION" => array(
            		"NAME" => GetMessage("SALE_TINKOFF_TAXATION_NAME"),
            		"DESCR" => GetMessage("SALE_TINKOFF_TAXATION_DESCR"),
            		"VALUE" => $taxationsList,
            		"TYPE" => "SELECT"
        ),
            "DELIVERY_TAXATION" => array(
                    "NAME" => GetMessage("SALE_TINKOFF_DELIVERY_TAXATION_NAME"),
                    "DESCR" => GetMessage("SALE_TINKOFF_DELIVERY_TAXATION_DESCR"),
                    "VALUE" => $vatList,
                    "TYPE" => "SELECT"
        )
);
?>