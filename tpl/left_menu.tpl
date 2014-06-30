		<div class='leftMenu'>
			<h3>Категории</h3>
			<ul>
				<?= $tpl[left_menu] ?>
				<!--
<li><a href=''><i class='fa fa-plus-circle'></i> Новости</a></li>
				<li><a href=''><i class='fa fa-plus-circle'></i> Подписаться</a></li>
				<li>
					<a href='' class='active'><i class='fa fa-minus-circle'></i> Подписаться</a>
					<ul>
						<li><a href=''><i class='fa fa-angle-right'></i> Подкатегория 1</a></li>
						<li><a href=''><i class='fa fa-angle-right'></i> Еще одна</a></li>
					</ul>
				</li>
				<li><a href=''><i class='fa fa-plus-circle'></i> Подписаться</a></li>
-->
			</ul>
			
			<form class='subscribe' action='/subscribe' method='post'>
			<div class='border'>
				<div class='icon'><i class='fa fa-envelope '></i></div>
				Подписаться на новости нашего магазина <br/>
				<input type='text' name='email' placeholder="Введите ваш email"/>
				<br/><input type='submit' name='submit_but' value='Подписаться'>
			</div>
			</form>
		</div>		