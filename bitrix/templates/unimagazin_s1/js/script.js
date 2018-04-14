$(document).ready(function(){
	$('.fancy').fancybox();	
	$("input[name='PERSONAL_PHONE']").mask("+7 (999) 999-9999");
	$('.button_up').click(function() {
		$('body, html').animate({
			scrollTop: 0
      }, 1000);
   });
})
$(window).scroll(function(){
	var top_show = 300 ;
	if($(this).scrollTop() > top_show) {
		$('.button_up').fadeIn();
	} 
	else {
		$('.button_up').fadeOut();
	}
})

function add_to_compare(element,iblock_type,iblock_id,name_compare,href){	
	$.ajax({
		url:href,
		type:"GET"
	})
	.done(function () {		
		$.ajax(
		'/ajax/show_compare.php',
		{
			IBLOCK_TYPE:iblock_type,
			IBLOCK_ID:iblock_id,
			COMPARE_NAME:name_compare
		})
		.done(function (Res) {		
			$('.b_compare').html(Res);	
			$(element).hide();
			$(element).next().show();
			
			$.ajax(
			'/ajax/add_to_compare_mobile.php',
			{
				IBLOCK_TYPE:iblock_type,
				IBLOCK_ID:iblock_id,
				COMPARE_NAME:name_compare
			})
			.done(function (Res) {		
				$('.b_compare_mobile').html(Res);	
			});
			
		});
		$.post(
		'/ajax/add_to_basket.php',//SITE_DIR
		{action:"ADD_COMPARE"})
		.done(function (Res) {			
			$('.b_basket').html(Res);
			$(element).hide();
			$(element).next().show();
			showBasket();
		});
	});	
	return false;
}
function delete_to_compare(element,iblock_type,iblock_id,name_compare,href){
	$.ajax({
		url:href,
		type:"GET"
	})	
	.done(function () {
		$.post(
		'/ajax/show_compare.php',
		{
			IBLOCK_TYPE:iblock_type,
			IBLOCK_ID:iblock_id,
			COMPARE_NAME:name_compare
		})
		.done(function (Res) {
			$('.b_compare').html(Res);			
			$(element).hide();
			$(element).prev().show();
			
			$.ajax(
			'/ajax/add_to_compare_mobile.php',
			{
				IBLOCK_TYPE:iblock_type,
				IBLOCK_ID:iblock_id,
				COMPARE_NAME:name_compare
			})
			.done(function (Res) {		
				$('.b_compare_mobile').html(Res);	
			});
		});
		$.post(
			'/ajax/add_to_basket.php',//SITE_DIR
			{action:"DELETE_COMPARE"})
		.done(function (Res) {			
			$('.b_basket').html(Res);
			$(element).hide();
			$(element).next().show();
			showBasket();
		});
	})	
	return false;
}	

function add_to_like(element,id,count){			
	$.post(
		'/ajax/add_to_basket.php',//SITE_DIR
		{action:"LIKE",id:id,count:count})
		.done(function (Res) {			
			$('.b_basket').html(Res);
			$(element).hide();
			$(element).next().show();
			
			$.post(
			'/ajax/add_to_basket_mobile.php',
			{})
			.done(function (Res) {
				$('.b_basket_mobile').html(Res);
			});
			
			showBasket();
		});
	return false;
}
function delete_to_like(element,id){
	$.post(
	'/ajax/add_to_basket.php',//SITE_DIR
	{action:"DELETE_FROM_BASKET",id:id})
	.done(function (Res) {			
		$('.b_basket').html(Res);
		$(element).hide();
		$(element).prev().show();
		showBasket()
	});
	return false;
}	

function add_to_cart(id,text,element,count,href,id_product){
	$.post(
		'/ajax/add_to_basket.php',
		{action:"ADD2BASKET",id:id,count:count})
		.done(function (Res) {
			$('.b_basket').html(Res);
			$(element).hide();
			$(element).next().show();
			
			$.post(
			'/ajax/add_to_basket_mobile.php',
			{})
			.done(function (Res) {
				$('.b_basket_mobile').html(Res);
			});
			
		});
	return false;
}
function showBasket(){
	$.post(
		'/ajax/add_to_basket.php',
		{action:"SHOWBASKET"})
		.done(function (Res) {
			$('.small_basket').parent().html(Res);			
		})
}

/*FLY Basket*/

function fly_basket_delete_product(id){		
	$.post(
		'/ajax/add_to_basket.php',
		{action:"DELETE_FROM_BASKET",id:id})
		.done(function (Res) {
			$('.b_basket').html(Res);
			if (uniFlyBasket !== undefined) uniFlyBasket.switchSectionByID('product-section', false);
		});
	return false;
}

function fly_basket_delete_all_product(){		
	$.post(
		'/ajax/add_to_basket.php',
		{action:"DELETE_ALL_FROM_BASKET"})
		.done(function (Res) {
			$('.b_basket').html(Res);
			if (uniFlyBasket !== undefined) uniFlyBasket.switchSectionByID('product-section', false);
		});
	return false;
}

function fly_basket_change_count(id,value,fn){		
	$.post(
		'/ajax/add_to_basket.php',
		{action:"CHANGE_COUNT",id:id,count:value})
		.done(function (Res) {
			if (fn !== undefined) fn(Res);
		});
}

function fly_basket_move_to_cart(id,quantity){
	$.post(
		'/ajax/add_to_basket.php',
		{action:"ADD2BASKET",id:id,count:quantity})
		.done(function (Res) {
			$('.b_basket').html(Res);
			if (uniFlyBasket !== undefined) uniFlyBasket.switchSectionByID('like-section', false);
		});
	return false;
}

function fly_basket_move_to_like(id,quantity){
	$.post(
		'/ajax/add_to_basket.php',
		{action:"LIKE",id:id,count:quantity})
		.done(function (Res) {
			$('.b_basket').html(Res);
			if (uniFlyBasket !== undefined) uniFlyBasket.switchSectionByID('product-section', false);
		});
	return false;
}

function fly_basket_delete_like(id)
{
	$.post(
	'/ajax/add_to_basket.php',
	{action:"DELETE_FROM_BASKET",id:id})
	.done(function (Res) {			
		$('.b_basket').html(Res);
		if (uniFlyBasket !== undefined) uniFlyBasket.switchSectionByID('like-section', false);
	});
}

function fly_basket_delete_all_like()
{
	$.post(
	'/ajax/add_to_basket.php',
	{action:"DELETE_ALL_FROM_LIKE"})
	.done(function (Res) {			
		$('.b_basket').html(Res);
		if (uniFlyBasket !== undefined) uniFlyBasket.switchSectionByID('like-section', false);
	});
}

//popups
function openQuickViewPopup (id){
	var reviewPopup = BX.PopupWindowManager.create("QuickView"+id, null, {
		autoHide: true,			
		offsetLeft: 0,
		offsetTop: 0,
		overlay : true,
		draggable: {restrict:true},
		closeByEsc: true,
		closeIcon: { right : "32px", top : "23px"},
		content: '<div style="width:542px;height:427px; text-align: center;"><span style="position:absolute;left:50%; top:50%"><img src="/images/please_wait.gif"/></span></div>',
		events: {
			onAfterPopupShow: function()
			{
				BX.ajax.post(
						'/ajax/show_element.php',
						{
							"ELEMENT_ID":id							
						},
						BX.delegate(function(result)
						{
							this.setContent(result);
						},
						this)
				);
			}
		}
	});
	reviewPopup.show();	
	$('.continue').click(function(){		
		$('#QuickView'+id).hide();
		$('.popup-window-overlay').hide();
	})
}
function openResumePopup (id,name_jobs,site_dir) {
		var resumePopup = BX.PopupWindowManager.create("ReviewPopup", null, {
			autoHide: true,			
			offsetLeft: 0,
			offsetTop: 0,
			overlay : true,
			draggable: {restrict:true},
			closeByEsc: true,
			closeIcon: { right : "20px", top : "16px"},
			content: '<div style="width:404px;height:713px; text-align: center;"><span style="position:absolute;left:50%; top:50%"><img src="/images/wait.gif"/></span></div>',
			events: {
				onAfterPopupShow: function()
				{
					BX.ajax.post(
							site_dir+'ajax/send_resume.php',
							{
								
							},
							BX.delegate(function(result)
							{
								this.setContent(result);
							},
							this)
					);
				}
			},
			buttons: [
				   new BX.PopupWindowButton({
					  className: "bx_popup_close" ,
					  events: {click: function(){
						 this.popupWindow.close();
					  }}
				   })
			]
			});
		resumePopup.show();
	}
function openCallForm(site_dir) {
	var callPopup = BX.PopupWindowManager.create("CallPopup", null, {
		autoHide: true,			
		offsetLeft: 0,
		offsetTop: 0,
		overlay : true,
		draggable: {restrict:true},
		closeByEsc: true,
		closeIcon: { right : "32px", top : "23px"},
		content: '<div style="width:404px;height:290px; text-align: center;"><span style="position:absolute;left:50%; top:50%"><img src="/images/please_wait.gif"/></span></div>',
		events: {
			onAfterPopupShow: function()
			{
				BX.ajax.post(
						site_dir+'ajax/call.php',
						{
							
						},
						BX.delegate(function(result)
						{
							this.setContent(result);
						},
						this)
				);
			}
		},
		buttons: [
               new BX.PopupWindowButton({
                  className: "bx_popup_close" ,
                  events: {click: function(){
                     this.popupWindow.close();
                  }}
               })
        ]
	});
	callPopup.show();
}
//feedback popup
function openFaqPopup (site_dir) {
	var faqPopup = BX.PopupWindowManager.create("FaqPopup", null, {
		autoHide: true,			
		offsetLeft: 0,
		offsetTop: 0,
		overlay : true,
		draggable: {restrict:true},
		closeByEsc: true,
		closeIcon: { right : "32px", top : "23px"},
		content: '<div style="width:404px;height:290px; text-align: center;"><span style="position:absolute;left:50%; top:50%"><img src="/images/please_wait.gif"/></span></div>',
		events: {
			onAfterPopupShow: function()
			{
				BX.ajax.post(
						site_dir+'ajax/feedback.php',
						{
							
						},
						BX.delegate(function(result)
						{
							this.setContent(result);
						},
						this)
				);
			}
		},
		buttons: [
               new BX.PopupWindowButton({
                  className: "bx_popup_close" ,
                  events: {click: function(){
                     this.popupWindow.close();
                  }}
               })
        ]
	});
	faqPopup.show();
}

function openOrderServicePopup (site_dir, service_name) {
	var orderServicePopup = BX.PopupWindowManager.create("ReviewPopup", null, {
		autoHide: true,			
		offsetLeft: 0,
		offsetTop: 0,
		overlay : true,
		draggable: {restrict:true},
		closeByEsc: true,
		closeIcon: { right : "20px", top : "16px"},
		content: '<div style="width:404px;height:483px; text-align: center;"><span style="position:absolute;left:50%; top:50%"><img src="/images/please_wait.gif"/></span></div>',
		events: {
			onAfterPopupShow: function()
			{
				BX.ajax.post(
						site_dir+'ajax/order_service.php',
						{
							
						},
						BX.delegate(function(result)
						{
							this.setContent(result);
							$('form[name=SERVICE_s1] .controls .input .inputtext').eq(0).val(service_name);
						},
						this)
				);
			}
		},
		buttons: [
               new BX.PopupWindowButton({
                  className: "bx_popup_close" ,
                  events: {click: function(){
                     this.popupWindow.close();
                  }}
               })
        ]
	});
	orderServicePopup.show();
	
}

function number_format( number, decimals, dec_point, thousands_sep ) {
	var i, j, kw, kd, km;

	if( isNaN(decimals = Math.abs(decimals)) ){
		decimals = 2;
	}
	if( dec_point == undefined ){
		dec_point = ",";
	}
	if( thousands_sep == undefined ){
		thousands_sep = ".";
	}

	i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

	if( (j = i.length) > 3 ){
		j = j % 3;
	} else{
		j = 0;
	}

	km = (j ? i.substr(0, j) + thousands_sep : "");
	kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
	kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");

	return km + kw + kd;
}

function UNISlider ($oSettings) {
    var that = this;

    this.defaults = {
        'INFINITY_SLIDE': false,
        'INFINITY_SLIDER': false,
        'SLIDER': '.slider',
        'ELEMENT': '.slide',
        'CURRENT': 0,
        'OFFSET': 1,
        'CUSTOM_CHANGE_RULE': null,
        'ANIMATE': false,
        'ANIMATE_SPEED': 500,
        'AUTO_SLIDE': false,
        'AUTO_SLIDE_TIME': 3000,
        'AUTO_SLIDE_ENABLED': true,
        'EVENTS': {
            'onSlideLeft': function () {},
            'onSlideRight': function () {},
            'onSlide': function () {},
            'onAdaptabilityChange': function () {},
            'onBeforSlide': function () {},
            'onAfterSlide': function () {},
            'onBeforeAnimate': function () {},
            'onAfterAnimate': function () {}
        },
        'ADAPTABILITY': []
    }

    this.Settings = $.extend({}, this.defaults, $oSettings || {});

    this.constructor.prototype.GetMinSlide = function () {
        return 0;
    }

    this.constructor.prototype.GetMaxSlide = function () {
        return this.GetElementsCount() - this.Settings.OFFSET;
    }

    this.constructor.prototype.GetCurrentSlide = function () {
        return this.Settings.CURRENT;
    }

    this.constructor.prototype.GetElements = function () {
        return $(this.Settings.ELEMENT)
    }

    this.constructor.prototype.GetSlider = function () {
        return $(this.Settings.SLIDER)
    }

    this.constructor.prototype.GetElementsCount = function () {
        return this.GetElements().size();
    }

    this.constructor.prototype.GetSliderWidth = function () {
        var $oSlider = $(this.Settings.SLIDER);
        var $fWidth = 0;

        if ($oSlider[0] !== undefined)
            if (__isFunction($oSlider[0].getBoundingClientRect)){
                var $oRectangle = $oSlider[0].getBoundingClientRect();
                $fWidth = parseFloat($oRectangle.right - $oRectangle.left);
            }

        if ($fWidth == 0)
            if ($oSlider.css('box-sizing') == 'border-box') {
                $fWidth = parseFloat($oSlider.outerWidth(false));
            } else {
                $fWidth = parseFloat($oSlider.width());
            }

        return $fWidth;
    }

    this.constructor.prototype.GetElementWidth = function () {
        var $oElements = $(this.Settings.ELEMENT);
        var $fWidth = 0;

        if ($oElements[0] !== undefined)
            if (__isFunction($oElements[0].getBoundingClientRect)){
                var $oRectangle = $oElements[0].getBoundingClientRect();
                $fWidth = parseFloat($oRectangle.right - $oRectangle.left);
            }

        if ($fWidth == 0)
            if ($oElements.css('box-sizing') == 'border-box') {
                $fWidth = parseFloat($oElements.outerWidth(false));
            } else {
                $fWidth = parseFloat($oElements.width());
            }

        return $fWidth;
    }

    this.constructor.prototype.SlideLeft = function () {
        this.Settings.AUTO_SLIDE_ENABLED = false;
        this.SlideTo(this.Settings.CURRENT + 1);

        if (__isObject(this.Settings.EVENTS))
            if (__isFunction(this.Settings.EVENTS.onSlideLeft))
                this.Settings.EVENTS.onSlideLeft(this);
    }

    this.constructor.prototype.SlideRight = function () {
        this.Settings.AUTO_SLIDE_ENABLED = false;
        this.SlideTo(this.Settings.CURRENT - 1);

        if (__isObject(this.Settings.EVENTS))
            if (__isFunction(this.Settings.EVENTS.onSlideRight))
                this.Settings.EVENTS.onSlideRight(this);
    }

    this.constructor.prototype.Slide = function ($iSlideNumber) {
        this.Settings.AUTO_SLIDE_ENABLED = false;
        this.SlideTo($iSlideNumber);

        if (__isObject(this.Settings.EVENTS))
            if (__isFunction(this.Settings.EVENTS.onSlide))
                this.Settings.EVENTS.onSlide(this);
    }

    this.constructor.prototype.SlideTo = function ($iSlideNumber) {
        var that = this;
        var $oSettings = {};
        $oSettings.SLIDE = {};
        $oSettings.SLIDE.CURRENT = this.GetCurrentSlide();
        $oSettings.SLIDE.NEXT = parseInt($iSlideNumber);
        $oSettings.BOUNDARIES = {};
        $oSettings.BOUNDARIES.MINIMUM = this.GetMinSlide();
        $oSettings.BOUNDARIES.MAXIMUM = this.GetMaxSlide();
        $oSettings.ELEMENT = {};
        $oSettings.ELEMENT.WIDTH = this.GetElementWidth();
        $oSettings.ANIMATE = this.Settings.ANIMATE;
        $oSettings.ANIMATE_SPEED = this.Settings.ANIMATE_SPEED;
        $oSettings.INFINITY_SLIDE = this.Settings.INFINITY_SLIDE;
        $oSettings.INFINITY_SLIDER = this.Settings.INFINITY_SLIDER;

        if (__isFunction(this.Settings.EVENTS.onBeforeSlide))
            this.Settings.EVENTS.onBeforeSlide(this, $oSettings);

        if ($oSettings.INFINITY_SLIDER == true) {
            $oSettings.INFINITY_SLIDE = false;
            $oSettings.BOUNDARIES.MAXIMUM = 2;
            $oSettings.SLIDE.CURRENT = 1;
        }

        if ($oSettings.SLIDE.NEXT > $oSettings.BOUNDARIES.MAXIMUM)
            if ($oSettings.INFINITY_SLIDE == true) {
                $oSettings.SLIDE.NEXT = $oSettings.BOUNDARIES.MINIMUM;
            } else {
                $oSettings.SLIDE.NEXT = $oSettings.BOUNDARIES.MAXIMUM;
            }

        if ($oSettings.SLIDE.NEXT < $oSettings.BOUNDARIES.MINIMUM)
            if ($oSettings.INFINITY_SLIDE == true) {
                $oSettings.SLIDE.NEXT = $oSettings.BOUNDARIES.MAXIMUM;
            } else {
                $oSettings.SLIDE.NEXT = $oSettings.BOUNDARIES.MINIMUM;
            }

        if ($oSettings.INFINITY_SLIDER == true)
            if ($oSettings.SLIDE.NEXT < $oSettings.SLIDE.CURRENT) {
                var $oSlider = this.GetSlider();
                var $arElements = this.GetElements();
                $arElements.last().prependTo($oSlider);
                $oSettings.SLIDE.NEXT++;
                $oSettings.SLIDE.CURRENT++;
                $(this.Settings.SLIDER).scrollLeft($oSettings.ELEMENT.WIDTH * 2);
            } else if ($oSettings.SLIDE.NEXT > $oSettings.SLIDE.CURRENT) {
                var $oSlider = this.GetSlider();
                var $arElements = this.GetElements();
                $arElements.first().appendTo($oSlider);
                $oSettings.SLIDE.NEXT--;
                $oSettings.SLIDE.CURRENT--;
                $(this.Settings.SLIDER).scrollLeft(0);
            }

        console.log($oSettings);

        if (__isFunction(this.Settings.CUSTOM_CHANGE_RULE)) {
            this.Settings.CUSTOM_CHANGE_RULE(this, $oSettings);
        } else {
            if ($oSettings.ANIMATE == true) {
                if (__isFunction(this.Settings.EVENTS.onBeforeAnimate))
                    this.Settings.EVENTS.onBeforeAnimate(this, $oSettings);

                $(this.Settings.SLIDER).stop().animate({scrollLeft:$oSettings.SLIDE.NEXT * $oSettings.ELEMENT.WIDTH}, $oSettings.ANIMATE_SPEED, function () {
                    if (__isFunction(that.Settings.EVENTS.onAfterAnimate))
                        that.Settings.EVENTS.onAfterAnimate(that, $oSettings);
                });
            } else {
                $(this.Settings.SLIDER).scrollLeft($oSettings.SLIDE.NEXT * $oSettings.ELEMENT.WIDTH);
            }
        }

        if (__isFunction(this.Settings.EVENTS.onAfterSlide))
            this.Settings.EVENTS.onAfterSlide(this, $oSettings);

        if ($oSettings.INFINITY_SLIDER == true) {
            this.Settings.CURRENT = 1;
        } else {
            this.Settings.CURRENT = $oSettings.SLIDE.NEXT;
        }
    }

    function __isFunction($oFunction) {
        return Object.prototype.toString.call($oFunction) == '[object Function]';
    }

    function __isArray($oArray) {
        return Object.prototype.toString.call($oArray) == '[object Array]';
    }

    function __isObject($oObject) {
        return Object.prototype.toString.call($oObject) == '[object Object]';
    }

    this.constructor.prototype.__ChangeRules = function () {
        var $iCurrentWidth = $(window).width();
        var $arRules = this.Settings.ADAPTABILITY;
        var $iRulesCount = $arRules.length;
        var $iCurrentRuleWidth = -1;
        var $oCurrentRule = {'WIDTH':'DEFAULT', 'SETTINGS':{}};
        var $bAnimate = this.Settings.ANIMATE;

        for (var $iRuleIndex = 0; $iRuleIndex < $iRulesCount; $iRuleIndex++) {
            if ($arRules[$iRuleIndex].WIDTH != 'DEFAULT') {
                var $iRuleWidth = parseInt($arRules[$iRuleIndex].WIDTH);

                if ($iRuleWidth > $iCurrentWidth && (($iRuleWidth < $iCurrentRuleWidth) || ($iCurrentRuleWidth < 0))) {
                    $iCurrentRuleWidth = $iRuleWidth;
                    $oCurrentRule = $arRules[$iRuleIndex];
                }
            } else {
                $oCurrentRule = $arRules[$iRuleIndex];
            }
        }

        if (__isObject($oCurrentRule.SETTINGS))
            for (var $sSettingKey in $oCurrentRule.SETTINGS)
                this.Settings[$sSettingKey] = $oCurrentRule.SETTINGS[$sSettingKey];

        if (__isFunction($oCurrentRule.ACTION))
            $oCurrentRule.ACTION(this);

        this.Settings.ANIMATE = false;
        this.SlideTo(this.GetCurrentSlide());
        this.Settings.ANIMATE = $bAnimate;

        if (__isObject(this.Settings.EVENTS))
            if (__isFunction(this.Settings.EVENTS.onAdaptabilityChange))
                this.Settings.EVENTS.onAdaptabilityChange(this);
    }

    this.__ChangeRules();

    $(window).on('resize', function () {
        that.__ChangeRules();
    });

    if (this.Settings.AUTO_SLIDE == true) {
        this.Settings.AUTO_SLIDE_ENABLED = true;
        setInterval(function() {
            if (that.Settings.AUTO_SLIDE_ENABLED)
                that.SlideTo(that.GetCurrentSlide() + 1);
        }, this.Settings.AUTO_SLIDE_TIME)
    }
}