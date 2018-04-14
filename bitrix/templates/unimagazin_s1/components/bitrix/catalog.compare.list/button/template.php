<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!--noindex-->
	<?if(count($arResult) > 0){?>
		<?global $compare_items;?>		
		<div class="compare_link">
			<?if( count($arResult) > 1 ){?>
				<a href="<?=SITE_DIR?>catalog/compare.php" class="compare_button"><?=GetMessage("CATALOG_COMPARE")?></a>
			<?}?>
			<a rel="nofollow" class="link" href="<?=SITE_DIR?>catalog/compare.php">(<span><?if(count($arResult)==1){}?>&nbsp;<?=count($arResult).' '.declOfNum(count($arResult), array( GetMessage("ONE_ITEM"), GetMessage("TWO_ITEM"), GetMessage("MORE_ITEM") ))?></span> )</a>	
		</div>		
	<?}?>	
<!--/noindex-->