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
?>
<div class="standart_block subscribe-form main_page">
	<div class="title"><?=GetMessage("TITLE_SUBSCRIBE")?></div>
<?$frame = $this->createFrame("subscribe-form", false)->begin();?>
	<form action="<?=$arResult["FORM_ACTION"]?>">
		<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
			<label for="sf_RUB_ID_<?=$itemValue["ID"]?>" style="display:none;">
				<input type="checkbox" name="sf_RUB_ID[]" id="sf_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?> /> <?=$itemValue["NAME"]?>
			</label>
		<?endforeach;?>
		<div class="s_block">
			<input type="text" class="email" name="sf_EMAIL" size="20" value="<?=$arResult["EMAIL"]?>" placeholder="<?=GetMessage("subscr_form_email_title")?>" title="<?=GetMessage("subscr_form_email_title")?>" />
			<div class="clearfix"></div>
		</div>
		<div class="s_submit">
			<input type="submit" class="solid_button light_button submit" name="OK" value="<?=GetMessage("subscr_form_button")?>" />
		</div>
	</form>
<?
$frame->beginStub();
?>
	<form action="<?=$arResult["FORM_ACTION"]?>">
		<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
			<label for="sf_RUB_ID_<?=$itemValue["ID"]?>" style="display:none;">
				<input type="checkbox" name="sf_RUB_ID[]" id="sf_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?> /> <?=$itemValue["NAME"]?>
			</label>
		<?endforeach;?>
		<div class="s_block">
			<input type="text" class="email" name="sf_EMAIL" size="20" value="<?=$arResult["EMAIL"]?>" placeholder="<?=GetMessage("subscr_form_email_title")?>" title="<?=GetMessage("subscr_form_email_title")?>" />
			<div class="clearfix"></div>
		</div>
		<div class="s_submit">
			<input type="submit" class="solid_button light_button submit" name="OK" value="<?=GetMessage("subscr_form_button")?>" />
		</div>
	</form>
<?
$frame->end();
?>
<div class="clear"></div>
</div>
