var loaded_count = 0;
$(function() {
	var frame = 0;
	//var loaded_count = 0;
	
	$('.start').click(function() {
		$('.film div').each(function() {
			$(this).show();
			frame = 0;
		});
		$($('.film div').get().reverse()).each(function(i, el) {
			setTimeout(function(){
				$(el).fadeOut(500);
				frame++;
				$('#frame').html(frame);
			}, i*500);
		});
		

	});
});