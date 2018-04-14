<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");?><script>
document.location.href = "<?=SITE_DIR?>personal/profile/";
</script>
	<div class="inside_page_content"> 
		<p>В личном кабинете Вы можете проверить текущее состояние корзины, ход выполнения Ваших заказов, просмотреть или изменить личную информацию, а также подписаться на новости и другие информационные рассылки. </p>
		<h2 class="personal">Личный кабинет</h2>
		<ul class="personal"> 	 
			<li><a href="<?=SITE_DIR?>personal/profile/" >Изменить регистрационные данные</a></li>  	 
			<li><a href="<?=SITE_DIR?>personal/order/" >Ознакомиться с состоянием заказов</a></li>
		</ul>
	</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>