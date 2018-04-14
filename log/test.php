<? include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php"); ?>

<?
CModule::IncludeModule("iblock");
//$res = CIBlockElement::GetList(Array(), array("ID" => 1740), false, false, array("ID", "NAME", "IBLOCK_SECTION_ID"));
//$ob = $res -> Fetch();

//pre($ob);

/*$arFilter = array(
	'MODULE_ID' => 'iblock',
	"AUDIT_TYPE_ID" => "IBLOCK_ELEMENT_EDIT",
	"USER_ID" => "1",
	//"SITE_ID" => "ru",
	//"REMOTE_ADDR" => "78.46.96.48",
	//"SEVERITY" => "UNKNOWN",
	"TIMESTAMP_X_1" => "16.03.2018 00:00:00",
	//"TIMESTAMP_X_2" => "17.03.2018 00:00:00",
);
$res = CEventLog::GetList(array(), $arFilter, false);
while($ob = $res->Fetch()){
	$ob["DESCRIPTION"] = unserialize($ob['DESCRIPTION']);
	$ITEMS[$ob["DESCRIPTION"]["ID"]][] = $ob;
}

$arFilter = array(
	'MODULE_ID' => 'iblock',
	"AUDIT_TYPE_ID" => "IBLOCK_ELEMENT_EDIT",
	"USER_ID" => "2",
	//"SITE_ID" => "ru",
	//"REMOTE_ADDR" => "78.46.96.48",
	//"SEVERITY" => "UNKNOWN",
	"TIMESTAMP_X_1" => "16.03.2018 00:00:00",
	//"TIMESTAMP_X_2" => "17.03.2018 00:00:00",
);
$res = CEventLog::GetList(array(), $arFilter, false);
while($ob = $res->Fetch()){
	$ob["DESCRIPTION"] = unserialize($ob['DESCRIPTION']);
	$ITEMS[$ob["DESCRIPTION"]["ID"]][] = $ob;
}*/

@ini_set("memory_limit", "1024M");

$arRes["FILTER"] = array(
	"AUDIT_TYPE_ID" => "IBLOCK_ELEMENT_EDIT",
	"TIMESTAMP_X_1" => "16.03.2018 00:00:00"
);
$arRes["RECORDS"] = lifetools::GetInfoRecords($arRes["FILTER"]);

foreach($arRes["RECORDS"] as $key => $RECORD){

	//$UNIX_TIMESTAMP_X = strtotime($RECORD["TIMESTAMP_X"]);
	//$DAY = date("d.m.Y", $UNIX_TIMESTAMP_X);
	//$HOURS = date("H:i:s", $UNIX_TIMESTAMP_X);

	/*$arRes["ITEMS"][$RECORD["DESCRIPTION"]["ID"]][$DAY][] = array(
		"ID" => $RECORD["DESCRIPTION"]["ID"],
		"NAME" => "",
		"USER_CHANGED" => $RECORD["USER_ID"],
		"TIME" => $HOURS,
		"VALUES" => $RECORD["DESCRIPTION"]
	);*/

	$arRes["ITEMS"][$RECORD["DESCRIPTION"]["ID"]][] = array(
		"TIMESTAMP_X" => $RECORD["TIMESTAMP_X"],
		//"UNIX" => strtotime($USER_1["TIMESTAMP_X"]),
		"ID" => $RECORD["DESCRIPTION"]["ID"],
		"NAME" => $RECORD["DESCRIPTION"]["NAME"],
		"CODE" => $RECORD["DESCRIPTION"]["CODE"],
		"USER_ID" => $RECORD["DESCRIPTION"]["USER_ID"],
	);
}

//убираю которые небыли изменены пользователем
foreach($arRes["ITEMS"] as $key => $RECORDS){
	$kill = true;
	foreach($RECORDS as $key_2 => $RECORD){
		if($RECORD["USER_ID"] == "2"){
			$kill = false;
		}
	}
	if($kill){
		unset($arRes["ITEMS"][$key]);
	}else{
		$arRes["CHEK_ACTVITY"][$key] = array("ID" => $key);
	}
}





$arFilter = array(
	"IBLOCK_ID" => Limport::$IBLOCK_CAT,
	"ID" => array_keys($arRes["CHEK_ACTVITY"])
);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, array(
	"ID",
	"NAME",
	"ACTIVE",
	"IBLOCK_SECTION_ID"
));
while($ob = $res->Fetch()){

  if($ob["ACTIVE"] == "N"){

	  $arRes["CHEK_URL"][$ob["ID"]] = array(
			"ID" => $ob["ID"],
			"NAME" => $ob["NAME"],
			"ACTIVE" => $ob["ACTIVE"],
			"IBLOCK_SECTION_ID" => $ob["IBLOCK_SECTION_ID"]
		);

	}

};

echo "Всего не активных которые были изменены ".count($arRes["CHEK_URL"]);

//pre($arRes["CHEK_URL"]);
//pre($arRes["ITEMS"]);
///bitrix/admin/iblock_element_edit.php?IBLOCK_ID=27&type=catalog&ID=1740&lang=ru&find_section_section=-1&WF=Y
?>

<table>
	<? foreach($arRes["CHEK_URL"] as $ITEM_TO_CHEK): ?>
      <tr>
        <td>
          <a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=27&type=catalog&ID=<?=$ITEM_TO_CHEK["ID"]?>&lang=ru&find_section_section=-1&WF=Y" target="_blank">
            [<?=$ITEM_TO_CHEK["ID"]?>] <?=$ITEM_TO_CHEK["NAME"]?>
          </a>
        </td>
      </tr>
	<? endforeach; ?>
</table>