<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?/*27.03.14 artefact
в $arParams нужно добавить:
		IMAGE - картинка
		NAME_PRODUCT - имя товара
		NEW_PRICE - новая цена
		OLD_PRICE - старая цена		
*/?>
<div class="ocb-form">
	<div class="title"><?=GetMessage('FORM_HEADER_CAPTION')?></div>	
	<div class="comment"></div>
	<div class="ocb-form-wrap">
		<div class="price_image">
			<div class="image" style="background-image:url(<?=$arParams["IMAGE"]?>)"></div>
			<div class="name_product"><?=$arParams["NAME_PRODUCT"]?></div>
			<div class="price">
				<span class="new_price"><?=$arParams["NEW_PRICE"]?></span>
				<?if(!empty($arParams["OLD_PRICE"])){?>
					<span class="old_price"><?=$arParams["NEW_PRICE"]?></span>
				<?}?>
			</div>
		</div>
		<form method="post" id="ocb-form" class="nosubit_ocb" action="<?=$arResult['SCRIPT_PATH']?>/script.php">
			<div class="ocb-form-result" id="ocb-form-result">
					<div class="ocb-result-icon-success" style="display:none;"><?=GetMessage('ORDER_SUCCESS')?></div>
					<div class="ocb-result-icon-fail" style="display:none;"><?=GetMessage('ORDER_ERROR')?> <span></span></div>
					<div class="ocb-result-text" style="display:none;"><?=GetMessage('ORDER_SUCCESS_TEXT')?></div>
			</div>
			<div id="ocb-params">
				<input type="hidden" name="buyMode" value="<?=$arParams['BUY_MODE']?>" />
				<input type="hidden" name="PRODUCT_ID" value="<?=$arParams['ELEMENT_ID']?>" />
				<input type="hidden" name="paysystemId" value="<?=$arParams['DEFAULT_PAYMENT']?>" />
				<input type="hidden" name="deliveryId" value="<?=$arParams['DEFAULT_DELIVERY']?>" />
				<input type="hidden" name="personTypeId" value="<?=$arParams['DEFAULT_PERSON_TYPE']?>" />
				<input type="hidden" name="PRICE_ID" value="<?=$arParams['PRICE_ID']?>" />
				<input type="hidden" name="CURRENCY" value="<?=$arParams['DEFAULT_CURRENCY']?>" />
				<?=bitrix_sessid_post()?>
				<?foreach ( $arParams['PROPERTIES'] as $field ) {
					if ($USER->IsAuthorized())	{
						if ($field=='EMAIL')	{
							$value = $USER->GetEmail();
						}
						elseif ($field=='USER_NAME') {
							$value = $USER->GetFullName();
						}
						else  { 
							$value = $arResult['USER_PHONE'];
						}	?>	
					<?}?>
					<div class="ocb-form-field">
						<label><?=GetMessage('CAPTION_'.$field)?>
							<? if (in_array($field, $arParams['REQUIRED'])):?><span class="starrequired">*</span><?endif;?>
						</label>
						<?if ($field=="COMMENT"):?>
							<textarea name="ONE_CLICK_BUY[<?=$field?>]" id="ocb-id-<?=$field?>"></textarea>
							<? if (in_array($field, $arParams['REQUIRED'])):?><div class="requared"><?=GetMessage("IBLOCK_FORM_IMPORTANT")?></div><?endif;?>
						<?else:?>
							<input type="text" name="ONE_CLICK_BUY[<?=$field?>]" value="<?=$value?>" id="ocb-id-<?=$field?>" />
							<? if (in_array($field, $arParams['REQUIRED'])):?><div class="requared"><?=GetMessage("IBLOCK_FORM_IMPORTANT")?></div><?endif;?>
						<?endif;?>
						
					</div>
				<?}?>
				
				<div class="ocb-modules-button">
					<button class="button" type="submit" id="ocb-form-button" name="ocb_form_button" value="<?=GetMessage('ORDER_BUTTON_CAPTION')?>">
						<span><?=GetMessage("ORDER_BUTTON_CAPTION")?></span>
					</button>
					<div class="promt">
						<span><span class="starrequired">*</span>-<?=GetMessage("IBLOCK_FORM_PROMPT");?></span>
					</div>
				</div>
				<div class="ocb-form-loader"></div>
			</div>
			
		</form>		
	</div>
	
</div>
<script type="text/javascript">
	$('.nosubit_ocb').on('submit',function(event){
		event.preventDefault();
		flagrequared=1;
		$('.starrequired').each(function(i,el){	
			var element=$(el).parent().parent().find('input,textarea');			
			if(element.val()==''){
				element.addClass('nofill');
				element.next().show();
				flagrequared=0;
			}else{
				element.removeClass('nofill');
				element.next().hide();
				//flagrequared=1;
			}
		})	
		//alert(flagrequared);
		if(!flagrequared){
			return false;
		}else{			
			$.ajax({
				url: $(this).attr('action'),
				data: $(this).serialize(),
				type: 'POST',
				dataType: 'json',				
				success: function(Res) 
				{							
					$('.ocb-result-icon-fail').hide();
					if(Res.result=='Y') {
						$('#ocb-params').hide();
						$('.ocb-result-icon-success').show();
						$('.ocb-result-text').show();
						return false;
					}else{
						$('.ocb-result-icon-fail span').html(Res.message);
						$('.ocb-result-icon-fail').show();
						return false;
					}					
				}
			});
			return false;
		}
	});
</script>