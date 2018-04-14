<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?global $options;?>
<?if(!isset($arResult["VARIABLES"]["SECTION_ID"])){	
	$rsSections = CIBlockSection::GetList(array(),array('IBLOCK_ID' => $arParams["IBLOCK_ID"], '=CODE' => $arResult["VARIABLES"]["SECTION_CODE"]));
	if ($arSection = $rsSections->Fetch()){
		$arResult["VARIABLES"]["SECTION_ID"] = $arSection["ID"];		
	}
}?>
<?$this->setFrameMode(true)?>
<div class="left_col">
	<?
	if($arParams["USE_FILTER"]=="Y"){
		$arFilter = array(
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"ACTIVE" => "Y",
			"GLOBAL_ACTIVE" => "Y",
		);
		if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
		{
			$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
		}
		elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
		{
			$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
		}

		$obCache = new CPHPCache();
		if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
		{
			$arCurSection = $obCache->GetVars();
		}
		elseif ($obCache->StartDataCache())
		{
			$arCurSection = array();
			if (\Bitrix\Main\Loader::includeModule("iblock"))
			{
				$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

				if(defined("BX_COMP_MANAGED_CACHE"))
				{
					global $CACHE_MANAGER;
					$CACHE_MANAGER->StartTagCache("/iblock/catalog");

					if ($arCurSection = $dbRes->Fetch())
					{
						$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
					}
					$CACHE_MANAGER->EndTagCache();
				}
				else
				{
					if(!$arCurSection = $dbRes->Fetch())
					$arCurSection = array();
				}
			}
			$obCache->EndDataCache($arCurSection);
		}
		if (!isset($arCurSection))
		{
			$arCurSection = array();
		}
		$db_res = CIBlockElement::GetList(
			array(),
			array("SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"]),
			false,
			array()
		);
		if ($db_res->Fetch())
		{?>
		<div id="filter" class="filter_catalog_hide">
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.smart.filter",
				"adaptiv",
		    //"visual_vertical",
				Array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"SECTION_ID" => $arCurSection['ID'],
					"FILTER_NAME" => $arParams["FILTER_NAME"],
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SAVE_IN_SESSION" => "N",
					"XML_EXPORT" => "Y",
					"SECTION_TITLE" => "NAME",
					"SECTION_DESCRIPTION" => "DESCRIPTION",
					'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
					"POPUP_POSITION" => "right",
					'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
					'CURRENCY_ID' => $arParams['CURRENCY_ID'],
					"SEF_MODE" => $arParams["SEF_MODE"],
					"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
					"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
					"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
				),
				$component,
				array('HIDE_ICONS' => 'Y')
			);?>
		</div>
		<div id="uni-filter-show" class="uni-filter uni-btn-hide uni-btn-show"><?=GetMessage("SECTION_SHOW_FILTER");?><i data-role="prop_angle" class="right fa fa-angle-down"></i></div>
		<div id="uni-filter-hide" class="uni-filter uni-btn-hide"><?=GetMessage("SECTION_HIDE_FILTER");?><i data-role="prop_angle" class="right fa fa-angle-up"></i></div>
		<script>
			$( "#uni-filter-show").click(function() {
				$('#filter').slideDown(600);
				$('#uni-filter-hide').show();
				$('#uni-filter-show').hide();
			});
			$( "#uni-filter-hide").click(function() {
				$('#filter').slideUp(600);
				$('#uni-filter-hide').hide();
				$('#uni-filter-show').show();
			});
		</script>
		<?}?>
	<?}?>
	<div class="clear"></div>
	<div class="uni-indents-vertical indent-25"></div>
	<div id="menu" class="menu_catalog_hide">
		<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"catalog_vertical", 
	array(
		"ROOT_MENU_TYPE" => "catalog",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => "catalog",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"HIDE_CATALOG" => "Y",
		"COUNT_ITEMS_CATALOG" => "20",
		"COMPONENT_TEMPLATE" => "catalog_vertical",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
	</div>
	<div id="uni-menu-show" class="uni-menu uni-btn-hide uni-btn-show"><?=GetMessage("SECTION_SHOW_MENU");?><i data-role="prop_angle" class="right fa fa-angle-down"></i></div>
	<div id="uni-menu-hide" class="uni-menu uni-btn-hide"><?=GetMessage("SECTION_HIDE_MENU");?><i data-role="prop_angle" class="right fa fa-angle-up"></i></div>
	<script>
		$( "#uni-menu-show").click(function() {
		$('#menu').slideDown(600);
		$('#uni-menu-hide').show();
		$('#uni-menu-show').hide();
		});
		$( "#uni-menu-hide").click(function() {
		$('#menu').slideUp(600);
		$('#uni-menu-hide').hide();
		$('#uni-menu-show').show();
		});
	</script>
</div><!--left_col_index-->
<div class="right_col inner_section_list">
	<?
		$viewSections = $options['CATALOG_VIEW']['ACTIVE_VALUE'];
	?>
	<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.section.list",
			$viewSections,
			Array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
				"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
				"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
				"GRID_CATALOG_SECTIONS_COUNT" => $arParams['GRID_CATALOG_SECTIONS_COUNT']
			),
			$component
		);?>
		<div class="clear"></div>
		<?
		$db_res = CIBlockElement::GetList(
			array(),
			array("SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"]),
			false,
			array()
		);?>
		<?if($db_res->Fetch()):?>
		<?
			$sort=$_GET['sort'];
		  $sort_p=$_GET['sort'];

		  $count_elem=$_GET["count"];

			if(empty($sort)){
				$sort=null;
				$sort_p=null;
			}
			if(empty($count_elem)){
				$count_elem=10;
			}
			if($_GET['sort']=="name"){
				$sort='name';	
				$sort_p='name';		
			} 
			if($_GET['sort']=="price"){
				$sort='catalog_PRICE_1';
				$sort_p='price';			
			}
			if($_GET['sort']=="pop"){
				$sort='show_counter';
				$sort_p='pop';
			}
      if($_GET['sort']=="none"){
				$sort = null;
				$sort_p = null;
			}
		?>
		<?
            if (strlen($options["CATALOG_SECTION_DEFAULT_VIEW"]["ACTIVE_VALUE"]) > 0)
            {
            	$view = $options["CATALOG_SECTION_DEFAULT_VIEW"]["ACTIVE_VALUE"];
            }
            else
            {
            	$view = $options["CATALOG_SECTION_DEFAULT_VIEW"]["DEFAULT_VALUE"];
            }
        
			if ( isset($_COOKIE['view'])) {
				if ($_COOKIE['view']=='list') {
					$view = "list";
				} 
				if ($_COOKIE['view']=='text') {
					$view = "text";
				}
				if ($_COOKIE['view']=='tile') {
					$view = "tile";
				}
			}
			
			if ( isset($_GET['view'])) {
				if ($_GET['view']=='list') {
					setcookie("view", 'list', time()+60*60*24*7, '/');
					$view = "list";
				}
				if ($_GET['view']=='text') {
					setcookie("view", 'text', time()+60*60*24*7, '/');
					$view = "text";
				}
				if ($_GET['view']=='tile') {
					setcookie("view", 'tile', time()+60*60*24*7, '/');
					$view = "tile";
				}
			}
		
			$order="desc";
			if ( isset($_GET['order'])) {
				if ($_GET['order']=='asc') {				
					$order = "asc";
				}
				if ($_GET['order']=='desc') {				
					$order = "desc";
				}			
			}		
		?>
        <?if($order=="desc"){
			$order_p="asc";
		}else{
			$order_p="desc";
		}?>
		<div class="uni-panel-sort">
			<div class="sort">		
                <div class="uni-aligner-vertical"></div>
				<div class="values">
					<div class="value<?=($sort_p=='name'?' ui-state-active':'')?>">
						<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('sort=name&order='.$order_p,array('sort','order'),false);?>">
                            <?=GetMessage("SECTION_SORT_NAME")?>
							<div class="icon <?=$order?>"></div>
						</a>
					</div>
					<div class="value<?=($sort_p=='price'?' ui-state-active':'')?>">
						<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('sort=price&order='.$order_p,array('sort','order'),false);?>">
							<?=GetMessage("SECTION_SORT_PRICE")?>
							<div class="icon <?=$order?>"></div>
						</a>
					</div>

          <div class="value<?=($sort_p=='created_date'?' ui-state-active':'')?>">
            <a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('sort=created_date&order='.$order_p,array('sort','order'),false);?>">
				      По новизне
              <div class="icon <?=$order?>"></div>
            </a>
          </div>

					<div class="value<?=($sort_p=='pop'?' ui-state-active':'')?>">
						<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('sort=pop&order='.$order_p,array('sort','order'),false);?>">
                            <?=GetMessage("SECTION_SORT_POPUL")?>
							<div class="icon <?=$order?>"></div>
						</a>
					</div>
                    <div class="value<?=($sort_p==null?' ui-state-active':'')?>">
						<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('sort=none', array('sort','order'),false);?>">
                            <?=GetMessage("SECTION_SORT_NONE")?>
						</a>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="view">
                <div class="uni-aligner-vertical"></div>
				<div class="caption"><?//=GetMessage("SECTION_SORT_TITLE_VIEW")?></div>
                <div class="views">
    				<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('view=text',array('view'),false)?>" class="text<?=($view=="text"?' ui-state-active':'')?>"></a>
    				<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('view=list',array('view'),false)?>" class="list<?=($view=="list"?' ui-state-active':'')?>"></a>
    				<a rel="nofollow" href="<?=$APPLICATION->GetCurPageParam('view=tile',array('view'),false)?>" class="tile<?=($view=="tile"?' ui-state-active':'')?>"></a>
	            </div>
            </div>	
		</div>
	<?else:?>
		<?$view = "tile";?>
	<?endif;?>
    <div class="uni-indents-vertical indent-15"></div>
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section",
		$view,
		Array(
			"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"ELEMENT_SORT_FIELD" => !empty($sort)?$sort:$arParams['ELEMENT_SORT_FIELD'],
			"ELEMENT_SORT_ORDER" => !empty($sort)?$order:$arParams['ELEMENT_SORT_ORDER'],
			"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
			"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
			"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
			"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
			"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
			"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
			"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
			"BASKET_URL" => $arParams["BASKET_URL"],
			"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
			"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
			"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
			"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
			"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
			"FILTER_NAME" => $arParams["FILTER_NAME"],
			"CACHE_TYPE" => $arParams["CACHE_TYPE"],
			"CACHE_TIME" => $arParams["CACHE_TIME"],
			"CACHE_FILTER" => $arParams["CACHE_FILTER"],
			"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
			"SET_TITLE" => $arParams["SET_TITLE"],
			"SET_STATUS_404" => $arParams["SET_STATUS_404"],
			"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
			"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
			"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
			"PRICE_CODE" => $arParams["PRICE_CODE"],
			"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
			"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

			"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
			"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
			"QUANTITY_FLOAT" => $arParams["QUANTITY_FLOAT"],
			"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

			"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
			"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
			"PAGER_TITLE" => $arParams["PAGER_TITLE"],
			"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
			"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
			"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
			"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
			"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
			"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
			"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
			"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
			"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
			"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
			"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
			"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
			"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
			"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
			"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
			"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
			"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
			'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
			'CURRENCY_ID' => $arParams['CURRENCY_ID'],
			'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
			"COMPARE_NAME" => $arParams["COMPARE_NAME"]
		),
		$component
	);
	?>
	<div class="clear"></div>
	<?
	$resSection = CIBlockSection::GetByID($arResult["VARIABLES"]["SECTION_ID"]);
	if($arrSection = $resSection->GetNext())
		$sectionDescription = $arrSection['DESCRIPTION'];
	if (!empty($sectionDescription)):?>
		<div class="uni-indents-vertical indent-20"></div>
		<div class="in_sec_desription">
			<?=$sectionDescription?>
		</div>
		<div class="uni-indents-vertical indent-20"></div>
	<?endif;?>
</div>
<div class="clear"></div>
