<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
	<?if (!empty($arResult)):
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
			$class_grid = "uni-16.6";
		break;
		default:
			$class_grid = "uni-25";
		break;		
	}
	$id = rand(0,10000);
	$flag_count = count($arResult) > 4 ? true : false;?>
	<?//echo $templateFolder;?>
	<div class="view-list-slider clearfix standart_block">
		<h3 class="header_grey"><?=$arParams["VIEWED_TITLE"];?></h3>
		<div>
			<div style="position: relative;" class="uni_parent_col">
				<ul id="view_slider_<?=$id?>">
					<?foreach($arResult as $arItem):?>
						<li class="<?=!$flag_count?'uni_col uni-25':''?>">
							<div class="view-item clearfix hover_shadow">
								<div class="clearfix" style="padding:9px">
									<?if($arParams["VIEWED_IMAGE"]=="Y"):?>
                                        <?if($arItem["PREVIEW_PICTURE"]) { ?>
                                            <?$src = CFile::GetPath($arItem["PREVIEW_PICTURE"]);?>
                                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="left_block" style="background-image:url('<?=$src?>')">
                                            </a>
                                        <?}?>
									<?endif?>
									<div class="right_block">
										<?if($arParams["VIEWED_NAME"]=="Y"):?>
											<a class="name" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=TruncateText($arItem["NAME"],30)?></a>
										<?endif?>
										<div class="price"><?=$arItem["PRICE_FORMATED"]?></div>
									</div>
								</div>
							</div>
						</li>
					<?endforeach;?>
				</ul>
			</div>
		</div>
		<?if($flag_count){?>
			<script>
				$('#view_slider_<?=$id?>').flexisel({
					visibleItems: <?=$arParams["LINE_ELEMENT_COUNT"]?>,
					animationSpeed: 500,		
					autoPlay: false,
					autoPlaySpeed: 3000,            
					pauseOnHover: true,
					clone : false,
					enableResponsiveBreakpoints: true,
					responsiveBreakpoints: { 
						portrait: { 
							changePoint:640,
							visibleItems: 2
						}, 
							landscape: { 
							changePoint:640,
							visibleItems: 3
						},
						tablet: { 
							changePoint:1000,
							visibleItems: 3
						},
							landscape: { 
							changePoint:1000,
							visibleItems: 3
						},           
							tablet: { 
							changePoint:350,
							visibleItems: 1
						}, 
					}
				});
			</script>
		<?}?>
	</div>
	<?endif;?>
<?$frame->end();?>