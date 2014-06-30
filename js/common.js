$(function() {

	
	
	$('.add_to_basket').click(function() {
		$(this).hide().load('/ajax/index.php?module=basket&action=add',{
			'id': $(this).attr('data-id'),
			'variant': $('#variant').val(),
			'count': 1
		},function() {
			$('.add_to_basket').fadeIn(1000).attr('href','/cart');
			$('#basket_count').html(parseInt($('#basket_count').html())+1);
		});
	});
	$('.delete_from_basket').click(function() {
		$(this).parent().parent().load('/ajax/index.php?module=basket&action=delete',{
			'id': $(this).attr('data-id'),
		});
	});
	
	$('input[name=delivery]').change(function() {
		$('.delivery_input').addClass('hidden');
		$('.delivery_input[data-type='+$(this).attr('data-type')+']').removeClass('hidden');
		//alert($(this).attr('data-type'));
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
			interval: 4000,
			auto: true
		}
	});
	
	if ($.cookie("currentColor")!=undefined) less.modifyVars({ accent_color : $.cookie("currentColor") });
	
});