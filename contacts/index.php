<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?><?$APPLICATION->IncludeComponent(
	"bitrix:news",
	"contacts",
	Array(
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "contacts",
		"CONTACT_FORM_ID" => "5",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => array(0=>"",1=>"",),
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PROPERTY_CODE" => array(0=>"ADDRESS",1=>"MAP",2=>"PHONES",3=>"WORK",4=>"EMAIL",5=>"",),
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_ID" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "9",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array(0=>"",1=>"",),
		"LIST_PROPERTY_CODE" => array(0=>"ADDRESS",1=>"MAP",2=>"PHONES",3=>"WORK",4=>"EMAIL",5=>"",),
		"MAIN_ELEMENT_CODE" => "",
		"MAIN_ELEMENT_ID" => "2382",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SECTION_ALL_ENABLED" => "Y",
		"SEF_FOLDER" => "/contacts/",
		"SEF_MODE" => "Y",
		"SEF_URL_TEMPLATES" => array("news"=>"","section"=>"","detail"=>"#ELEMENT_ID#/",),
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_REVIEW" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "N"
	),
false,
Array(
	'ACTIVE_COMPONENT' => 'N'
)
);?> <br>
 <b><span style="font-family: &quot;Times New Roman&quot;, Times;">Адрес:</span></b><span style="font-family: &quot;Times New Roman&quot;, Times;"> Санкт - Петербург,</span><br>
<span style="font-family: &quot;Times New Roman&quot;, Times;">
ул.Большая Пушкарская д.38 (вход с улицы)</span><br>
<span style="font-family: &quot;Times New Roman&quot;, Times;"> </span><br>
<span style="font-family: &quot;Times New Roman&quot;, Times;"> </span><b><span style="font-family: &quot;Times New Roman&quot;, Times;">Режим работы: </span></b><span style="font-family: &quot;Times New Roman&quot;, Times;">11:00-21:00 без обедов и выходных</span><br>
<table cellpadding="0" cellspacing="0" align="center" style="width: 100%;">
<tbody>
<tr>
	<td>
		 <script type="text/javascript" src="//vk.com/js/api/openapi.js?150"></script> <!-- VK Widget -->
		<div id="vk_groups">
		</div>
		 <script type="text/javascript">
VK.Widgets.Group("vk_groups", {mode: 3}, 23783553);
</script>
	</td>
	<td>
		 <iframe src="//widget.instagramm.ru/?imageW=2&imageH=2&thumbnail_size=117&type=0&typetext=lifeandstyle_shop&head_show=1&profile_show=1&shadow_show=1&bg=255,255,255,1&opacity=true&head_bg=46729b&subscribe_bg=ad4141&border_color=c3c3c3&head_title=" allowtransparency="true" frameborder="0" scrolling="no" style="border:none;overflow:hidden;width:260px;height:399px;"></iframe>
	</td>
</tr>
</tbody>
</table><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>