<?
class lifetools{
	/**
	 * @param string $initDir
	 * Чистим кэш
	 */
	public static function Clear_cache($name = "", $params = array()){

		$сache = \Bitrix\Main\Data\Cache::createInstance();

		$cache_id = self::Make_cache_ID_PATH($name, $params)["CHACHE_ID"];
		$cache_path = self::Make_cache_ID_PATH($name, $params)["CACHE_PATH"];

		$сache->clean($cache_id, $cache_path);
	}

	/**
	 * @param int $cache_time
	 * @param $cache_id
	 * @param $cache_path
	 * Достаем кэш по имени
	 * @return bool
	 */
	public static function Get_cache_by_name($cache_time = 3600, $name = "", $params = array()){
		$сache = \Bitrix\Main\Data\Cache::createInstance();

		$cache_id = self::Make_cache_ID_PATH($name, $params)["CHACHE_ID"];
		$cache_path = self::Make_cache_ID_PATH($name, $params)["CACHE_PATH"];

		if($сache->initCache($cache_time, $cache_id, $cache_path)){
			return $сache->getVars();
		}
		return false;
	}


	/**
	 * @param string $name - Имя кэша - Имя папки на севере
	 * @param string $params - переметры для кеша (в одной папке может лежать много кеша скажем для каждого города и категори...)
	 *
	 */
	public static function Make_cache_ID_PATH($name = "", $params = array()){

		if($params && !is_array($params)){
			$params = array($params);
		}

		if(!$params){
			$cache_id = $name;
		}else{
			$cache_id = $name."__".implode("_", $params);
		}

		$cache_path = "/" . $name . "/";

		return array(
			"CHACHE_ID" => $cache_id,
			"CACHE_PATH" => $cache_path
		);

	}

	/**
	 * @param $name_function
	 * @param $name
	 * @param array $params
	 * @param array $params_for_function
	 * @param int $cache_time
	 * Создаем кеш для массива
	 * @return mixed
	 */
	public static function make_chache_main($name_function, $name, $params = array(), $params_for_function = array(), $cache_time = 3600, $CLEAR_CHACHE = "N"){
		$сache = \Bitrix\Main\Data\Cache::createInstance();
		$cache_id = self::Make_cache_ID_PATH($name, $params)["CHACHE_ID"];
		$cache_path = self::Make_cache_ID_PATH($name, $params)["CACHE_PATH"];
		if($CLEAR_CHACHE == "Y"){
			self::Clear_cache($name, $params);
		}
		if($сache->initCache($cache_time, $cache_id, $cache_path)){
			return $сache->getVars();
		}elseif($сache->startDataCache($cache_time, $cache_id, $cache_path)){
			$make_mass = call_user_func($name_function, $params_for_function);
			//log_to_file($make_mass, "/pr.log");
			$сache->endDataCache($make_mass);
			return $make_mass;
		}
	}



	public static function Get_All_Props_Iblock($mass = array()){
		$arRes = array();
		if($mass["FILTER"]){
			$arRes["FILTER"] = $mass["FILTER"];
		}
		$res = CIBlock::GetProperties($mass["IBLOCK_ID"], array(), $arRes["FILTER"] = array());
		while($ob = $res->Fetch()){
			$arRes["PROPS"][$ob["CODE"]] = array(
				"ID" => $ob["ID"],
				"NAME" => $ob["NAME"],
				"CODE" => $ob["CODE"],
				"PROPERTY_TYPE" => $ob["PROPERTY_TYPE"],
				"LIST_TYPE" => $ob["LIST_TYPE"]
			);
		}

		return $arRes["PROPS"];
	}



	public static function GetInfoRecords($arFilter = array()){

		$arRes["FILTER"] = array_merge(array(/*"MODULE_ID" => "iblock"*/), $arFilter);

		$res = CEventLog::GetList(array('TIMESTAMP_X_1' => 'ASK'), $arRes["FILTER"], false);
		while($ob = $res->Fetch()){
			$ob["DESCRIPTION"] = unserialize($ob['DESCRIPTION']);
			$arRes["ITEMS"][] = $ob;
		}

		return $arRes["ITEMS"];


	}


	public static function MakeMyInfoLog($TYPE = "", $ITEM_ID = "", $DESC = array()){
		//$arRes["DESCRIPTION"] = CUtil::PhpToJSObject($DESC);

		$arRes["DESCRIPTION"] = serialize($DESC);

		return CEventLog::Add(array(
			"AUDIT_TYPE_ID" => $TYPE,
			"MODULE_ID" => "main",
			"ITEM_ID" => $ITEM_ID,
			"DESCRIPTION" => $arRes["DESCRIPTION"],
		));
	}




}
?>