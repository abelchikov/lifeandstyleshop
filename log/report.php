<? //include($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$arResult = array();

$arResult["FILTER"]["TIMESTAMP_X_1"] = ($_REQUEST["TIMESTAMP_X_1"]) ? date("d.m.Y H:i:s", strtotime($_REQUEST["TIMESTAMP_X_1"])) : date("d.m.Y H:i:s", time() - 60 * 60 * 24 * 1);
$arResult["FILTER"]["TIMESTAMP_X_2"] = ($_REQUEST["TIMESTAMP_X_2"]) ? date("d.m.Y 23:59:59", strtotime($_REQUEST["TIMESTAMP_X_2"])) : date("d.m.Y H:i:s", time());
?>
  <style>
    input, button {
      font-size : 18px;
      margin    : 10px;
    }
  </style>

  <h1>Отчет по изменениям товара</h1>


  <hr>
  ПРИМЕР<br>
  07:33:15 || N || 1 || 75 || Носки КОТ И СНЕЖИНКА темно-синие, Размер 36-39, материал: смешанный хлопок<br>
  Когда было изменение || Активность товара || Кто последний менял товар || Раздел товара || Название<br>

  <br>- все новые товары перемещаются в новинки все остальные деактивируются
  <br><a href="/bitrix/admin/iblock_element_admin.php?IBLOCK_ID=27&type=catalog&lang=ru&find_section_section=74" target="_blank">74 OSS</a>
  <br><a href="/bitrix/admin/iblock_element_admin.php?IBLOCK_ID=27&type=catalog&lang=ru&find_section_section=75" target="_blank">75 LIFE and STYLE</a>
  <br><a href="/bitrix/admin/iblock_element_admin.php?IBLOCK_ID=27&type=catalog&lang=ru&find_section_section=76" target="_blank">76 CAMPUS78</a>

  <br>
  <br>- все товары деативируются
  <br><a href="/bitrix/admin/iblock_element_admin.php?IBLOCK_ID=27&type=catalog&lang=ru&find_section_section=154" target="_blank">154 НЕ ДЛЯ САЙТА LIFE and STYLE</a>
  <br><a href="/bitrix/admin/iblock_element_admin.php?IBLOCK_ID=27&type=catalog&lang=ru&find_section_section=155" target="_blank">155 НЕ ДЛЯ САЙТА OSS</a>
  <hr>


  <form type="POST" action="<?=POST_FORM_ACTION_URI;?>">

    <br>Дата начала
    <br><input type="date" name="TIMESTAMP_X_1" value="<?=date("Y-m-d", strtotime($arResult["FILTER"]["TIMESTAMP_X_1"]));?>">

    <br>Дата окончания
    <br><input type="date" name="TIMESTAMP_X_2" value="<?=date("Y-m-d", strtotime($arResult["FILTER"]["TIMESTAMP_X_2"]));?>">


    <br><input type="number" name="ID" placeholder="Ид товара" value="<?=$_REQUEST["ID"]?>">

    <br>
    <button type="submit">Фильтровать</button>

  </form>


<?
@ini_set("memory_limit", "1024M");

$arRes["FILTER"] = array(
	"AUDIT_TYPE_ID" => "IBLOCK_ELEMENT_EDIT",
	"TIMESTAMP_X_1" => $arResult["FILTER"]["TIMESTAMP_X_1"],
	"TIMESTAMP_X_2" => $arResult["FILTER"]["TIMESTAMP_X_2"],
  //"ID" => "156838"
);

$arRes["RECORDS"] = lifetools::GetInfoRecords($arRes["FILTER"]);

foreach($arRes["RECORDS"] as $key => $RECORD){

  if(($RECORD["DESCRIPTION"]["ID"] && !$_REQUEST["ID"]) or ($_REQUEST["ID"] && $_REQUEST["ID"] == $RECORD["DESCRIPTION"]["ID"])){

    $UNIX_TIMESTAMP_X = strtotime($RECORD["TIMESTAMP_X"]);
	  $DAY = date("d.m.Y", $UNIX_TIMESTAMP_X);
	  $HOURS = date("H:i:s", $UNIX_TIMESTAMP_X);

	  $arRes["ITEMS"][$RECORD["DESCRIPTION"]["ID"]]["ID"] = $RECORD["DESCRIPTION"]["ID"];
	  $arRes["ITEMS"][$RECORD["DESCRIPTION"]["ID"]]["NAME"] = $RECORD["DESCRIPTION"]["NAME"];
	  $arRes["ITEMS"][$RECORD["DESCRIPTION"]["ID"]]["URL"] = $RECORD["DESCRIPTION"]["DETAIL_PAGE_URL"];

	  $arRes["ITEMS"][$RECORD["DESCRIPTION"]["ID"]]["BY_DAY"][$DAY][] = array(
		  //"ID" => $RECORD["DESCRIPTION"]["ID"],
		  //"NAME" => $RECORD["DESCRIPTION"]["NAME"],
		  //"USER_CHANGED" => $RECORD["USER_ID"],
		  "TIME" => $HOURS,
		  "VALUES" => $RECORD["DESCRIPTION"]
	  );
  }
}

$arFilter = array(
    "IBLOCK_ID" => Limport::$IBLOCK_CAT,
	  "ID" => array_keys($arRes["ITEMS"])
);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, array(
	"ID", "NAME", "ACTIVE", "IBLOCK_SECTION_ID", "TIMESTAMP_X", "MODIFIED_BY", "DETAIL_PAGE_URL"
));

$res->SetUrlTemplates("/catalog/#SECTION_CODE#/#ELEMENT_ID#/");
while($ob = $res->Fetch()){

	$ob["CUR_STATE"] = "Y";

  $arRes["ITEMS"][$ob["ID"]]["BY_DAY"]["Сейчас"][] = array(
	  "TIME" => date("H:i:s", strtotime($ob["TIMESTAMP_X"])),
	  "VALUES" => $ob
  );

};
//pre($arRes["ITEMS"]);

?>
  <ul>
	  <? foreach($arRes["ITEMS"] as $ITEM): ?>
        <li>

            <strong>
              <a href="<?=$ITEM["URL"]?>" target="_blank">[<?=$ITEM["ID"]?>]</a>

              &nbsp;&nbsp;

            <a href="/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=27&type=catalog&ID=<?=$ITEM["ID"]?>&lang=ru&find_section_section=-1&WF=Y" target="_blank"><?=$ITEM["NAME"]?></a>
            </strong>
        </li>

      <ul>
		  <? foreach($ITEM["BY_DAY"] as $key_date => $RECORDS): ?>
            <li>
              <b><?=$key_date?></b>
            </li>
        <ul>
			  <? foreach($RECORDS as $REC): ?>
          <li>
            <?//=($REC["VALUES"]["CUR_STATE"] == "Y")? "<a href='".$ITEM["URL"]."' target='_blank'>Сейчас</a> - " : "";?>
              <?=$REC["TIME"]?>
              ||
              <?=($REC["VALUES"]["ACTIVE"] == "N" && $REC["VALUES"]["CUR_STATE"] == "Y") ? "<span style='color: red'>N</span>" : $REC["VALUES"]["ACTIVE"]; ?>
              ||
              <a href="/bitrix/admin/user_edit.php?lang=ru&ID=<?=$REC["VALUES"]["MODIFIED_BY"]?>" target="_blank">
                <?=$REC["VALUES"]["MODIFIED_BY"]?>
              </a>
              ||
              <a href="/bitrix/admin/iblock_element_admin.php?IBLOCK_ID=27&type=catalog&lang=ru&find_section_section=<?=$REC["VALUES"]["IBLOCK_SECTION_ID"]?>" target="_blank">
                  <?=$REC["VALUES"]["IBLOCK_SECTION_ID"]?>
              </a>
              ||
              <?=$REC["VALUES"]["NAME"]?>

	            <?=($REC["VALUES"]["CUR_STATE"] == "Y")? "<br><br>" : "";?>
          </li>
			  <? endforeach; ?>
        </ul>
		  <? endforeach; ?>
      </ul>
	  <? endforeach; ?>
  </ul>


<? //pre($arRes["ITEMS"]); ?>