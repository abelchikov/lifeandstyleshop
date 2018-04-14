<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true)?>
<?if(!empty($arResult['SECTIONS'])):?>
<?
	switch ($arParams['GRID_CATALOG_SECTIONS_COUNT']) {
		case '3': $gridStyle = "uni-33"; break;
		case '4': $gridStyle = "uni-25"; break;
		case '5': $gridStyle = "uni-20"; break;
		default : $gridStyle = "uni-50"; break;
	}
?>
<div class="catalog-sections-list uni_parent_col">
<?
	foreach ($arResult['SECTIONS'] as &$arSection)
	{
        if ($arSection['DEPTH_LEVEL'] == 1 || !($arParams['ROOT_SECTIONS'] == "Y"))
        {
            $picture = array();
    		$picture['src'] = SITE_TEMPLATE_PATH.'/images/noimg/no-img.png';
    			
    		if (!empty($arSection['PICTURE']))
    		{
    			$picture = CFile::ResizeImageGet($arSection['PICTURE']['ID'], array('width' => 300, 'height' => 300, BX_RESIZE_IMAGE_PROPORTIONAL_ALT));
    		}
    			
    		$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
    		$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
    		?>
    		<div class="uni_col <?=$gridStyle?>">
				<div class="element" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
					<a class="wrapper hover_shadow" href="<? echo $arSection["SECTION_PAGE_URL"]; ?>">
						<div class="image">
							<div>
								<div class="valign"></div>
								<img src="<?=$picture['src']?>" alt="<?=$arSection["NAME"];?>" title="<?=$arSection["NAME"];?>"/>
							</div>
						</div>
						<div class="text">
							<div class="text-wrapper">
								<? echo $arSection["NAME"];?>
								<?=$arParams["COUNT_ELEMENTS"]?'('.$arSection["ELEMENT_CNT"].')':''?>
							</div>
						</div>
					</a>
				</div>
    		</div>
    		<?
        }
	}
		
	echo '<div class="description">'.$arResult['IBLOCK']['DESCRIPTION'].'</div>';
?>
</div>
<?endif;?>