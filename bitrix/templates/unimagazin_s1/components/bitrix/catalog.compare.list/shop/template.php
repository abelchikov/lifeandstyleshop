<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if( count($arResult) > 0 ){?>
	<form action="<?=$arParams["COMPARE_URL"]?>" method="get">
		<div class="compare_list">
			<ul>
				<?foreach( $arResult as $arItem ){
					$arElement = CIBlockElement::GetByID($arItem["ID"])->Fetch();?>
					<li class="compare_item_ws">
						<div class="image">
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
								<?if( !empty( $arElement["PREVIEW_PICTURE"] ) ){
									$img = CFile::ResizeImageGet($arElement["PREVIEW_PICTURE"], array('width'=>115, 'height'=>95), BX_RESIZE_IMAGE_PROPORTIONAL, true);?>
									<img src="<?=$img['src']?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
								<?}else{?>
									<img src="<?=SITE_TEMPLATE_PATH?>/img/noimage90.gif" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
								<?}?>
							</a>
						</div>
						<input type="hidden" name="ID[]" value="<?=$arItem["ID"]?>" />
						<a class="desc_name" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
						<!--noindex-->
							<a rel="nofollow" class="delete" href="<?=$arItem["DELETE_URL"]?>"></a>
						<!--/noindex-->
					</li>
				<?}?>
			</ul>
		</div>
		<?if( count( $arResult ) >= 2 ){?>
			<div class="button_row">
				<button class="button4 compare_button" type="submit" value="<?=GetMessage("CATALOG_COMPARE")?>"><i></i><span><?=GetMessage("CATALOG_COMPARE")?></span></button>
				<input type="hidden" name="action" value="COMPARE" />
				<input type="hidden" name="IBLOCK_ID" value="<?=$arParams["IBLOCK_ID"]?>" />
			</div>
		<?}?>
	</form>
<?}?>

<script>
	$(document).ready(function() {
		
		var abs_width = 115;
		
		$.elastislide.prototype._setCurrentValues = function(){
			// the total space occupied by one item
			this.itemW			= this.$items.outerWidth(true);
			
			// total width of the slider / <ul>

			// this will eventually change on window resize
			this.sliderW		= this.itemW * this.itemsCount;
			
			// the ul parent's (div.es-carousel) width is the "visible" width
			this.visibleWidth	= this.$esCarousel.width();
			
			var b_w = this.visibleWidth;
			var b_c = Math.floor(b_w / abs_width);
			var b_w_n = this.visibleWidth / b_c;
			b_w_n = b_w_n - 10;
			
			this._setDim(b_w_n);
			
			// how many items fit with the current width
			this.fitCount		= Math.floor( this.visibleWidth / this.itemW );
		}
		
		var b_w = $('.compare_list').width();
		var b_c = Math.floor(b_w / abs_width);
		var b_w_n = $('.compare_list').width() / b_c;
		
		$('.compare_list').elastislide({
			margin: 10,
			imageW: b_w_n,
			border: 0,
			min_imageW: abs_width
		});
		
		var width = $('.compare_popup').width();
		$('.compare_popup').css('margin-left', '-'+width/2+'px');
	})
</script>