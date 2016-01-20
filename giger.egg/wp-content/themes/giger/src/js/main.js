/* Scripts */
jQuery(document).ready(function($){
	
	
	/** Has js **/
	$('html').removeClass('no-js').addClass('js');
	
    /** Window width **/
	var windowWidth = $('#top').width();
	
	/** movable widget **/
	var sidebar = $('.masonry-grid').find('.movable-widget').detach();		
	sidebar.insertAfter('.masonry-grid .masonry-item:nth-of-type(2)');
	
	
	/** smart crumbs **/
	var crumb = $('.crumb-name, .page-template-page-home .site-logo');
	if (crumb.length) {
		$('.mdl-layout__content').scroll(function(){
			
			if($(this).scrollTop() >= 165){
				crumb.css({opacity : 1});			
			} else {
				//console.log($(this).scrollTop());
				crumb.css({opacity : 0});		
			}		
		});
	}
	
	/** Float panel **/
	function getDocHeight() {
		var D = document;
		return Math.max(
			D.body.scrollHeight, D.documentElement.scrollHeight,
			D.body.offsetHeight, D.documentElement.offsetHeight,
			D.body.clientHeight, D.documentElement.clientHeight );
	}
	
	var floatPanel = $('#float-panel'),		
		docHeight =  $(document).height();
		
				
	$('.mdl-layout__content').scroll(function() {
		//console.log($('.mdl-layout__content').scrollTop() + $(window).height() +30);
		//&& ($('.mdl-layout__content').scrollTop() + $(window).height() +50 <= docHeight)
			
		if($('.mdl-layout__content').scrollTop() >= 250 && ($('.mdl-layout__content').scrollTop() + $(window).height() +40 <= docHeight)){
			floatPanel.slideDown(300);			
		} else {
			floatPanel.slideUp(300);
		}		
	});
	
	
	
	/** Tooltips in calendar **/
	function position_tooltip(trigger, tip){
		
		var	tPosition = trigger.offset(),
			tW = trigger.width(),
			tH = trigger.height(),
			tipMarginLeft = -1*tip.width()/2,
			tipLeft = tW/2 + tPosition.left,
			tipTop = parseInt(tPosition.top) + tH + 10 - parseInt($(window).scrollTop());
		
		
		
		if (tipLeft + tipMarginLeft < 0) {
			tipLeft = 0;
			tipMarginLeft = 0;
		}
		
		tip.css({
			'left' : tipLeft+'px',
			'top' : tipTop + 'px',
			'margin-left' : tipMarginLeft + 'px'
		});
	}
		
	//visibility
	$('body').on('mouseenter', '.tst-add-calendar', function(e){
		e.stopPropagation();
		var trigger = $(this),
			tipTarget = trigger.attr('id'),
			tip = $('span[for="'+tipTarget+'"]');
				
		//don't open if d-down is visible
		if('visible' != trigger.find('.atcb-list').css('visibility')){
			//position			
			position_tooltip(trigger, tip);
			
			tip.addClass('active');
			
			//listen for click
			trigger.on('click', function(ev){
				//hide
				tip.removeClass('active').removeAttr('style');
			});	
		}
	})
	.on('mouseleave', '.tst-add-calendar', function(e){
		e.stopPropagation();
		var trigger = $(this),
			tipTarget = trigger.attr('id'),
			tip = $('span[for="'+tipTarget+'"]');
			
			tip.removeClass('active').removeAttr('style');
	});
	
	
	/** Calendar **/	
	var topPad = (windowWidth > 940) ? 100 : 50;
	
	$('.event-modal').easyModal({
		//overlayParent :'.page-content',
		hasVariableWidth : true,
		top : topPad,
		transitionIn: 'animated zoomIn',
		transitionOut: 'animated zoomOut',
		onClose : function(){ $('#modal-card').empty(); },
		onOpen : function() {
			
			//bind tip interaction
			$('#modal-card').find('.in-modal-add-tip').mouseenter(function(e){
				
				e.stopPropagation();
				var trigger = $(this),
					tipTarget = trigger.attr('id'),
					tip = $('span[for="'+tipTarget+'"]');
					
				//don't open if d-down is visible
				if('visible' != trigger.find('.atcb-list').css('visibility')){
					//position							
					tip.addClass('active');
					
					//listen for click
					trigger.on('click', function(ev){
						//hide
						tip.removeClass('active');
					});	
				}
			})
			.mouseleave(function(e){
				e.stopPropagation();
				var trigger = $(this),
					tipTarget = trigger.attr('id'),
					tip = $('span[for="'+tipTarget+'"]');
					
					tip.removeClass('active');
			}); //mouseactions			
		}
	});
	
	// modal in calendar	
	$('body').on('click','.day-link', function(e){
		
		var trigger = $(e.target),
			target, targetEl;
		
		if (trigger.hasClass('day-link')) {
			target = trigger.attr('data-emodal');
		}
		else {
			target = trigger.parents('.day-link').attr('data-emodal');
		}
				
		targetEl = $(target).clone(true);
		
		$('#modal-card').empty().append(targetEl).trigger('openModal');
		
		e.preventDefault();
	});
	
	$('body').on('click','.calendar-scroll', function(e){
	
		e.preventDefault();		
		var target = $(e.target),
			container = $('#calendar-place');
				
		$.ajax({
			type : "post",
			dataType : "json",
			url : frontend.ajaxurl,
			data : {
				'action': 'calendar_scroll',			
				'nonce' : target.attr('data-nonce'),
				'month' : target.attr('data-month'),
				'year'  : target.attr('data-year')
			},
			beforeSend : function () {
				
				var h = container.height();
				container.addClass('loading').css({height : h+'px'});
			},				
			success: function(response) {
				
				if (response.type == 'ok') {
					container.empty().html(response.data).removeClass('loading').removeAttr('style');
				}
			}
		});
	});
	
	
	
		
	/** Responsive media **/
    var resize_embed_media = function(){

        $('iframe').each(function(){

            var $iframe = $(this),
                $parent = $iframe.parent(),
                do_resize = false;
            if($parent.hasClass('embed-content'))
                do_resize = true;            
            else {                
                
                $parent = $iframe.parents('.entry-content');
                if($parent.length)
                    do_resize = true;
            }

            if(do_resize) {

                var change_ratio = $parent.width()/$iframe.attr('width');
                $iframe.width(change_ratio*$iframe.attr('width'));
                $iframe.height(change_ratio*$iframe.attr('height'));
            }
        });
    };
	
    resize_embed_media(); // Initial page rendering
    $(window).resize(function(){		
		resize_embed_media();	
	});
	
	
	/** Select dropdown **/
	var selectMat = $('.tst-select');
	selectMat.each(function(i){
				
		var selectContainer = $(this),
			optionsData = selectContainer.find('option'),
			selectedVal = selectContainer.find('select').val(),
			selectedText = selectContainer.find('option').filter('[value = "'+selectedVal+'"]').text(),
			insnanceId = 'tst-select-'+i,
			trigger = $('<div class="tst-menu-trigger mdl-button mdl-js-button" id="'+insnanceId+'">'+selectedText+'</div>')
			menuUl = $('<ul class="tst-select-menu mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="'+insnanceId+'"></ul>');
		
		if (optionsData.length) {
			optionsData.each(function(){
				var opt = $(this),
					value = $(this).val(),
					label = $(this).text(),
					li = $('<li class="mdl-menu__item">'+label+'</li>');
					
				if (value == selectedVal) {
					li.addClass('selected');
				}
								
				li.attr({'data-value': value}).appendTo(menuUl);				
			});
		}
		
		selectContainer.find('select').hide();		
		selectContainer.append(trigger).append(menuUl);
		
		menuUl.on('click', 'li', function(e){
			
			var selVal = $(this).attr('data-value'),
				field = $(this).parents('.tst-select');
			
			field.find('.tst-menu-trigger').text(selVal);
			field.find('select').val(selVal).change();
			field.find('.mdl-menu__item').removeClass('selected');
			$(this).addClass('selected');
			
			//field.find('options').prop('selected', false).filter('[value="'+selVal+'"]').prop('selected', true);
			
		});
	});
		
	
	/** Leyka custom modal **/
	var leykaTopPad = (windowWidth > 940) ? 120 : 65;
	$('.leyka-custom-modal').easyModal({
		overlayParent :'.leyka-custom-template',
		hasVariableWidth : true,
		top : leykaTopPad,
		transitionIn: 'animated zoomIn',
		transitionOut: 'animated zoomOut',
		onClose : function(){  }
	});
	
	$('body').on('click','.leyka-custom-confirmation-trigger', function(e){
		
		var trigger = $(e.target),
			target;
		
		if (trigger.hasClass('leyka-custom-confirmation-trigger')) {
			target = trigger.attr('data-lmodal');
		}
		else {
			target = trigger.parents('.leyka-custom-confirmation-trigger').attr('data-lmodal');
		}
			
		
		$('#leyka-agree-text').trigger('openModal');
		
		
		e.preventDefault();
	});
	
	$('body').on('click', '.leyka-modal-close', function(e){
		$('#leyka-agree-text').trigger('closeModal');
	});
	
	//numeric field for amount
	

	if ($.fn.numeric) {
		//console.log($(".leyka-field.amount").find('input[name="leyka_donation_amount"]'));
		$('input[name="leyka_donation_amount"]').numeric();
		$('input[type="number"]').numeric();
	}

	//calendar height bugfix
	function fix_calendar_height() {
		var gridCell = $('#calendar_content').find('.mdl-cell--9-col'),
			gridCellContent = gridCell.find('.calendar-card');
		
		
		if (gridCellContent.height() < gridCell.height()) {
			console.log(gridCell.height());
			console.log(gridCellContent.height());
			
			var targetH = gridCell.height();			
			gridCellContent.height(targetH+'px');
		}
	}
	
	fix_calendar_height();
	$(window).resize(function(){
		fix_calendar_height();	
	});
	
	
	//fix for equal height in flexbox
	function flex_equal_height(){
		
		$('.mdl-cell .mdl-card').each(function(){
			
			var $_this = $(this);
			
			if (!$_this.hasClass('widget')) {
				var h = $_this.parents('.mdl-cell').height();
				$_this.height(h);
			}			
		});
	}
	
	imagesLoaded('#page_content', function() {
		flex_equal_height();
	});
		
	$(window).resize(function(){
		flex_equal_height();	
	});
	
	
	//toggle
	$(document).on('click', '.su-spoiler-title', function(e){
		
		var toggle = $(this).parents('.su-spoiler');
		
		if (toggle.hasClass('toggled')) {
			//close
			toggle.find('.su-spoiler-content').slideUp();
			toggle.removeClass('toggled');
		}
		else {
			toggle.find('.su-spoiler-content').slideDown();
			toggle.addClass('toggled');
		}
	});
	
	//newsletter modal
	$('#modal-newsletter').easyModal({
		//overlayParent :'.page-content',
		hasVariableWidth : true,
		top : topPad,
		transitionIn: 'animated zoomIn',
		transitionOut: 'animated zoomOut',
		onClose : function(){  },
		onOpen : function() {
			
				
		}
	});
	
	$('#newsletter').on('click', function(e){
		e.preventDefault();
		$('#modal-newsletter').trigger('openModal');
	});
	
		
	/* Menu bottom on mobile */
	//function moveHeader() {
	//	
	//	var windowWidth = $('#top').width(),			
	//		header = $('.mdl-layout__header');
	//		
	//		
	//	if(windowWidth < 481) {			
	//		header.insertAfter('.mdl-layout__content');			
	//	}
	//	else {						
	//		header.insertBefore('.mdl-layout__content');		
	//	}
	//}
	//
	//moveHeader();
	//$(window).resize(function(){
	//	moveHeader();
	//});
	//
	
	/* headers in forms */
	$('.frm_forms').each(function(){
		
		var form = $(this),
			title = $(this).find('.frm_form_fields > h3');
		
		if (form.parents('#modal-newsletter').length <= 0 && title.length > 0) {
			$(this).addClass('has-title');
		}
		
	});
	
	
	//tabs active
	$('.mdl-tabs').each(function(){
		var activeTab = $(this).find('.mdl-tabs__tab-bar').find('a.is-active').attr('href');
			
		$(this).find(activeTab).addClass('is-active');
			
	});
	
}); //jQuery