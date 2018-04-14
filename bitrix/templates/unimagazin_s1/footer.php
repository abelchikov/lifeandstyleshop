<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
						<?if(!$bIsFrontPage && $bShowMenuLeft):?>
							</div><!--right_col-->
						<?endif;?>
						<div class="clear"></div>
					</div> <!-- bx_content_section -->
				</div> <!-- worakarea_wrap_container workarea-->
			</div> <!-- workarea_wrap -->
			<div class="clear"></div>
		</div><!--wrap-->
		<div class="bg_footer">
			<div class="footer">
				<div class="bg_top">
					<div class="bg_subscribe">
						<?$APPLICATION->IncludeComponent("bitrix:subscribe.form", "main_page", Array(),false);?>
					</div>
					<div class="bg_phone">
						<div class="phone">
						<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
								"AREA_FILE_SHOW" => "file", 
								"PATH" => SITE_DIR."include/company_phone.php", 
							)
						);?>
						</div>
						<!--<div class="call_button">-->
						<!--	<span class="open_call" onclick="openCallForm('<?/*=SITE_DIR*/?>')"><?/*=GetMessage("CALL_TEXT")*/?></span>-->
						<!--</div>-->
					</div>
				</div>
				<div class="contacts left">
                    <div class="uni-indents-vertical indent-25"></div>
                    
                    <div class="uni-text-default">			
    					<?$APPLICATION->IncludeFile(SITE_DIR."include/descriptions.php", Array(), Array(
    						"MODE"      => "html",                                           
    						"NAME"      => ""                           
    					));?>
                    </div>
				</div>
				<div class="menu left">
                    <div class="uni-indents-vertical indent-25"></div>
					<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"bottom_menu", 
	array(
		"ROOT_MENU_TYPE" => "bottom",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "600000",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"CACHE_SELECTED_ITEMS" => "N",
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => "bottom2",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "bottom_menu"
	),
	false
);?>
					<div class="clear"></div>
				</div>
                <div class="phone-block right">
                    <div class="uni-indents-vertical indent-25"></div>
					<div class="social_buttons">
						<?
						$facebookLink = $APPLICATION->GetFileContent($_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/socnet_facebook.php");
						$twitterLink = $APPLICATION->GetFileContent($_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/socnet_twitter.php");								
						$vkLink = $APPLICATION->GetFileContent($_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/socnet_vk.php");
						$instLink = $APPLICATION->GetFileContent($_SERVER["DOCUMENT_ROOT"].SITE_DIR."include/socnet_inst.php");
						?>
						<ul>
							<?if (LANGUAGE_ID=="ru" && $vkLink):?>
								<li class="vk"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/socnet_vk.php"), false);?></li>
							<?endif?>
							<?if ($facebookLink):?>
								<li class="fb"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/socnet_facebook.php"), false);?></li>
							<?endif?>
							<?if ($instLink):?>
								<li class="inst"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/socnet_inst.php"), false);?></li>
							<?endif?>
							<?if ($twitterLink):?>
								<li class="tw"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/socnet_twitter.php"), false);?></li>
							<?endif?>						
						</ul>	
					</div>
					<div class="logo-block">
						<?$APPLICATION->IncludeComponent("bitrix:main.include","",Array(
								"AREA_FILE_SHOW" => "file", 
								"PATH" => SITE_DIR."include/company_logo.php", 
							)
						);?>
					</div>
                </div>
                <div class="clear"></div>
                <div class="uni-indents-vertical indent-25"></div>
				<div id="bx-composite-banner"></div>
			</div>
		</div>
	<?if ($options['SHOW_BUTTON_TOP']['ACTIVE_VALUE'] == 'Y'):?>
		<div class="button_up solid_button">
			<i></i>
		</div>
	<?endif;?>
	<script>
		$('.nbs-flexisel-nav-left').addClass('uni-slider-button-small').addClass('uni-slider-button-left').html('<div class="icon"></div>');
		$('.nbs-flexisel-nav-right').addClass('uni-slider-button-small').addClass('uni-slider-button-right').html('<div class="icon"></div>');
	</script>
</body>
</html>