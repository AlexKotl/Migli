		<div class='leftMenu'>
			<h3>Категории</h3>
			<ul>
				<?= $tpl[left_menu] ?> </ul>
			</ul>
			
			<a href='/feedback' class='button' style='margin:30px 0 10px 0; display:block'>Отзывы о нас</a>
			<? foreach ($tpl[last_feedbacks] as $row) { ?>
				<div class='feedback'> <?= str_replace("\n", "<br>", $row[comment]); ?> </div>
			<? } ?>
			<a href='/feedback'><small>Читать все отзывы</small></a>
			
			<br><br>
			<h3>Поиск по тэгам</h3>
			<div class='tagsList'>
				<?= $tpl[tags]  ?>
			</div>
			
			<form class='subscribe' action='/subscribe' method='post'>
			<div class='border'>
				<div class='icon'><i class='fa fa-envelope'></i></div>
				Подписаться на новости нашего магазина <br/>
				<input type='text' name='email' placeholder="Введите ваш email"/>
				<br/><input type='submit' name='submit_but' value='Подписаться'>
			</div>
			</form>
			
			<img src='/img/visa.jpg' style='margin:50px' alt=''>
		</div>		