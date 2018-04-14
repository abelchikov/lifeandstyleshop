<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true)?>
<?if(is_array($arResult["ITEMS"])){?>
	<div class="faq_block">
	<div class="title"><?=GetMessage("CT_TITLE")?></div>
	<?foreach($arResult["ITEMS"] as $arItem){?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>			
			<div class="one_faq" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div>
					<span class="title_question_faq"><?=GetMessage("QUESTION")?></span>	
					<span class="question_faq"><?=$arItem["NAME"];?></span>
				</div>
				<div class="arrow_faq"></div>
				<div class="answer_faq">
					<?=$arItem["DETAIL_TEXT"]?>
				</div>						
			</div>
		<?}?>
		<?if(CModule::IncludeModule("form")){?> 
			<input type="hidden" name="name_resume" value="<?=$arItem["NAME"];?>"> 
			<div href="" rel="nofollow" class="uni-button solid_button send_question" onclick="openFaqPopup('<?=$arItem["ID"]?>','<?=SITE_DIR?>');"><?=GetMessage("RESUME")?></div>
		<?}?>
	</div>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>	
	<script type="text/javascript">
		function openFaqPopup (id,site_dir) {
			var faqPopup = BX.PopupWindowManager.create("FaqPopup", null, {
				autoHide: true,			
				offsetLeft: 0,
				offsetTop: 0,
				overlay : true,
				draggable: {restrict:true},
				closeByEsc: true,
				closeIcon: { right : "20px", top : "16px"},
				content: '<div style="width:404px;height:401px; text-align: center;"><span style="position:absolute;left:50%; top:50%"><img src="/images/wait.gif"/></span></div>',
				events: {
					onAfterPopupShow: function()
					{
						BX.ajax.post(
								site_dir+'ajax/faq.php',
								{
									
								},
								BX.delegate(function(result)
								{
									this.setContent(result);
								},
								this)
						);
					}
				},
				buttons: [
					   new BX.PopupWindowButton({
						  className: "bx_popup_close" ,
						  events: {click: function(){
							 this.popupWindow.close();
						  }}
					   })
				]
			});
			faqPopup.show();
		}
	</script>
<?}?>