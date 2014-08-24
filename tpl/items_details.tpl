<div class='itemDetails'>
	<div class='description'>	
		<h2><?= $tpl[title] ?></h2>
		<h4>Описание:</h4>
		<?= $tpl[description] ?>
		
		<?= $tpl[variants] ?>		
		<br class='clearBoth'>
		<div class='price'>
			Цена: <b><?= $tpl[item][price] ?></b> грн
		</div>
		<?= $tpl[add_button] ?>
		
		<br class='clearBoth'>
		
		<h4>Отзывы и комментарии:</h4>
		<div class='commentsBlock'>
			<?= $tpl[comments] ?>
			<form action='#' method='post'>
				<input type="hidden" name='item_id' value='<?= $tpl[item][id]?>'>
				<textarea name='comment' id='comment_input' placeholder='Введите ваш комментарий'></textarea> <br>
				<div class='commentAdd' style='display:none'>
					Ваше имя: <input type="text" name='name' value="<?= CComments::generateNick() ?>" placeholder="Ваше имя"> <br>					
				</div>
				<input type='submit' value="Добавить" class='button' name='submit_comment'>
			</form>
		</div>
		
		
	</div>
	<div class='images'>
		<?= $tpl[img_previews] ?>
	</div>
	
	<br class='clearBoth'>
	<h4 style='margin-top:100px'>Вас может заинтересовать</h4>
	<div class='similar itemsList'>
		<?= $tpl[similar] ?>
	</div>
		
	
	<script type="text/javascript">
		$(function() {
			$(".images a").attr('rel','gallery').fancybox();
		})
	</script>
</div>

