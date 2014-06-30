<div class='itemDetails'>
	<div class='description'>	
		<h2><?= $tpl[title] ?></h2>
		<h4>Описание:</h4>
		<?= $tpl[description] ?>
		
		<?= $tpl[variants] ?>		
		<br clear='both'>
		<div class='price'>
			Цена: <b><?= $tpl[item][price] ?></b> грн
		</div>
		<?= $tpl[add_button] ?>
		
		<br clear='both'>
		
		<h4>Комментарии:</h4>
		
		
	</div>
	<div class='images'>
		<?= $tpl[img_previews] ?>
	</div>
		
	
	<script type="text/javascript">
		$(function() {
			$(".images a").fancybox();
		})
	</script>
</div>

