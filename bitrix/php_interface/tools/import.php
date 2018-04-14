<?
AddEventHandler('catalog', 'OnSuccessCatalogImport1C', array("Limport", "custom_change"));

AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("Limport", "chek_CML2_ATTRIBUTES"));
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("Limport", "chek_CML2_ATTRIBUTES"));

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("Limport", "On_before_update"));

class Limport{
	static $IBLOCK_CAT = "27";

	static $IBLOCK_SKU = "28";


	//делаем разделы не ативными
	static $KILL_SECTIONS = array(
		"74",
		"75",
		"76",
		"154",
		"155"
	);

	//-74 OSS
	//-75 LIFE and STYLE
	//-76 CAMPUS78
	//
	//-154 НЕ ДЛЯ САЙТА LIFE and STYLE
	//-155 НЕ ДЛЯ САЙТА OSS

	//раздел новинок
	static $NEW_ELEMENTS_IBLOCK_DECTION = 153;

	//не для сайта
	static $NOSHOW_ELEMENTS_IBLOCK_DECTION = 154;

	//Сюда выгружаются все Модификации товара это ИД свойства Инфоблока SKU
	static $CML2_ATTRIBUTES_ID = 181;


	//перед изменением товара - админом (под ним идет выгрузка)
	public static function On_before_update(&$arFields){

		if($arFields["IBLOCK_ID"] == Limport::$IBLOCK_CAT && $arFields["ID"]){

			$arFilter = array(
				"IBLOCK_ID" => Limport::$IBLOCK_CAT,
				"ID" => $arFields["ID"]
			);

			$res = CIBlockElement::GetList(Array(), $arFilter, false, false, array("ID", "NAME", "ACTIVE", "IBLOCK_SECTION_ID", "TIMESTAMP_X", "MODIFIED_BY", "DETAIL_PAGE_URL"));
			$res->SetUrlTemplates("/catalog/#SECTION_CODE#/#ELEMENT_ID#/");
			$ob = $res->GetNext();

			foreach($ob as $key => $val){
				if(substr($key, 0, 1) == "~"){
					unset($ob[$key]);
				}
			}

			//записываю в лог все изменения
			lifetools::MakeMyInfoLog("IBLOCK_ELEMENT_EDIT", "27", $ob);

			global $USER;
			if($USER->GetID() == "1"){
				$arFields["NAME"] = $ob["NAME"];
				$arFields["IBLOCK_SECTION"] = $ob["IBLOCK_SECTION_ID"];
				$arFields["IBLOCK_SECTION_ID"] = $ob["IBLOCK_SECTION_ID"];
				$arFields["SECTION_ID"] = $ob["IBLOCK_SECTION_ID"];
			}
		}
	}


	public static function custom_change($arParams, $arFields){


		//все новые товары - созданные за последний 10 мин - будут перемещены в раздел новинки
		$arFilter = array(
			"IBLOCK_ID" => Limport::$IBLOCK_CAT,
			//"ACTIVE" => "Y",
			">=DATE_CREATE" => date("d.m.Y H:i:s", time() - 600),
			"!SECTION_ID" => array(154, 155)
		);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, array("ID", "NAME", "IBLOCK_SECTION_ID"));
		while($ob = $res -> Fetch()){
			CIBlockElement::SetElementSection($ob["ID"], array(self::$NEW_ELEMENTS_IBLOCK_DECTION));
		}


		//снимаю активность у улементов которые в разделе - не для сайта
		$arFilter = array(
			"IBLOCK_ID" => Limport::$IBLOCK_CAT,
			"ACTIVE" => "Y",
			"SECTION_ID" => self::$KILL_SECTIONS,
			"INCLUDE_SUBSECTIONS" => "Y"
		);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, array("ID", "NAME"));
		while($ob = $res -> Fetch()){
			$el = new CIBlockElement;
			$el->Update($ob["ID"], array("ACTIVE" => "N"));
		}

		//если в разделе нет активных товаров - кикаю весь раздел
		$arFilter = array(
			'IBLOCK_ID' => Limport::$IBLOCK_CAT,
			'GLOBAL_ACTIVE' => 'Y'
		);
		$res = CIBlockSection::GetList(Array(), $arFilter, true);
		while($ob = $res -> Fetch()){
			if($ob["ELEMENT_CNT"] == 0){
				self::$KILL_SECTIONS[] = $ob["ID"];
			}
		}


		//делаю разделы не активными
		foreach(self::$KILL_SECTIONS as $SECTION_ID){
			$arFields = array(
				"ACTIVE" => "N",
			);
			$bs = new CIBlockSection;
			$bs->Update($SECTION_ID, $arFields);
		}
	}


	/**
	 * @param $arFields
	 * Дублируем свойства и выставляем правильные значения для свойства
	 */
	public static function chek_CML2_ATTRIBUTES(&$arFields){
		//только для ску товаров
		/**
		 * Распределям все свойства в массив из свойства CML2_ATTRIBUTES
		 * Проверяем есть ли свойство такое по Описанию из CML2_ATTRIBUTES если нет добавляем
		 * Проверяем если есть ли значение в списке если нет добаляем
		 * Устанавливаем значение для списка согласно значению из CML2_ATTRIBUTES
		 */
		if($arFields["IBLOCK_ID"] == self::$IBLOCK_SKU){
			//$arRes["INPUT"] = $arFields;
			//получаю все возможные свойства инф торговых предложений через кеш
			//TODO - сброс кэша ALL_PROPS_IBLOCK_28 перед начало м импорта
			$arRes["ALL_PROPS_IBLOCK_28"] = lifetools::make_chache_main("lifetools::Get_All_Props_Iblock", "ALL_PROPS_IBLOCK_28", array(), array("IBLOCK_ID" => Limport::$IBLOCK_SKU), 3600, "Y");

			if($arFields["PROPERTY_VALUES"][self::$CML2_ATTRIBUTES_ID]){

				foreach($arFields["PROPERTY_VALUES"][self::$CML2_ATTRIBUTES_ID] as $PROP_CML2_ATTRIBUTES){

					if($PROP_CML2_ATTRIBUTES["VALUE"]){

						$DESCRIPTION_CODE = strtoupper("SKU_".CUtil::translit($PROP_CML2_ATTRIBUTES["DESCRIPTION"], "ru"));

						//проверка на наличие свойства в инфоблоке
						if(!array_key_exists($DESCRIPTION_CODE, $arRes["ALL_PROPS_IBLOCK_28"])){
							$RESP = Limport::Create_Prop_From_CML2_ATTRIBUTES(
								array(
									"NAME" => $PROP_CML2_ATTRIBUTES["DESCRIPTION"],
									"CODE" => $DESCRIPTION_CODE,
									"VALUE" => $PROP_CML2_ATTRIBUTES["VALUE"]
								)
							);
						}

						//если есть свойство - проверить на присутствие нужного значения (в списке) если нет... добавить значение....
						if(array_key_exists($DESCRIPTION_CODE, $arRes["ALL_PROPS_IBLOCK_28"]) && $arRes["ALL_PROPS_IBLOCK_28"][$DESCRIPTION_CODE]["LIST_TYPE"] == "L"){
							$RESP = Limport::Create_Prop_Value_From_CML2_ATTRIBUTES(
								array(
									"CODE" => $DESCRIPTION_CODE,
									"VALUE" => $PROP_CML2_ATTRIBUTES["VALUE"],
									"PROPERTY_ID" => $arRes["ALL_PROPS_IBLOCK_28"][$DESCRIPTION_CODE]["ID"]
								)
							);
						}

						if($RESP["ID"] && $RESP["SUCCESS"]){
							CIBlockElement::SetPropertyValuesEx($arFields["ID"], Limport::$IBLOCK_SKU, array($DESCRIPTION_CODE => $RESP["ID"]));
							//log_to_file($RESP, "/create_props.log");
						}
					}
				}
			}
		}
	}

	/**
	 * @param array $MASS
	 * добавление свойсва SKU список
	 * @return array
	 */
	public static function Create_Prop_From_CML2_ATTRIBUTES($MASS = array()){
		//S - строка,
		// N - число,
		// F - файл,
		// L - список,
		// E - привязка к элементам,
		// G - привязка к группам.
		$arRes = array();

		$arRes["ADD"] = Array(
			"IBLOCK_ID" => Limport::$IBLOCK_SKU,
			"NAME" => $MASS["NAME"],
			"ACTIVE" => "Y",
			"SORT" => "10",
			"CODE" => $MASS["CODE"],
			"PROPERTY_TYPE" => "L",
			"MULTIPLE" => "N"
		);

		//log_to_file($arRes, "/create_props.log");

		$el = new CIBlockProperty;
		$PropID = $el->Add($arRes["ADD"]);

		if($PropID){

			$arRes["RESP_ADD_PROP_VALUE"] = Limport::Create_Prop_Value_From_CML2_ATTRIBUTES(
				array(
					"CODE" => $MASS["CODE"],
					"VALUE" => $MASS["VALUE"],
					"PROPERTY_ID" => $PropID
				)
			);

			return array(
				"ID" => $arRes["RESP_ADD_PROP_VALUE"]["ID"],
				"SUCCESS" => true,
				"MESSAGE" => $PropID." - Свойство добавлено ".$arRes["RESP_ADD_PROP_VALUE"]["MESSAGE"]
			);

		}else {

			return array(
				"ID" => $PropID,
				"SUCCESS" => false,
				"MESSAGE" => $el -> LAST_ERROR
			);

		}
	}


	/**
	 * Проверяет нужное значение в списке если нет - добавляет
	 * Возвращаем ИД нужного значения
	 */
	public static function Create_Prop_Value_From_CML2_ATTRIBUTES($MASS = array()){
		$arRes = array();
		$arRes["INPUT_CR_PROP_VAL"] = $MASS;

		//все значения данного свойства
		$res = CIBlockProperty::GetPropertyEnum($MASS["CODE"], array(), array("IBLOCK_ID" => Limport::$IBLOCK_SKU));
		while($ob = $res->fetch()){
			$arRes["PROP_VAL_ID"][$ob['ID']] = $ob['VALUE'];
		}

		//log_to_file($arRes, "/create_props.log");

		if(in_array($MASS["VALUE"], $arRes["PROP_VAL_ID"])){

			return array(
				"ID" => array_search($MASS["VALUE"], $arRes["PROP_VAL_ID"]),
				"SUCCESS" => true,
				"MESSAGE" => "Новое значение не добавлено - ".$MASS["VALUE"]
			);

		}

		if(!in_array($MASS["VALUE"], $arRes["PROP_VAL_ID"])){
			$el = new CIBlockPropertyEnum;
			if($PropID = $el->Add(array('PROPERTY_ID' => $MASS["PROPERTY_ID"], 'VALUE' => $MASS['VALUE']))){
				return array(
					"ID" => $PropID,
					"SUCCESS" => true,
					"MESSAGE" => "Новое значение добавлено - ".$PropID
				);
			}
		}
	}
}

?>