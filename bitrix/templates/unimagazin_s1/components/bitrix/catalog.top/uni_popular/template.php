<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
$this->setFrameMode(true);
global $APPLICATION;?>
<?$frame = $this->createFrame()->begin()?>
<?if (!empty($arResult['ITEMS']) && count($arResult['ITEMS'])) {

	switch($arParams["LINE_ELEMENT_COUNT"]){
		case "1":
			$class_grid = "uni-100";
		break;
		case "2":
			$class_grid = "uni-50";
		break;
		case "3":
			$class_grid = "uni-33";
		break;
		case "4":
			$class_grid = "uni-25";
		break;
		case "5":
			$class_grid = "uni-20";
		break;
		case "6":
			$class_grid = "uni-16";
		break;
		default:
			$class_grid = "uni-25";
		break;		
	}?>
<div class="popular_list clearfix standart_block">
	<h3 class="header_grey"><?=$arParams["TEXT_POPULAR_PRODUCTS"];?></h3>
	<ul class="popular clearfix uni_parent_col">
		<?foreach( $arResult["ITEMS"] as $arItem ){
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
			?>
			<?$db_groups = CIBlockElement::GetElementGroups($arItem["ID"], true);			
			while($ar_group = $db_groups->Fetch()){
				$parent_group = $ar_group["ID"];
				break;
			}
			$res = CIBlockSection::GetByID($parent_group);
			if($ar_res = $res->GetNext()){
				$name_parent_group = $ar_res['NAME'];
				$url_parent_group = $ar_res["SECTION_PAGE_URL"];
			}
			?>
			<li class="uni_col <?=$class_grid?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div class="one_section_product_cells hover_shadow">
					<?if(!empty($arItem["DETAIL_PICTURE"]["SRC"])){
						$file = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"],array('width'=>300, 'height'=>300),"BX_RESIZE_IMAGE_PROPORTIONAL_ALT");
								$src=$file['src'];
							}else{
								$src=SITE_TEMPLATE_PATH."/images/noimg/no-img.png";
						}?>
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="image_product" style="background-image:url(<?=$src?>)" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>">	
						<div class="marks">
							<?if($arItem["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"]){?>
								<span class="mark action">- <?=$arItem["MIN_PRICE"]["DISCOUNT_DIFF_PERCENT"];?> %</span>
							<?}?>
							<?if( $arItem["PROPERTIES"]["HIT"]["VALUE"] ){?>
								<span class="mark hit"><?=GetMessage("MESSAGE_HIT");?></span>
							<?}?>			
							<?if( $arItem["PROPERTIES"]["NEW"]["VALUE"] ){?>
								<span class="mark new"><?=GetMessage("MESSAGE_NEW");?></span>
							<?}?>
							<?if( $arItem["PROPERTIES"]["RECOMMEND"]["VALUE"] ){?>
								<span class="mark recommend"><?=GetMessage("MESSAGE_RECOMMEND");?></span>
							<?}?>
						</div>	
													
					</a>	
						<?if($arParams["DISPLAY_COMPARE"]=="Y"):?>
						<div class="min-buttons">
							<div class="min-button like">
								<div class="add"								
									onclick="add_to_like(this,'<?=$arItem['ID']?>',1);"
									id="like_<?=$arItem["ID"]?>"
									title="<?=GetMessage('LIKE_TEXT_DETAIL')?>"
								>
                                    <i class="fa fa-star-o"></i>
								</div>
								<div class="remove"
									style="display:none"
									id="liked_<?=$arItem["ID"]?>"								
									onclick="return delete_to_like(this,'<?=$arItem['ID']?>',1);"
									title="<?=GetMessage('LIKE_DELETE_TEXT_DETAIL')?>"
								>
                                    <i class="fa fa-star-o"></i>
								</div>
							</div>
							<div class="min-button compare">
								<div class="add"
									onclick="add_to_compare(this,'<?=$arParams['~IBLOCK_TYPE']?>','<?=$arParams["IBLOCK_ID"]?>','<?=$arParams["COMPARE_NAME"]?>','<?=$arItem['COMPARE_URL']?>')"
									id="textcomp_<?=$arItem["ID"]?>"	
									title="<?=GetMessage('COMPARE_TEXT_DETAIL')?>"
								>
									<?//echo GetMessage("CATALOG_COMPARE")?>
								</div>
								<div  class="remove"
									style="display:none"
									id="addedcomp_<?=$arItem["ID"]?>" 
									onclick="return delete_to_compare(this,'<?=$arParams['~IBLOCK_TYPE']?>','<?=$arParams["IBLOCK_ID"]?>','<?=$arParams["COMPARE_NAME"]?>','<?=SITE_DIR?>catalog/compare.php?action=DELETE_FROM_COMPARE_RESULT&ID=<?=$arItem['ID']?>')"
									title="<?=GetMessage('COMPARE_DELETE_TEXT_DETAIL')?>"
								>
									<?//echo GetMessage("CATALOG_COMPARED")?>
								</div>
							</div>
						</div>
					<?endif?>
					<div class="name_product title_product">
						<a class="name" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
						<a class="name_group" href="<?=$url_parent_group ?>"><?=$name_parent_group;?></a>
					</div>				
					<?
						$flg_offers=0;
						$flg_offers_can_buy = false;
						$newprice = $arItem["MIN_PRICE"]["PRINT_DISCOUNT_VALUE"];
						$oldprice = "";
						if( $arItem['MIN_PRICE']['DISCOUNT_VALUE'] < $arItem['MIN_PRICE']['VALUE'] ) {
							$oldprice= $arItem["MIN_PRICE"]["PRINT_VALUE"];
						}		
						
						if( !empty($arItem["OFFERS"]) )
						{
							$flg_offers=1;		
							
							$arOffer = current($arItem['OFFERS']);
							$newprice = $arOffer['MIN_PRICE']["PRINT_DISCOUNT_VALUE"];
							if( $arOffer['MIN_PRICE']['DISCOUNT_VALUE'] < $arOffer['MIN_PRICE']['VALUE'] ) {
								$oldprice= $arOffer["MIN_PRICE"]["PRINT_VALUE"];
							}
								
							foreach ($arItem["OFFERS"] as $arOffer)
							{
								$arOffer = current($arItem['OFFERS']);
								$newprice = $arOffer['MIN_PRICE']["PRINT_DISCOUNT_VALUE"];
								if( $arOffer['MIN_PRICE']['DISCOUNT_VALUE'] < $arOffer['MIN_PRICE']['VALUE'] ) {
									$oldprice= $arOffer["MIN_PRICE"]["PRINT_VALUE"];
								}
								
								if ($arOffer['CAN_BUY'])
								{
									$flg_offers_can_buy = true;
								}
							}
							
							$newprice="<span>".GetMessage("CT_BCS_TPL_MESS_PRICE_FROM")."</span> ".$newprice;
							
                            if (!empty($oldprice))
                                $oldprice = GetMessage("CT_BCS_TPL_MESS_PRICE_FROM").' '.$oldprice;
						}
					?>	
					<div class="buys">		
						<div class="price_block">							
							<div class="new_price">
								<?=$newprice?>
							</div>
							<?if($oldprice!="") { ?>
								<div class="old_price"><?=$oldprice?></div>
							<? } ?>				
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
			</li>
		<?}?>
	</ul>
</div>
<?}?>
<?$frame->end();?>