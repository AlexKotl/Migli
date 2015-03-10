<div class='itemDetails'>
	<div class='description'>	
		<h2><?= $tpl[title] ?></h2>
		<h4>Описание:</h4>
		<?= $tpl[description] ?>
		
		<? if ($tpl[item][flag]==1) { ?>
			<?= $tpl[variants] ?>		
			<br class='clearBoth'>
			<div class='price'>
				Цена: <b><?= ( $tpl[item][price_promo]>0 ? $tpl[item][price_promo] :  $tpl[item][price] ) ?></b> грн
			</div>
			<?= $tpl[add_button] ?>
		<? } else  { ?>
			<div class='unavailable'>Товар временно недоступен <i class='fa fa-frown-o fa-4x'></i></div>
		<? } ?>
		
		<br class='clearBoth'>
		
		<h4>Отзывы и комментарии:</h4>
		<div class='commentsBlock'>
			<?= $tpl[comments] ?>
			<form action='#' method='post'>
				<input type="hidden" name='item_id' value='<?= $tpl[item][id]?>'>
				<textarea name='comment' id='comment_input' placeholder='Введите ваш комментарий'></textarea> <br>
				<div class='commentAdd' style='display:none'>
					Ваше имя: <input type="text" name='name' value="<?= CComments::generateNick() ?>" placeholder="Ваше имя"> <br>					
					<input type="text" name='name_confirm' value="" placeholder="Ваше имя" class='hidden'>
				</div>
				<input type='submit' value="Добавить" class='button' name='submit_comment'>
			</form>
		</div>
		
		
	</div>
	<div class='images'>
		<?= $tpl[img_previews] ?>
		<a href='<?= format_url('images', $tpl[item]) ?>' class='all' target="_blank">
			<i class='fa fa-camera-retro fa-2x'></i> Все картинки
		</a>
	</div>
	
	<br class='clearBoth'>
	<h4 style='margin-top:100px'>Вас может заинтересовать</h4>
	<div class='similar itemsList'>
		<?= $tpl[similar] ?>
	</div>
		

</div>

