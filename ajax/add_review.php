<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
	if (strlen($_POST['name']) > 0 && strlen($_POST['description']) > 0 && is_numeric($_POST['id']) && is_numeric($_POST['iblock'])) {
		if (CModule::IncludeModule("iblock"))
		{
			$id = $_POST['id'];
			$name = $_POST['name'];
			$description = $_POST['description'];
			$iblock = $_POST['iblock'];
			
			if ($_POST['charset'] == 'windows-1251')
			{
				$id = iconv('UTF-8', 'windows-1251', $id);
				$name = iconv('UTF-8', 'windows-1251', $name);
				$description = iconv('UTF-8', 'windows-1251', $description);
				$iblock = iconv('UTF-8', 'windows-1251', $iblock);
			}
			
			$el = new CIBlockElement;
			$el->Add(array(
				'NAME' => $name,
				'ACTIVE' => "N",
				'PREVIEW_TEXT' => $description,
				'IBLOCK_SECTION_ID' => false,
				'IBLOCK_ID' => $iblock,
				'CODE' => Cutil::translit($name, "ru"),
				'PROPERTY_VALUES' => array(
					"REVIEW" => $id,
				)
			));
			
			$adminEmail = COption::GetOptionString('main', 'email_from', 'default@admin.email');
			mail($adminEmail, 'Р”РѕР±Р°РІР»РµРЅ РѕС‚Р·С‹РІ', 'Р?РЅРґРµРєСЃ РїСЂРѕРґСѓРєС‚Р°: '.$id);
		}
	}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>