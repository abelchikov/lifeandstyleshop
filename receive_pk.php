<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");?>




<?
log_to_file($_REQUEST, "/test_pay.log");

$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment.receive",
	"",
	Array(
		"PAY_SYSTEM_ID_NEW" => "3"
	)
);
?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>