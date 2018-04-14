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
$this->setFrameMode(true);
$subSectionsMaxCount = 4;
$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));?>
<div class="catalog-sections-list uni_parent_col list">
<?
	foreach ($arResult['SECTIONS'] as &$arSection)
	{
        if ($arSection['DEPTH_LEVEL'] == 1 || !($arParams['ROOT_SECTIONS'] == "Y")) 
        {
            $arSubSections = array();
            $rsSubSections = CIBlockSection::GetList(
                array(),
                array(
                    'SECTION_ID' => $arSection['ID'],
                    'DEPTH_LEVEL' => ($arSection['DEPTH_LEVEL'] + 1)
                ),
                true
            );
            
            while ($arSubSection = $rsSubSections->GetNext())
            {
                $arSubSections[] = $arSubSection;
            }
			
			$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
			$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
			?><div class="element uni_col uni-50" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
				<div class="content">
					<div>
						<div class="text">
							<a class="name hover_link" href="<?=$arSection["SECTION_PAGE_URL"]; ?>">
								<?=$arSection["NAME"];?> <?=$arParams["COUNT_ELEMENTS"]?'('.$arSection["ELEMENT_CNT"].')':''?>
							</a>
                            <?if (empty($arSubSections)):?>
    							<div class="description">
    								<?=$arSection["DESCRIPTION"];?>
    							</div>
                            <?else:?>
                                <div class="subsections">
                                    <?$count = 0;?>
                                    <?foreach ($arSubSections as $arSubSection):?>
                                        <?if ($count < $subSectionsMaxCount):?>
                                            <a class="subsection hover_link" href="<?=$arSubSection["SECTION_PAGE_URL"]; ?>"><?=$arSubSection['NAME']?> <?=$arParams["COUNT_ELEMENTS"]?'('.$arSubSection["ELEMENT_CNT"].')':''?></a>
                                        <?endif;?>
                                        <?$count++;?>
                                    <?endforeach;?>
                                </div>
                            <?endif;?>
						</div>
					</div>
				</div>
			</div><?
        }
	}
?>
	<div class="description uni_col uni-100"><?=$arResult['IBLOCK']['DESCRIPTION']?></div>
</div>