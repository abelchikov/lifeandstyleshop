<?
$properties = $arResult['DISPLAY_PROPERTIES'];
unset($properties['CML2_ARTICLE']); // Удаляем артикул
$properties = array_slice($properties, 0, 6);
?>
<?if (!empty($properties)):?>
<div class="uni-indents-vertical indent-40"></div>
<div class="row">
    <div class="properties">
    	<?foreach ($properties as $property):?>
    		<?if (!is_array($arPropertyMinimal['VALUE'])):?>
                <div class="property"><?=$property['NAME']?> &mdash; <?=$property['DISPLAY_VALUE']?>;</div>
            <?else:?>
                <div class="property"><?=$property['NAME']?> &mdash; <?=implode(', ', $property['VALUE'])?>;</div>
            <?endif;?>
    	<?endforeach;?>
    	<?if (count($properties) > 0):?>
    		<a href="#properties" class="all-properties"><?=GetMessage('PRODUCT_PROPERTIES_ALL')?></a>
    		<script type="text/javascript">
    			$(document).ready(function(){
    				$(".properties .all-properties").click(function() {
    					var tabs = $('#tabs');
    					tabs.tabs("select", "#properties");
    				})
    			})
    		</script>
    	<?endif;?>
    </div>
</div>
<?endif;?>