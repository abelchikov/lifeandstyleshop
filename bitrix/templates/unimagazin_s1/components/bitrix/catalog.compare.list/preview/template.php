<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<!--noindex-->
	<?if(count($arResult) > 0){?>
		<?global $compare_items;?>
		<span class="go_to_compare">
		<form action="<?=$arParams["COMPARE_URL"]?>" method="get">
			<input type="hidden" name="action" value="COMPARE" />
			<input type="hidden" name="IBLOCK_ID" value="<?=$arParams["IBLOCK_ID"]?>" />
			
			<?if( count($arResult) > 1 ){?>
				<button type="submit" name="web_form_submit" class="button4 compare_button"><i></i><span><?=GetMessage("CATALOG_COMPARE")?></span></button>
			<?}?>
			<a rel="nofollow" class="link" href="#">(<span><?if(count($arResult)==1){}?>&nbsp;<?=count($arResult).' '.declOfNum(count($arResult), array( GetMessage("ONE_ITEM"), GetMessage("TWO_ITEM"), GetMessage("MORE_ITEM") ))?></span> )</a>
			<?foreach($arResult as $arItem){
				$compare_items[] = $arItem["ID"];
			}?>
		</form>
		</span>
		<div class="compare_link">
			<?if( count($arResult) > 1 ){?>
				<a href="<?=SITE_DIR?>catalog/compare.php" class="button4 compare_button"><i></i><span><?=GetMessage("CATALOG_COMPARE")?></span></a>
			<?}?>
			<a rel="nofollow" class="link" href="#">(<span><?if(count($arResult)==1){}?>&nbsp;<?=count($arResult).' '.declOfNum(count($arResult), array( GetMessage("ONE_ITEM"), GetMessage("TWO_ITEM"), GetMessage("MORE_ITEM") ))?></span> )</a>	
		</div>
		
	<?}?>
	<script>
		$(document).ready(function() {
			$('.compare_popup').jqmAddTrigger('.compare a.link');
		})
	</script>
<!--/noindex-->