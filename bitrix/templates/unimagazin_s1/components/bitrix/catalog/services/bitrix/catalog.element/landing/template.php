<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?$this->setFrameMode(true)?>
<?
    $arData = $arResult['DATA'];
    $sCurrentElement = null;
?>
<div class="service landing">
    <div class="service-header">
		<?
            $arMenu = array();
            
            if ($arData['GALLERY']['SHOW']) $arMenu[] = array(
                "NAME" => $arParams['ELEMENT_CAPTION_GALERY'],
                "LINK" => "#gallery"
            );
            
			if ($arData['VIDEO']['SHOW']) $arMenu[] = array(
                "NAME" => $arParams['ELEMENT_CAPTION_VIDEO'],
                "LINK" => "#video"
            );
			
            if ($arData['PROJECTS']['SHOW']) $arMenu[] = array(
                "NAME" => $arParams['ELEMENT_CAPTION_PROJECTS'],
                "LINK" => "#projects"
            );
            
            if ($arData['REVIEWS']['SHOW']) $arMenu[] = array(
                "NAME" => $arParams['ELEMENT_CAPTION_REVIEWS'],
                "LINK" => "#reviews"
            );
            
            if ($arData['HOW_WE_WORK']['SHOW']) $arMenu[] = array(
                "NAME" => $arParams['ELEMENT_CAPTION_HOW_WE_WORK'],
                "LINK" => "#how-we-work"
            );
            
            if ($arData['OUR_ADVANTAGES']['SHOW']) $arMenu[] = array(
                "NAME" => $arParams['ELEMENT_CAPTION_OUR_ADVANTAGES'],
                "LINK" => "#our-advantages"
            );
            
            if ($arData['OUR_CLIENTS']['SHOW']) $arMenu[] = array(
                "NAME" => $arParams['ELEMENT_CAPTION_OUR_CLIENTS'],
                "LINK" => "#our-clients"
            );
            
            if ($arData['CONTACTS']['SHOW']) $arMenu[] = array(
                "NAME" => $arParams['ELEMENT_CAPTION_CONTACTS'],
                "LINK" => "#contacts"
            );
            
			if (count($arMenu) <= 3)  
				$arMenu = array();
			
            $fMenuElementSize = 100;
            
            if (!empty($arMenu))
                $fMenuElementSize = 100 / count($arMenu);
        ?>
        <?if (!empty($arMenu)):?>
            <div class="service-header-menu">
                <div class="service-header-menu-wrapper">
                    <div class="service-header-menu-wrapper-wrapper">
                        <div class="service-header-menu-wrapper-wrapper-wrapper">
                            <?foreach ($arMenu as $arMenuElement):?>
                                <a class="service-header-menu-item hover_link" href="<?=$arMenuElement['LINK']?>" style="width: <?=$fMenuElementSize?>%;"><?=$arMenuElement['NAME']?></a>
                            <?endforeach;?>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        var $oMenu = $('.service.landing .service-header .service-header-menu');
                        var $oMenuElements = $oMenu.find('.service-header-menu-item');
                        var $fMenuTop = $oMenu.offset().top;
                        
                        $(window).scroll(function(){
                            var $fScrollTop = $(this).scrollTop();
                            var $oMinScroll = {
                                'value': $(document).height(),
                                'selector': ''
                            }
                            
                            if ($fScrollTop > $fMenuTop) {
                                $oMenu.addClass('fixed');
                            } else {
                                $oMenu.removeClass('fixed');
                            }
                            
                            $oMenuElements.each(function(){
                                var $fElementTop = $($(this).attr('href')).offset().top;
                                                            
                                if ($fElementTop < ($fScrollTop + 100))
                                {
                                    
                                    
                                    $oMinScroll.value = $fElementTop;
                                    $oMinScroll.selector = $(this).attr('href');
                                }
                            });
                            
                            $oMenuElements.removeClass('ui-state-active');
                            
                            if ($oMinScroll.selector.length > 0)
                                $oMenuElements.parent().find('[href="' + $oMinScroll.selector + '"]').addClass('ui-state-active');
                        });
                    })
                </script>
            </div>
            <div class="service-header-menusize"></div>
        <?endif;?>
        <table width="100%" border="0" cellspadding="0" cellsspacing="0" style="width: 100%;">
            <tr>
                <td style="width: 100%; vertical-align: top; text-align: left; font-size: 0;" class="service-header-image-wrapper">
                   <?if ($arData['IMAGE']['SHOW']):?>
						<div class="service-header-image">
								<div class="uni-image" style="height: 100%;">
									<div class="uni-aligner-vertical"></div>
									<img src="<?=$arData['IMAGE']['PATH']?>">
								</div>
						</div>
					<?else:?>
						<?if ($arData['DETAIL_TEXT']['SHOW']):?>
							<div class="detail_description_no_img">
								<div class="service-header-description">
									<div class="service-header-description-caption">
										<?=$arParams['ELEMENT_CAPTION_DESCRIPTION']?>
									</div>
									<div class="uni-indents-vertical indent-10"></div>
									<div class="service-header-description-text">
										<?=$arData['DETAIL_TEXT']['VALUE']?>
									</div>
								</div>
							</div>
						<?endif;?>
					<?endif;?>
					<div class="service-header-information <?=!$arData['IMAGE']['SHOW'] ? 'service-header-information-no-img':''?>">
                        <?if ($arData['PRICE']['SHOW']):?>
                            <div class="service-header-information-price">
                                <div class="service-header-information-price-caption">
                                    <?=GetMessage('SERVICE_HEADER_PRICE_CAPTION')?>:
                                </div>
                                <div class="uni-indents-vertical indent-10"></div>
                                <div class="service-header-information-price-value">
                                    <?=$arData['PRICE']['FORMATTED']?>
                                </div>
                            </div>
                            
                        <?endif;?>
                        <div class="uni-indents-vertical indent-25"></div>
                        <div class="service-header-information-order">
                            <a class="uni-button solid_button" onclick="openOrderServicePopup('<?=SITE_DIR?>', '<?=$arResult['NAME']?>')"><?=GetMessage('SERVICE_HEADER_ORDER_BUTTON')?></a>
                        </div>
                        <?if ($arData['PREVIEW_TEXT']['SHOW']):?>
                            <div class="uni-indents-vertical indent-30"></div>
                            <div class="service-header-information-text">
                                <?=$arData['PREVIEW_TEXT']['VALUE']?>
                            </div>
                        <?endif;?>
                    </div>
                </td>
				<div class="service-header-information-adaptiv">
					<?if ($arData['PRICE']['SHOW']):?>
						<div class="service-header-information-price">
							<div class="service-header-information-price-caption">
								<?=GetMessage('SERVICE_HEADER_PRICE_CAPTION')?>:
							</div>
							<div class="uni-indents-vertical indent-10"></div>
							<div class="service-header-information-price-value">
								<?=$arData['PRICE']['FORMATTED']?>
							</div>
						</div>
						
					<?endif;?>
					<div class="uni-indents-vertical indent-20"></div>
					<div class="service-header-information-order">
						<a class="uni-button solid_button" onclick="openOrderServicePopup('<?=SITE_DIR?>', '<?=$arResult['NAME']?>')"><?=GetMessage('SERVICE_HEADER_ORDER_BUTTON')?></a>
					</div>
					<?if ($arData['PREVIEW_TEXT']['SHOW']):?>
						<div class="uni-indents-vertical indent-30"></div>
						<div class="service-header-information-text">
							<?=$arData['PREVIEW_TEXT']['VALUE']?>
						</div>
					<?endif;?>
				</div>
               
            </tr>
        </table>
		<?if ($arData['GALLERY']['SHOW']):?>
			<div class="uni-indents-vertical indent-10"></div>
			<div class="service-section gallery" id="gallery">
				<?$sUniqueID = 'picturelist_slider_1'.spl_object_hash($this);?>
				<div class="picturelist-slider-1" id="<?=$sUniqueID?>">
					<div class="picturelist-slider-1-wrapper">
						<?foreach ($arData['GALLERY']['VALUE'] as $arElement):?>
							<?
								$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_EDIT"));
								$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
							?>
							<div class="picturelist-slider-1-element uni-25">
								<div class="picturelist-slider-1-element-wrapper" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
									<div class="picturelist-slider-1-image" style="padding-top: <?=$arParams['PICTURE_BLOCK_HEIGHT']?>;">
										<?$gall_picture = CFile::GetPath($arElement);?>
										<a class="picturelist-slider-1-image-wrapper uni-image fancy" rel="gallery" href="<?=$gall_picture?>">
											<img src="<?=$gall_picture?>"/>
										</a>
									</div>
								</div>
							</div>
						<?endforeach;?>
					
					</div>
					
					<!--<div class="picturelist-slider-1-points">
						<div class="picturelist-slider-1-points-wrapper">
						</div>
					</div>-->
					<div class="shadow-picture-left shadow-picture" onclick="return $<?=$sUniqueID?>.SlideRight();"></div>
					<div class="shadow-picture-right shadow-picture" onclick="return $<?=$sUniqueID?>.SlideLeft();"></div>
					<script>
						$shadowHeight = $('.gallery .picturelist-slider-1-element:first-child .picturelist-slider-1-element-wrapper').outerHeight(false);
						$('.gallery .shadow-picture').css('height', $shadowHeight);
						
						$(window).resize(function() {
							$shadowHeight = $('.gallery .picturelist-slider-1-element:first-child .picturelist-slider-1-element-wrapper').outerHeight(false);
							$('.gallery .shadow-picture').css('height', $shadowHeight);
						});
					</script>
					<div class="picturelist-slider-1-wrapper-arrow-left">
							<div class="picturelist-slider-1-arrow-left" onclick="return $<?=$sUniqueID?>.SlideRight();">
								
							</div>
							<div class="uni-aligner-vertical"></div>
						</div>
						<div class="picturelist-slider-1-wrapper-arrow-right">
							<div class="uni-aligner-vertical"></div>
							<div class="picturelist-slider-1-arrow-right" onclick="return $<?=$sUniqueID?>.SlideLeft();">
								
							</div>
						</div>
					<script type="text/javascript">
						$galleryHeight = $('.service.landing .gallery .picturelist-slider-1-wrapper').outerHeight(false);
						$('.gallery .picturelist-slider-1 .picturelist-slider-1-wrapper-arrow-left, .gallery .picturelist-slider-1 .picturelist-slider-1-wrapper-arrow-right').css('top', $galleryHeight/2-11+'px');
						
						$(window).resize(function() {
							$galleryHeight = $('.service.landing .gallery .picturelist-slider-1-wrapper').outerHeight(false);
							$('.gallery .picturelist-slider-1 .picturelist-slider-1-wrapper-arrow-left, .gallery .picturelist-slider-1 .picturelist-slider-1-wrapper-arrow-right').css('top', $galleryHeight/2-11+'px');
						});
						var $<?=$sUniqueID?> = new UNISlider({
								'OFFSET': 4,
								'SLIDER': '#<?=$sUniqueID?> .picturelist-slider-1-wrapper',
								'ELEMENT': '#<?=$sUniqueID?> .picturelist-slider-1-wrapper .picturelist-slider-1-element',
								'ANIMATE': true,
								'ANIMATE_SPEED': 400,
								'EVENTS': {
									'onAdaptabilityChange': function ($oSlider) {
										$oSlider.Settings.OFFSET = Math.round($oSlider.GetSliderWidth() / $oSlider.GetElementWidth());
										
										var $oListenerContainer = $('#<?=$sUniqueID?> .picturelist-slider-1-points .picturelist-slider-1-points-wrapper');
										var $iDisplayedItems = $oSlider.Settings.OFFSET;
										var $iCountItems = $oSlider.GetElementsCount();
										var $iListenerButtons = Math.floor($iCountItems / $iDisplayedItems);
										
										if ($iDisplayedItems * 2 <= $iCountItems) {
											$('#<?=$sUniqueID?> .picturelist-slider-1-points').show();
										} else {
											$('#<?=$sUniqueID?> .picturelist-slider-1-points').hide();
										}
										
										$oListenerContainer.empty();
										if ($iListenerButtons > 0) {
											var $iCurrentPage = Math.floor($oSlider.GetCurrentSlide() / $oSlider.Settings.OFFSET);
											
											for (var $i = 0; $i < $iListenerButtons; $i++) {
												var $iNumber = $i * $iDisplayedItems;
												$('<div class="picturelist-slider-1-point" slide="' + $iNumber + '"></div>').click(function() {
													$oSlider.SlideTo($(this).attr('slide'));
												}).appendTo($oListenerContainer)
											}
											
											$oListenerContainer.children()
												.removeClass('picturelist-slider-1-point-selected')
												.eq($iCurrentPage)
												.addClass('picturelist-slider-1-point-selected');
										}
									},
									'onAfterSlide': function ($oSlider, $oSettings) {
											var $oListenerContainer = $('#<?=$sUniqueID?> .picturelist-slider-1-points .picturelist-slider-1-points-wrapper');
											var $iCurrentPage = Math.floor($oSettings.SLIDE.NEXT / $oSlider.Settings.OFFSET);
											
											$oListenerContainer.children()
												.removeClass('picturelist-slider-1-point-selected')
												.eq($iCurrentPage)
												.addClass('picturelist-slider-1-point-selected');
									}            
								} 
							});
					</script>
				</div>
			</div>
		<?endif;?>
		<?
			$sCurrentElement = $arData['GALLERY']['ELEMENT'];
			include('parts/element.php');
			$sCurrentElement = null;
		?>
		
        <?if ($arData['DETAIL_TEXT']['SHOW']):?>
			<?if (!$arData['IMAGE']['SHOW']):?>
			<div class="detail_description_adaptiv">
			<?endif;?>
            <div class="uni-indents-vertical indent-45"></div>
			<div class="uni-100">
				<div class="detail_description">
					<div class="service-header-description">
						<div class="service-header-description-caption">
							<?=$arParams['ELEMENT_CAPTION_DESCRIPTION']?>
						</div>
						<div class="uni-indents-vertical indent-10"></div>
						<div class="service-header-description-text">
							<?=$arData['DETAIL_TEXT']['VALUE']?>
						</div>
					</div>
				</div>
				
			</div>
			<?if (!$arData['IMAGE']['SHOW']):?>
			</div>
			<?endif;?>
        <?endif;?>		
    </div>
	<?if ($arData['CHARACTERISTICS']['SHOW']):?>
        <div class="uni-indents-vertical indent-40"></div>
        <div class="service-caption" id="characteristics"><?=$arParams['ELEMENT_CAPTION_CHARACTERISTICS']?></div>
        <div class="uni-indents-vertical indent-20"></div>
        <div class="service-section">
            <?$APPLICATION->IncludeComponent("intec:custom.iblock.element.list", "characteristics.landing.1", Array(
            	   "IBLOCK_ELEMENTS_ID" => $arData['CHARACTERISTICS']['VALUE'],
                   "USE_DETAIL_PICTURE" => "N",
                   "USE_PREVIEW_PICTURE" => "N",
                   "MAIN_ELEMENTS_COUNT" => "2",
				   "NO_PICTURE_PATH" => SITE_TEMPLATE_PATH."/images/noimg/no-img.png",
            	),
            	false
            );?>
        </div>
    <?endif;?>
    <?
        $sCurrentElement = $arData['CHARACTERISTICS']['ELEMENT'];
        include('parts/element.php');
        $sCurrentElement = null;
    ?>
    <?if ($arData['SPECIALIST']['SHOW']):?>
        <div class="uni-indents-vertical indent-30"></div>
		<div class="block_specialist">
			<div class="block_specialist_wrapper">
				<div class="service-caption" id="specialist"><?=$arParams['ELEMENT_CAPTION_SPECIALIST']?></div>
				<div class="uni-indents-vertical indent-10"></div>
				<div class="service-section">
					<?$APPLICATION->IncludeComponent("intec:custom.iblock.element", "specialist.landing.1", Array(
						   "IBLOCK_ELEMENT_ID" => $arData['SPECIALIST']['VALUE'],
						   "PICTURE_WIDTH" => "255",
						   "PICTURE_HEIGHT" => "213",
						   "USE_DETAIL_PICTURE" => "N",
						   "DISPLAY_NOTIFICATION" => "Y",
						   "DISPLAY_NOTIFICATION_BUTTON" => "Y",
						   "NOTIFICATION_BUTTON_ID" => "question",
						   "NO_PICTURE_PATH" => SITE_TEMPLATE_PATH."/images/noimg/no-img.png",
						),
						false
					);?>
					<script type="text/javascript">
						$('#question').click(function () {
							openFaqPopup('<?=SITE_DIR?>');
						});
					</script>
				</div>
			</div>
		</div>
		<div class="block_specialist_size"></div>
		<script>
		$formOrderHeight = $('.service.landing .block_specialist').outerHeight(false);
		$('.service.landing .block_specialist_size').css('height', $formOrderHeight);
		
		$(window).resize(function() {
			$formOrderHeight = $('.service.landing .block_specialist').outerHeight(false);
			$('.service.landing .block_specialist_size').css('height', $formOrderHeight);
		});
	</script>
    <?endif;?>
    <?
        $sCurrentElement = $arData['SPECIALIST']['ELEMENT'];
        include('parts/element.php');
        $sCurrentElement = null;
    ?>
	<?if ($arData['VIDEO']['SHOW']):?>
        <div class="uni-indents-vertical indent-30"></div>
        <div class="service-caption" id="video"><?=$arParams['ELEMENT_CAPTION_VIDEO']?></div>
        <div class="service-section">
            <?$APPLICATION->IncludeComponent("intec:custom.iblock.element.list", "video.slider.1", Array(
            	   "IBLOCK_ELEMENTS_ID" => $arData['VIDEO']['VALUE'],
                   "USE_DETAIL_PICTURE" => "N",
                   "USE_PREVIEW_PICTURE" => "N",
                   "SLIDER_ID" => "services-video-slider-".$arResult['ID'],
				   "NO_PICTURE_PATH" => SITE_TEMPLATE_PATH."/images/noimg/no-img.png",
            	),
            	false
            );?>
        </div>
    <?endif;?>
    <?if ($arData['DOCUMENTS']['SHOW']):?>
        <div class="uni-indents-vertical indent-20"></div>
        <div class="service-caption" id="documents"><?=$arParams['ELEMENT_CAPTION_DOCUMENTS']?></div>
        <div class="uni-indents-vertical indent-25"></div>
        <div class="service-section">
            <?$APPLICATION->IncludeComponent("intec:custom.element", "documents.landing.1", Array(
            	   "FILES" => $arData['DOCUMENTS']['VALUE']
            	),
            	false
            );?>
        </div>
    <?endif;?>
    <?
        $sCurrentElement = $arData['DOCUMENTS']['ELEMENT'];
        include('parts/element.php');
        $sCurrentElement = null;
    ?>
    <?if ($arData['PROJECTS']['SHOW']):?>
        <div class="uni-indents-vertical indent-30"></div>
        <div class="service-caption" id="projects"><?=$arParams['ELEMENT_CAPTION_PROJECTS']?></div>
        <div class="uni-indents-vertical indent-20"></div>
        <div class="service-section">
            <?$APPLICATION->IncludeComponent("intec:custom.iblock.element.list", "tiles.landing.2", Array(
	"IBLOCK_ELEMENTS_ID" => $arData["PROJECTS"]["VALUE"],
		"USE_DETAIL_PICTURE" => "N",	// Использовать детальное изображение
		"USE_PREVIEW_PICTURE" => "Y",	// Использовать изображение анонса
		"PICTURE_WIDTH" => "450",	// Ширина изображения
		"PICTURE_HEIGHT" => "450",	// Высота изображения
		"USE_LINK_TO_ELEMENTS" => "Y",	// Ссылаться на элементы
		"PICTURE_BLOCK_HEIGHT" => "71%",	// Высота блока с изображением
		"LINK_TO_ELEMENTS" => $arParams["PROJECTS_SECTION_URL"],	// Ссылка на раздел с элементами
		"NO_PICTURE_PATH" => SITE_TEMPLATE_PATH."/images/noimg/no-img.png",	// Путь до изображения "Нет изображения"
	),
	false
);?>
        </div>
    <?endif;?>
    <?
        $sCurrentElement = $arData['PROJECTS']['ELEMENT'];
        include('parts/element.php');
        $sCurrentElement = null;
    ?>
	<?if ($arData['HOW_WE_WORK']['SHOW']):?>
        <div class="uni-indents-vertical indent-30"></div>
        <div class="service-caption" id="how-we-work"><?=$arParams['ELEMENT_CAPTION_HOW_WE_WORK']?></div>
        <div class="uni-indents-vertical indent-20"></div>
        <div class="service-section">
            <?$APPLICATION->IncludeComponent("intec:custom.iblock.element.list", "tizers.landing.1", Array(
            	   "IBLOCK_ELEMENTS_ID" => $arData['HOW_WE_WORK']['VALUE'],
                   "USE_DETAIL_PICTURE" => "N",
                   "USE_PREVIEW_PICTURE" => "Y",
                   "PICTURE_WIDTH" => "134",
                   "PICTURE_HEIGHT" => "134",
				   "NO_PICTURE_PATH" => SITE_TEMPLATE_PATH."/images/noimg/no-img.png",
            	),
            	false
            );?>
        </div>
    <?endif;?>
	 <?
        $sCurrentElement = $arData['HOW_WE_WORK']['ELEMENT'];
        include('parts/element.php');
        $sCurrentElement = null;
    ?>
    <?if ($arData['REVIEWS']['SHOW']):?>
        <div class="uni-indents-vertical indent-30"></div>
        <div class="service-caption" id="reviews"><?=$arParams['ELEMENT_CAPTION_REVIEWS']?></div>
        <div class="uni-indents-vertical indent-20"></div>
        <div class="service-section">
            <?$APPLICATION->IncludeComponent("intec:custom.iblock.element.list", "reviews.landing.1", Array(
            	   "IBLOCK_ELEMENTS_ID" => $arData['REVIEWS']['VALUE'],
                   "USE_DETAIL_PICTURE" => "N",
                   "USE_PREVIEW_PICTURE" => "Y",
                   "PICTURE_WIDTH" => "300",
                   "PICTURE_HEIGHT" => "300",
                   "MAIN_ELEMENTS_COUNT" => "2",
                   "USE_LINK_TO_ELEMENTS" => "Y",
                   "LINK_TO_ELEMENTS" => $arParams['REVIEWS_SECTION_URL'],
				   "NO_PICTURE_PATH" => SITE_TEMPLATE_PATH."/images/noimg/no-img.png",
            	),
            	false
            );?>
        </div>
    <?endif;?>
    <?
        $sCurrentElement = $arData['REVIEWS']['ELEMENT'];
        include('parts/element.php');
        $sCurrentElement = null;
    ?>
    <?if ($arData['SERVICES']['SHOW']):?>
			<div class="uni-indents-vertical indent-40"></div>
			<div class="service-caption" id="services"><?=$arParams['ELEMENT_CAPTION_SERVICES']?></div>
			<div class="uni-indents-vertical indent-20"></div>
			<div class="service-section">
				<?$APPLICATION->IncludeComponent("intec:custom.iblock.element.list", "tiles.landing.2", Array(
					   "IBLOCK_ELEMENTS_ID" => $arData['SERVICES']['VALUE'],
					   "USE_DETAIL_PICTURE" => "N",
					   "USE_PREVIEW_PICTURE" => "Y",
					   "PICTURE_WIDTH" => "450",
					   "PICTURE_HEIGHT" => "450",
					   "PICTURE_BLOCK_HEIGHT" => "70%",
					   "USE_LINK_TO_ELEMENTS" => "Y",
					   "LINK_TO_ELEMENTS" => "",
					   "NO_PICTURE_PATH" => SITE_TEMPLATE_PATH."/images/noimg/no-img.png",
					),
					false
				);?>
			</div>
			<div class="uni-indents-vertical indent-40"></div>
    <?endif;?>
    <?
        $sCurrentElement = $arData['SERVICES']['ELEMENT'];
        include('parts/element.php');
        $sCurrentElement = null;
    ?>
	<?/*$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"request",
	Array(
		"AJAX_MODE" => "Y",
		"SEF_MODE" => "N",
		"WEB_FORM_ID" => "5",
		"START_PAGE" => "new",
		"SHOW_LIST_PAGE" => "N",
		"SHOW_EDIT_PAGE" => "N",
		"SHOW_VIEW_PAGE" => "N",
		"SUCCESS_URL" => "",
		"SHOW_ANSWER_VALUE" => "N",
		"SHOW_ADDITIONAL" => "N",
		"SHOW_STATUS" => "Y",
		"EDIT_ADDITIONAL" => "N",
		"EDIT_STATUS" => "N",
		"NOT_SHOW_FILTER" => array(),
		"NOT_SHOW_TABLE" => array(),
		"CHAIN_ITEM_TEXT" => "",
		"CHAIN_ITEM_LINK" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"USE_EXTENDED_ERRORS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"AJAX_MODE" => "Y",  // режим AJAX
		"AJAX_OPTION_SHADOW" => "N", // затемнять область
		"AJAX_OPTION_JUMP" => "Y", // скроллить страницу до компонента
		"AJAX_OPTION_STYLE" => "Y", // подключать стили
	)
);*/?>
    <?if ($arData['OUR_ADVANTAGES']['SHOW']):?>
        <div class="our_advantages">
			<div class="our_advantages_wrapper">
				<div class="uni-indents-vertical indent-30"></div>
				<div class="service-caption" id="our-advantages"><?=$arParams['ELEMENT_CAPTION_OUR_ADVANTAGES']?></div>
				<div class="uni-indents-vertical indent-20"></div>
				<div class="service-section">
					<?$APPLICATION->IncludeComponent("intec:custom.iblock.element.list", "tizers.landing.2", Array(
						   "IBLOCK_ELEMENTS_ID" => $arData['OUR_ADVANTAGES']['VALUE'],
						   "USE_DETAIL_PICTURE" => "N",
						   "USE_PREVIEW_PICTURE" => "Y",
						   "PICTURE_WIDTH" => "50",
						   "PICTURE_HEIGHT" => "50",
						   "NO_PICTURE_PATH" => SITE_TEMPLATE_PATH."/images/noimg/no-img.png",
						),
						false
					);?>
				</div>
				<div class="uni-indents-vertical indent-45"></div>
			</div>
		</div>
		<div class="our_advantages_size"></div>
		<script>
			$ourAdvantagesHeight = $('.service.landing .our_advantages').outerHeight(false);
			$('.service.landing .our_advantages_size').css('height', $ourAdvantagesHeight);
			
			$(window).resize(function() {
				$ourAdvantagesHeight = $('.service.landing .our_advantages').outerHeight(false);
				$('.service.landing .our_advantages_size').css('height', $ourAdvantagesHeight);
			});
		</script>
    <?endif;?>
    <?if ($arData['OUR_CLIENTS']['SHOW']):?>
        <div class="uni-indents-vertical indent-30"></div>
        <div class="service-caption" id="our-clients"><?=$arParams['ELEMENT_CAPTION_OUR_CLIENTS']?></div>
        <div class="uni-indents-vertical indent-20"></div>
        <div class="service-section clients">
				<?$sUniqueID = 'picturelist_slider_1_clients'.spl_object_hash($this);?>
				<div class="picturelist-slider-1" id="<?=$sUniqueID?>">
					<div class="picturelist-slider-1-wrapper">
						<?foreach ($arData['OUR_CLIENTS']['VALUE'] as $arElement):?>
							<?
								$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_EDIT"));
								$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arElement["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
							?>
							<div class="picturelist-slider-1-element uni-25">
								<div class="picturelist-slider-1-element-wrapper" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
									<div class="picturelist-slider-1-image" style="padding-top: <?=$arParams['PICTURE_BLOCK_HEIGHT']?>;">
										<div class="picturelist-slider-1-image-wrapper uni-image">
											<?$gall_picture = CFile::GetPath($arElement);?>
											<div class="uni-aligner-vertical"></div>
											<img src="<?=$gall_picture?>" />
										</div>
									</div>
								</div>
							</div>
						<?endforeach;?>
					</div>
					<div class="picturelist-slider-1-points">
						<div class="picturelist-slider-1-points-wrapper">
						</div>
					</div>
					<script type="text/javascript">
						$galleryHeight = $('.service.landing .clients .picturelist-slider-1-wrapper').outerHeight(false);
						$('.clients .picturelist-slider-1 .picturelist-slider-1-wrapper-arrow-left, .clients .picturelist-slider-1 .picturelist-slider-1-wrapper-arrow-right').css('top', $galleryHeight/2-11+'px');
						
						$(window).resize(function() {
							$galleryHeight = $('.service.landing .clients .picturelist-slider-1-wrapper').outerHeight(false);
							$('.clients .picturelist-slider-1 .picturelist-slider-1-wrapper-arrow-left, .clients .picturelist-slider-1 .picturelist-slider-1-wrapper-arrow-right').css('top', $galleryHeight/2-11+'px');
						});
						var $<?=$sUniqueID?> = new UNISlider({
								'OFFSET': 4,
								'SLIDER': '#<?=$sUniqueID?> .picturelist-slider-1-wrapper',
								'ELEMENT': '#<?=$sUniqueID?> .picturelist-slider-1-wrapper .picturelist-slider-1-element',
								'ANIMATE': true,
								'ANIMATE_SPEED': 400,
								'EVENTS': {
									'onAdaptabilityChange': function ($oSlider) {
										$oSlider.Settings.OFFSET = Math.round($oSlider.GetSliderWidth() / $oSlider.GetElementWidth());
										
										var $oListenerContainer = $('#<?=$sUniqueID?> .picturelist-slider-1-points .picturelist-slider-1-points-wrapper');
										var $iDisplayedItems = $oSlider.Settings.OFFSET;
										var $iCountItems = $oSlider.GetElementsCount();
										var $iListenerButtons = Math.floor($iCountItems / $iDisplayedItems);
										
										if ($iDisplayedItems * 2 <= $iCountItems) {
											$('#<?=$sUniqueID?> .picturelist-slider-1-points').show();
										} else {
											$('#<?=$sUniqueID?> .picturelist-slider-1-points').hide();
										}
										
										$oListenerContainer.empty();
										if ($iListenerButtons > 0) {
											var $iCurrentPage = Math.floor($oSlider.GetCurrentSlide() / $oSlider.Settings.OFFSET);
											
											for (var $i = 0; $i < $iListenerButtons; $i++) {
												var $iNumber = $i * $iDisplayedItems;
												$('<div class="picturelist-slider-1-point" slide="' + $iNumber + '"></div>').click(function() {
													$oSlider.SlideTo($(this).attr('slide'));
												}).appendTo($oListenerContainer)
											}
											
											$oListenerContainer.children()
												.removeClass('picturelist-slider-1-point-selected')
												.eq($iCurrentPage)
												.addClass('picturelist-slider-1-point-selected');
										}
									},
									'onAfterSlide': function ($oSlider, $oSettings) {
											var $oListenerContainer = $('#<?=$sUniqueID?> .picturelist-slider-1-points .picturelist-slider-1-points-wrapper');
											var $iCurrentPage = Math.floor($oSettings.SLIDE.NEXT / $oSlider.Settings.OFFSET);
											
											$oListenerContainer.children()
												.removeClass('picturelist-slider-1-point-selected')
												.eq($iCurrentPage)
												.addClass('picturelist-slider-1-point-selected');
									}            
								} 
							});
					</script>
				</div>
			</div>
    <?endif;?>
    <?if ($arData['CONTACTS']['SHOW']):?>
        <div class="uni-indents-vertical indent-30"></div>
        <div class="service-caption" id="contacts"><?=$arParams['ELEMENT_CAPTION_CONTACTS']?></div>
        <div class="uni-indents-vertical indent-20"></div>
        <div class="service-section">
            <?$APPLICATION->IncludeComponent("intec:custom.iblock.element.list", "contacts.landing.2", Array(
            	   "IBLOCK_ELEMENTS_ID" => $arData['CONTACTS']['VALUE'],
                   "USE_DETAIL_PICTURE" => "N",
                   "USE_PREVIEW_PICTURE" => "N",
                   "PICTURE_WIDTH" => "220",
                   "PICTURE_HEIGHT" => "220",
				   "NO_PICTURE_PATH" => SITE_TEMPLATE_PATH."/images/noimg/no-img.png",
            	),
            	false
            );?>
        </div>
    <?endif;?>
    <?
        $sCurrentElement = $arData['CONTACTS']['ELEMENT'];
        include('parts/element.php');
        $sCurrentElement = null;
    ?>
    <script type="text/javascript">
        $('.orderService').click(function () {
            openOrderServicePopup('<?=SITE_DIR?>', '<?=$arResult['NAME']?>');
        });
    </script>
</div>