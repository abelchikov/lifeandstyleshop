<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<?$frame = $this->createFrame()->begin()?>
<div class="product_element standart_block hover_shadow">
	<div class="solid_element">
		<?=$arParams["TEXT_PRODUCT_DAY"]?>
	</div>
	<?$flg_offers=0;
	$flg_tax=0;
	$economy=0;
	if(empty($arResult["OFFERS"])){	
		if(is_array($arResult["PRICES"])){			
			foreach($arResult["PRICES"] as $price){			
				$newprice_v=$price["DISCOUNT_VALUE_NOVAT"];
				$newprice=preg_replace("/^([\d\s\.\,]+)(.*)$/", '$1<span>$2</span>',$price["PRINT_DISCOUNT_VALUE_NOVAT"]);				
				if((int)$price["DISCOUNT_DIFF"]!=0){
					$oldprice_v=$price["VALUE_NOVAT"];
					$oldprice=preg_replace("/^([\d\s\.\,]+)(.*)$/", '$1<span>$2</span>',$price["PRINT_VALUE_NOVAT"]);
					$tax=(int)(($oldprice_v-$newprice_v)/$oldprice_v*100);			
					$flg_tax=1;
					$economy=$price["PRINT_DISCOUNT_DIFF"];
				}
				break;
			}
		}
	}else{
		$oldprice="";
		$flg_offers=1;
		$newprice=preg_replace("/^([\d\s\.\,]+)(.*)$/", '$1<span>$2</span>',$arResult["MIN_PRICE"]["PRINT_DISCOUNT_VALUE_NOVAT"]);
		$newprice_v=$arResult["MIN_PRICE"]["DISCOUNT_VALUE_NOVAT"];
		if((int)$arResult["MIN_PRICE"]["DISCOUNT_DIFF"]!=0){
			$oldprice_v=$arResult["MIN_PRICE"]["VALUE_NOVAT"];
			$oldprice=preg_replace("/^([\d\s\.\,]+)(.*)$/", '$1<span>$2</span>',$arResult["MIN_PRICE"]["PRINT_VALUE_NOVAT"]);
			$tax=(int)(($oldprice_v-$newprice_v)/$oldprice_v*100);	
			$flg_tax=1;
			$economy=$arResult["MIN_PRICE"]["PRINT_DISCOUNT_DIFF"];
			
		}
	}?>
	<?if(!empty($arResult["DETAIL_PICTURE"]["SRC"])){
		$file = CFile::ResizeImageGet($arResult["DETAIL_PICTURE"],array('width'=>209, 'height'=>172),"BX_RESIZE_IMAGE_PROPORTIONAL_ALT");
		$src=$file['src'];
	}else if(!empty($arResult["PREVIEW_PICTURE"]["SRC"])){
		$file = CFile::ResizeImageGet($arResult["PREVIEW_PICTURE"],array('width'=>209, 'height'=>172),"BX_RESIZE_IMAGE_PROPORTIONAL_ALT");
		$src=$file['src'];
	}else{
		$src=SITE_TEMPLATE_PATH."/images/noimg/noimg_quadro.jpg";
	}?>
	<a href="<?=$arParams["HREF_TO_DETAIL"]?>" class="img_product_day" style="background-image:url(<?=$src?>)">		
		<div class="marks">
			 <?if( $arResult["PROPERTIES"]["RECOMMEND"]["VALUE"] ){?>
				<span class="mark recommend"><?=GetMessage('MARK_RECOMEND')?></span>
			<?}?>
			<?if( $arResult["PROPERTIES"]["NEW"]["VALUE"] ){?>
				<span class="mark new"><?=GetMessage('MARK_NEW')?></span>
			<?}?>
			<?if( $arResult["PROPERTIES"]["HIT"]["VALUE"] ){?>
				<span class="mark hit"><?=GetMessage('MARK_HIT')?></span>
			<?}?>
		</div>	
	</a>
	<div class="name_product"><a href="<?=$arParams["HREF_TO_DETAIL"]?>"><?=$arResult['NAME']?></a></div>
	<div class="price_block">
		<div class="new_price"><?=$newprice?></div>
		<?if($oldprice!=""){?>
			<div class="old_price"><?=$oldprice?></div>
		<?}?>
	</div>
	<?$data=date("j F Y",strtotime($arResult["PROPERTIES"]["DAY_PROD"]["VALUE"]));?>
	<?if($arParams["DATE_PRODUCT_DAY"]=="Y") { ?>
		<div class="time"> 
			<input type="hidden"  id="data_product" value="<?=$data?>"/>
			<div class="countdown">
				<table id="countdown">
				<tr>
					<td id="pd_num_day" class="pd_td"></td>
					<td class="pd_num_separator" style="padding-left:15px;"></td>
					<td id="pd_num_hour" class="pd_td"></td>
					<td class="pd_num_separator">:</td>
					<td id="pd_num_min" class="pd_td"></td>
					<td class="pd_num_separator">:</td>
					<td id="pd_num_sec" class="pd_td"></td>
				</tr>	
				<tr>
					<td class="pdtd"><?=GetMessage("DAY")?></td>
					<td ></td>
					<td class="pdtd"><?=GetMessage("CLOCK")?></td>
					<td ></td>
					<td class="pdtd"><?=GetMessage("MINUTS")?></td>
					<td ></td>
					<td class="pdtd"><?=GetMessage("SECUND")?></td>
				</tr>			
				</table>
				<div id="action_end" style="display:none;">
					<?=GetMessage('ACTION_END')?>
				</div>				
			</div>
		</div>
		<script type="text/javascript">
			function start_conuntdown(){
				var data = document.getElementById("data_product").value;
				var today = new Date().getTime();
				var end = new Date(data).getTime();
				var dateX = new Date(end-today);
				var perDays = 60*60*1000*24;
				if(dateX>0){ 
					document.getElementById("pd_num_day").innerHTML = Math.round(dateX/perDays);
					document.getElementById("pd_num_hour").innerHTML = dateX.getUTCHours().toString();
					document.getElementById("pd_num_min").innerHTML = dateX.getMinutes().toString();
					document.getElementById("pd_num_sec").innerHTML = dateX.getSeconds().toString() ;
				}
				else {
					$('#countdown').hide();
					$('#action_end').show();				
				}
			}
			setInterval(start_conuntdown, 1000);   /* РґР°РµР�? РёРЅС‚РµСЂРІР°Р» РІС‹Р·РѕРІР° С„СѓРЅРєС†РёРё РІ 1 СЃРµРєСѓРЅРґСѓ */
		</script>
	<?}?>
</div>
<?$frame->end()?>
