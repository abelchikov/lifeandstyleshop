<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die() ?>
<? $this->setFrameMode(true) ?>
<? $frame = $this->createFrame()->begin() ?>
<?
	$showAlways = $arParams['PAGER_SHOW_ALWAYS'];

	$id = $arResult["NavNum"];
	$parameter = 'PAGEN_'.$id;
	$records = $arResult['NavRecordCount'];
	$pages = $arResult['NavPageCount'];
	$page = $arResult['NavPageNomer'];
	$pageStart = $arResult['nStartPage'];
	$pageEnd = $arResult['nEndPage'];
	$pageSize = $arResult['NavPageSize'];
	$pageSave = $arResult['bSavePage'];
	
	$path = $arResult["sUrlPath"];
	$query = $arResult["NavQueryString"];
	$url = !empty($query) ? $path.'?'.$query : $path;
	$urlBase = !empty($query) ? $path.'?'.$query.'&' : $path.'?';
?>
<? if ($showAlways || $pages > 1) { ?>
	<div class="paginator-default">
		<? if ($page > 1) { ?>
			<div class="paginator-default-button-left">
				<? if ($bSavePage) { ?>
					<a class="uni-slider-button uni-slider-button-left"
						href="<?= $urlBase.$parameter.'='.($page - 1) ?>"
					><div class="icon"></div></a>
				<? } else { ?>
					<? if ($page > 2) { ?>
						<a class="uni-slider-button uni-slider-button-left"
							href="<?= $urlBase.$parameter.'='.($page - 1) ?>"
						><div class="icon"></div></a>
					<? } else { ?>
						<a class="uni-slider-button uni-slider-button-left"
							href="<?= $url ?>"
						><div class="icon"></div></a>
					<? } ?>
				<? } ?>
			</div>
		<? } ?>
		<div class="paginator-default-buttons">
			<? while ($pageStart <= $pageEnd) { ?>
				<div class="paginator-default-button">
					<? if ($page == $pageStart) { ?>
						<div class="paginator-default-button-wrap uni-button solid_button ui-state-current">
							<?= $pageStart ?>
						</div>
					<? } else if ($pageStart == 1 && $pageSave == false) { ?>
						<a class="paginator-default-button-wrap uni-button ui-state-current" 
							href="<?= $url ?>"
						><?= $pageStart ?></a>
					<? } else { ?>
						<a class="paginator-default-button-wrap uni-button ui-state-current" 
							href="<?= $urlBase.$parameter.'='.$pageStart ?>"
						><?= $pageStart ?></a>
					<? } ?>
				</div>
				<? $pageStart++ ?>
			<? } ?>
		</div>
		<? if ($page < $pages) { ?>
			<div class="paginator-default-button-right">
				<a class="uni-slider-button uni-slider-button-right"
					href="<?= $urlBase.$parameter.'='.($page + 1) ?>"
				><div class="icon"></div></a>
			</div>
		<? } ?>
	</div>
<? } ?>