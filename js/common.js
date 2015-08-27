$(function() {


	// BASKET FUNCTIONS
	function refreshOrderSum() {
		var items = 0;
		items += parseInt($('#orderSum').attr('data-items-sum'));
		//if (items<500 && $('[name=delivery]:checked').val()=='subway') items += 30;
		//if (items<500 && $('[name=delivery]:checked').val()=='global') items += 40;
		$('#orderSum').html(items);
		$('input[name=price]').val(items);
	}
	$('.add_to_basket').click(function() {
		//alert($(this).attr('href'));
		if ($(this).attr('href')!=undefined) return true;
		$(this).hide().load('/ajax/index.php?module=basket&action=add',{
			'id': $(this).attr('data-id'),
			'variant': $('#variant').val(),
			'count': 1
		},function() {
			$('.add_to_basket').fadeIn(1000).attr('href','/cart');
			$('#basket_count').html(parseInt($('#basket_count').html())+1);
		});
	});
	
	$('input[name=delivery]').change(function() {
		$('.delivery_input').addClass('hidden');
		$('.delivery_input[data-type='+$(this).attr('data-type')+']').removeClass('hidden');
		refreshOrderSum();
	});
	
	$('.changeColor').click(function() {
		less.modifyVars({ accent_color : $(this).css('background-color') });
		$.cookie("currentColor", $(this).css('background-color'), { path: '/', expires: 30 });
	});
	
	$("#slides").slidesjs({
		width: 468,
		height: 408,
		play: {
			active: true,
			interval: 7000,
			auto: true
		}
	});
	
	$('#comment_input').keyup(function() {
		console.log($(this).val().length);
		if ($(this).val().length>15) $('.commentAdd').show(500);
	});
	
	$('.menuToggler').click(function() {
		$(this).toggleClass('active');
		return false;
	});
	
	$('.images a.all').click(function() {
		window.open($(this).attr('href'), 'popup', 'height=700, width=800, location=no, status=no, scrollbars=yes, menubars=no, toolbars=no, resizable=no') 
		return false;
	});
	
	if ($.cookie("currentColor")!=undefined) less.modifyVars({ accent_color : $.cookie("currentColor") });
	
	$('#back_to_top').scrollToTop();
	
	$(".images a, a.gallery").attr('rel','gallery').fancybox();
	
	
});