<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?><div class="inside_page_content">
<?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.order", 
	"table", 
	array(
		"PROP_1" => array(
			0 => "5",
		),
		"PROP_3" => "",
		"PROP_2" => array(
		),
		"PROP_4" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => SITE_DIR."personal/order/",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_GROUPS" => "Y",
		"ORDERS_PER_PAGE" => "10",
		"PATH_TO_PAYMENT" => SITE_DIR."personal/order/payment/",
		"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
		"SET_TITLE" => "N",
		"SAVE_IN_SESSION" => "N",
		"NAV_TEMPLATE" => "",
		"CUSTOM_SELECT_PROPS" => array(
		),
		"HISTORIC_STATUSES" => array(
			0 => "F",
		),
		"COMPONENT_TEMPLATE" => "table",
		"STATUS_COLOR_N" => "green",
		"STATUS_COLOR_F" => "gray",
		"STATUS_COLOR_P" => "yellow",
		"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
		"SEF_URL_TEMPLATES" => array(
			"list" => "index.php",
			"detail" => "order_detail.php?ID=#ID#",
			"cancel" => "order_cancel.php?ID=#ID#",
		),
		"VARIABLE_ALIASES" => array(
			"detail" => array(
				"ID" => "ID",
			),
			"cancel" => array(
				"ID" => "ID",
			),
		)
	),
	false
);?>
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>