<script type="text/javascript">
	<?if ($options['CATALOG_SKU_VIEW']['ACTIVE_VALUE'] == 'DYNAMIC' && !empty($arResult['OFFERS'])):?>
		var product = new CapitalProduct();
	<?endif;?>
	function CapitalProduct() 
	{
		this.count = new CapitalProductCount();
		this.structure = {};
		this.offerIndex = 0;
		this.offer = null;
		this.dynamicProperties = {};
		
		this.selectors = {};
		this.selectors.offer = {};
		
		this.setOfferByID = function(id) {
			for (var i = 0; i < this.structure['OFFERS'].length; i++)
			{
				if (this.structure['OFFERS'][i]['ID'] == parseInt(id)) {
					this.offer = this.structure['OFFERS'][i];
					this.offerIndex = i;
                    
                    if (this.offer['CAN_BUY_ZERO'] == 'Y' || this.offer['CHECK_QUANTITY'] == 'N') {
                        this.count.unlimited = true;
                    } else {
                        this.count.unlimited = false;
                    }
                    
					break;
				}
			}
			
			if (this.offer != null)
			{
				for (var key in this.offer['TREE'])
				{
					this.setDynamicProperty(key, this.offer['TREE'][key]);
				}
			}
		}
		
		this.setOfferFirst = function() {
			if (this.structure['OFFERS'].length > 0)
			{
				this.setOfferByID(this.structure['OFFERS'][0]['ID']);
				this.updateControls();
			}
		}
		
		this.selectWithProperty = function(key, value) {
			this.dynamicProperties[key] = value;
			
			var properties = {};
			
			for (var dynamicKey in this.dynamicProperties)
			{
				properties[dynamicKey] = this.dynamicProperties[dynamicKey];
				
				if (dynamicKey == key)
				{
					break;
				}
			}
			
			for (var i = 0; i < this.structure['OFFERS'].length; i++)
			{
				var compared = true;
				
				for (var compareKey in properties)
				{
					if (this.structure['OFFERS'][i]['TREE'][compareKey] != properties[compareKey])
					{
						compared = false;
						break;
					}
				}
			
				if (compared)
				{
					this.setOfferByID(this.structure['OFFERS'][i]['ID']);
					break;
				}
			}
			
			this.updateControls();
		}
		
		this.getOfferPropertiesArray = function () {
			
			var array = [];
			
			for (var key in this.dynamicProperties)
			{
				array.push(key);
			}
			
			return array;
		}
		
		this.setDynamicProperty = function(key, value){
			this.dynamicProperties[key] = value;
		}
		
		this.addToLike = function () {
			if (this.offer != null && this.count.value > 0)
			{
				add_to_like($('#like_dynamic_' + this.offer['ID']), this.offer['ID'], this.count.value);
				this.structure['OFFERS'][this.offerIndex]['IN_DELAY'] = true;
				this.offer['IN_DELAY'] = true;
			}
		}
		
		this.deleteToLike = function () {
			if (this.offer != null)
			{
				delete_to_like($('#liked_dynamic_' + this.offer['ID']), this.offer['ID']);
				this.structure['OFFERS'][this.offerIndex]['IN_DELAY'] = false;
				this.offer['IN_DELAY'] = false;
			}
		}
		
		this.addToCart = function () {
			if (this.offer != null && this.count.value > 0 && this.offer['IN_CART'] == false)
			{
				add_to_cart(this.offer['ID'],'<?=GetMessage("CATALOG_ADDED")?>', $('#buy_dynamic_' + this.offer['ID']), this.count.value, '<?=$arParams["BASKET_URL"];?>', this.offer['ID'], '<?=$arParams['IBLOCK_ID']?>', '<?=$arParams['IBLOCK_TYPE']?>');
				this.structure['OFFERS'][this.offerIndex]['IN_CART'] = true;
				this.offer['IN_CART'] = true;
			}		
		}
		
		this.updateControls = function() {
			
			// Скрытие свойств
			$(this.selectors.offer.offers + ' ' + this.selectors.offer.offer + ' ' + this.selectors.offer.items + ' ' + this.selectors.offer.item).css('display', 'none');
			// Удаление selected и disabled
			$(this.selectors.offer.offers + ' ' + this.selectors.offer.offer + ' ' + this.selectors.offer.items + ' ' + this.selectors.offer.item).removeClass('selected');
			$(this.selectors.offer.offers + ' ' + this.selectors.offer.offer + ' ' + this.selectors.offer.items + ' ' + this.selectors.offer.item).addClass('hidden');
			$(this.selectors.offer.offers + ' ' + this.selectors.offer.offer + ' ' + this.selectors.offer.items + ' ' + this.selectors.offer.item).removeClass('enabled');
			
			// Отображение доступных
			for (var i = 0; i < this.structure['OFFERS'].length; i++)
			{
				for (var key in this.structure['OFFERS'][i]['TREE'])
				{
					$('#' + key + '_' + this.structure['OFFERS'][i]['TREE'][key]).css('display', 'block');
				}
			}
			
			if (this.offer != null)
			{				
				var propertiesSelected = [];
				var properties = this.getOfferPropertiesArray();
				
				// Включение нажимаемых				
				for (var i = 0; i < properties.length; i++)
				{	
					var currentProperty = properties[i];
					
					for (var j = 0; j < this.structure['OFFERS'].length; j++)
					{
						var compared = true;
				
						for (var k = 0; k < propertiesSelected.length; k++)
						{
							var key = propertiesSelected[k];
							
							if (this.structure['OFFERS'][j]['TREE'][key] != this.offer['TREE'][key])
							{
								compared = false;
								break;
							}
						}
			
						if (compared == true)
						{
							var available = this.structure['OFFERS'][j]['CAN_BUY'];
							
							$('#' + currentProperty + '_' + this.structure['OFFERS'][j]['TREE'][currentProperty]).removeClass('hidden');
							var hideable = $('#' + currentProperty + '_' + this.structure['OFFERS'][j]['TREE'][currentProperty]);
							
							if (!available)
							{
								if (!hideable.hasClass('enabled'))
								{
									hideable.addClass('disabled');
								}
							}
							else
							{
								hideable.removeClass('disabled');
								hideable.addClass('enabled');
							}
						}
					}
					
					propertiesSelected.push(currentProperty);
				}
				
				// Селект проперти
				for (var key in this.offer['TREE'])
				{
					$('#' + key + '_' + this.offer['TREE'][key]).addClass('selected');
				}
				
				// Обновление цены
				if (this.selectors.price != null && this.selectors.priceDiscount != null)
				{
					$(this.selectors.price).html(this.offer['PRICE']['PRINT_VALUE']);
					$(this.selectors.priceDiscount).html(this.offer['PRICE']['PRINT_DISCOUNT_VALUE']);
				}

                //Обновление SKU свойств
                if (this.selectors.skuProp != null)
                {
                    $(this.selectors.skuProp).html(this.offer['DISPLAY_PROPERTIES']);
                }

				// Обновление количества
				
				this.count.maximum = parseInt(this.offer['MAX_QUANTITY']);
				
				if (this.count.maximum == 0)
				{
					this.count.minimum = 0;
				}
				else
				{
					this.count.minimum = 1;
				}
				
				this.count.ratio = parseInt(this.offer['STEP_QUANTITY']);
				
				if (this.offer['CAN_BUY_ZERO'] == 'Y')
				{
					this.count.unlimited = true;
					this.count.minimum = this.count.ratio;
					this.count.maximum = this.count.ratio;
				}
				else
				{
					this.count.unlimited = false;
				}
				
				this.count.set(this.count.value);
				
				if (this.selectors.quantity != null)
				{
					$(this.selectors.quantity).html(this.offer['MAX_QUANTITY']);
					$(this.selectors.quantityPrefix).html(this.offer['MEASURE']);
				}
				
				if (this.selectors.quantityBox != null)
				{
					if (parseInt(this.offer['MAX_QUANTITY']) > 0)
					{
						$(this.selectors.quantityBox).css('display', 'inline');
					}
					else
					{
						$(this.selectors.quantityBox).css('display', 'none');
					}
				}
				
				if (this.selectors.quantityAvailable != null)
				{
					if (parseInt(this.offer['MAX_QUANTITY']) > 0 || this.offer['CAN_BUY_ZERO'] == 'Y')
					{
						$(this.selectors.quantityAvailable).css('display', 'block');
					}
					else
					{
						$(this.selectors.quantityAvailable).css('display', 'none');
					}
				}
				
				if (this.selectors.quantityUnavailable != null)
				{
					if (parseInt(this.offer['MAX_QUANTITY']) == 0 && this.offer['CAN_BUY_ZERO'] == 'N')
					{
						$(this.selectors.quantityUnavailable).css('display', 'block');
					}
					else
					{
						$(this.selectors.quantityUnavailable).css('display', 'none');
					}
				}
				
				// Кнопки покупок и минимальные кнопки
				$(this.selectors.buyButton).hide();
				$(this.selectors.minButtons).hide();
				$(this.selectors.buyOneClickButton).hide();
				$('#min_buttons_' + this.offer['ID']).show();
				
				// Если в корзине
				if (this.offer['IN_CART'] == true)
				{
					$('#buy_dynamic_' + this.offer['ID']).hide();
					$('#buyed_dynamic_' + this.offer['ID']).show();
				}
				else
				{
					$('#buy_dynamic_' + this.offer['ID']).show();
					$('#buyed_dynamic_' + this.offer['ID']).hide();
				}
				
				// Если в отложенном
				if (this.offer['IN_DELAY'] == true)
				{
					$('#like_dynamic_' + this.offer['ID']).hide();
					$('#liked_dynamic_' + this.offer['ID']).show();
				}
				else
				{
					$('#like_dynamic_' + this.offer['ID']).show();
					$('#liked_dynamic_' + this.offer['ID']).hide();
				}	
				
				// Можно купить
				if (this.offer['CAN_BUY'] == true)
				{
					$(this.selectors.buyBlock).show();
					$(this.selectors.minButtons + ' ' + this.selectors.minButtonLike).show();
					$('#one_click_buy_dynamic_' + this.offer['ID']).show();
				}
				else
				{
					$(this.selectors.buyBlock).hide();
					$(this.selectors.minButtons + ' ' + this.selectors.minButtonLike).hide();
					$('#one_click_buy_dynamic_' + this.offer['ID']).hide();
				}
				
				// Слайдер
				$(this.selectors.slider + ' ' + this.selectors.sliderList).hide();
				$(this.selectors.slider + ' ' + this.selectors.sliderImages).hide();
				
				if (this.offer['SLIDER_COUNT'] > 0) {
					$(this.selectors.slider + ' #slider_images_' + this.offer['ID']).show();
					$(this.selectors.slider + ' #slider_' + this.offer['ID']).show();
				}
				else
				{
					$(this.selectors.slider + ' #slider_images').show();
					$(this.selectors.slider + ' #slider').show();
				}
				
				
				
			}
		}
	}
	
	function CapitalProductCount()
		{
			this.value = 1;
			this.minimum = 1;
			this.ratio = 1;
			this.maximum = 1;
			this.unlimited = false;
			this.selectors = null;
			
			this.constructor.prototype.increase = function () {
				if (this.value + this.ratio <= this.maximum || this.unlimited == true) this.value = this.value + this.ratio;
				this.updateControls();
			}
			
			this.constructor.prototype.decrease = function () {
				if (this.value - this.ratio >= this.minimum) this.value = this.value - this.ratio;
				this.updateControls();
			}
			
			this.constructor.prototype.set = function (value) {
				var value = parseInt(value);
				
				if (isNaN(value) || value < this.minimum)
				{
					this.value = this.minimum;
					this.updateControls();
					return false;
				}
				else if (value > this.maximum && this.unlimited == false)
				{
					this.value = this.maximum;
					this.updateControls();
					return false;
				}
				else
				{
					if ((value % this.ratio) == 0)
					{
						this.value = value;
						this.updateControls();
						return true;
					}
					else
					{
						this.value = (value - (value % this.ratio));
						this.updateControls();
						return false;
					}
				}
			}
			
			this.constructor.prototype.updateControls = function () {
				if (this.selectors != null)
				{
					$(this.selectors).val(this.value);
				}
			}
			
			this.constructor.prototype.setControls = function(selector){
				var currentClass = this;
				this.selectors = selector;
				$(selector).keypress(function(e){
					if(48 <= e.which && e.which <= 57) {
						return true;
					} 
					return false;
				}).change(function(){
					currentClass.set($(this).val());
				})
			}
		}
		
	function CapitalProductSlider(slider, list, images)
	{
		this.slider = slider;
		this.list = list;
		this.images = images;
		
		this.constructor.prototype.scroll = function(direction) {
			var changing = 0;
			
			if (direction == 'left')
			{
				var changing = $(this.slider + ' ' + this.list + ' .items').scrollLeft() + $(this.slider + ' ' + this.list + ' .image').width();
			}
			else
			{
				var changing = $(this.slider + ' ' + this.list + ' .items').scrollLeft() - $(this.slider + ' ' + this.list + ' .image').width();
				
			}
			
			$(this.slider + ' ' + this.list + ' .items').animate({scrollLeft: changing}, 200);
		}
		
		this.constructor.prototype.show = function(object) {
			$(this.slider + ' .list .image').removeClass('selected');
			$(object).addClass('selected');
			$(this.slider + ' ' + this.images + ' .image').css('display', 'none');
			$(this.slider + ' ' + this.images + ' .image').eq($(object).index()).css('display', 'block');
		}
		
		this.constructor.prototype.hideAll = function() {
			$(this.slider + ' ' + this.images).hide();
			$(this.slider + ' ' + this.list).hide();
		}
		
		this.constructor.prototype.showAll = function() {
			$(this.slider + ' ' + this.images).show();
			$(this.slider + ' ' + this.list).show();
		}
		
		$(window).resize(function(){
			$(slider + ' ' + list + ' .items').scrollLeft(0);
		})
	}
</script>