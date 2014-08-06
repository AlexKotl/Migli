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
		<div class='commentsBlock'>
			<?= $tpl[comments] ?>
			<form action='' method='post'>
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
		
	
	<script type="text/javascript">
		$(function() {
			$(".images a").fancybox();
		})
	</script>
</div>

