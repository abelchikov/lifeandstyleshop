<?
	$arElements = array();
	$rsElements = null;
		
	if ($arParams['SECTION_ID'] > 0)
	{
		$rsElements = CIBlockElement::GetList(array(), array('SECTION_ID' => $arParams['SECTION_ID']));
	}
	else if ($arParams['SECTION_CODE'])
	{
		$rsElements = CIBlockElement::GetList(array(), array('SECTION_CODE' => $arParams['SECTION_CODE']));
	}
		
	if ($rsElements != null)
	{
		while ($rsElement = $rsElements->GetNextElement())
		{
			$arElement = $rsElement->GetFields();
			$arElement['PROPERTIES'] = $rsElement->GetProperties();
			
			if ($arElement['ID'] != $arResult['ID'])
				$arElements[] = $arElement;
		}
	}
?>
<?if (count($arElements) > 0):?>
	<div class="uni-indents-vertical indent-50"></div>
	<div class="title"><?=GetMessage('SERVICE_SIMILARSERVICES')?></div>
	<div class="uni-indents-vertical indent-30"></div>
	<div class="services-wrapper">
		<div class="buttons">
			<div class="wrapper">
				<button class="uni-slider-button-small uni-slider-button-left" onClick="return SimilarServices.scrollToLeft()"><div class="icon"></div></button>
				<button class="uni-slider-button-small uni-slider-button-right" onClick="return SimilarServices.scrollToRight()"><div class="icon"></div></button>
			</div>
		</div>
		<div class="services">
			<?foreach ($arElements as $arElement) {?>
				<?
					$picture = array();
					$picture['src'] = SITE_TEMPLATE_PATH."/images/noimg/no-img.png";
					
					if ($arElement['PREVIEW_PICTURE'])
					{
						$picture = CFile::ResizeImageGet($arElement['PREVIEW_PICTURE'], array('width' => 300, "height" => 300), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
					}
				?>
				<div class="service">
					<a class="wrapper hover_shadow"  href="<?=$arElement['DETAIL_PAGE_URL']?>">
						<div class="image">
							<div>
								<div class="uni-aligner-vertical"></div>
								<img src="<?=$picture['src']?>" />
							</div>
						</div>
						<div class="text">
							<div class="text-wrapper"><?=$arElement['NAME']?></div>
						</div>
					</a>
				</div>
			<?}?>
		</div>
	</div>
	<script type="text/javascript">
		var SimilarServices = new UniSlider({
			slider:'.services',
			slide:'.service',
			display: 4,
			sizes: [
				{size: 600, display: 2},
				{size: 400, display: 1}
			]
		});
	</script>
<?endif;?>