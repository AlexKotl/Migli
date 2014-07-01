<h2>Ваша корзина</h2>
<?= $tpl[content] ?>

<? if (count(unserialize($tpl[items]))>0) { ?>
<h2>Сумма заказа: <?= "<span id='orderSum' data-items-sum='{$tpl[items_sum]}'>".$tpl[items_sum]."</span>" ?> грн</h2>
	<form action='' class='simpleForm'>
	<?= "<input type='hidden' name='items' value='$tpl[items]'>" ?>
	<input type="hidden" name='action' value='order'>
	<div class='orderText'>
		<p/>ДОСТАВКА: По Киеву - бесплатно (самовывоза), при заказе на сумму выше 200 грн. - бесплатно на любую станцию метро. 
		<p/>Доставка по Киеву на любую станцию метро (при заказе до 200 грн.) - 30 грн. 
		<p/>Доставка по Украине за счет покупателя по тарифам выбранной вами компании (отдаем предпочтение Новой почте). 
		<p/>ПРИ ЗАКАЗЕ ОТ 200 ГРН. И ОПЛАТЕ НА КАРТУ ПРИВАТБАНКА ДОСТАВКА ПО УКРАИНЕ НОВОЙ ПОЧТОЙ БЕСПЛАТНО.
	</div>
	<table width=500>
		<tr><td>Имя:</td><td><input type='text' name='name' value=''></td></tr>
		<tr class='confirm'><td>Еще одно имя:</td><td><input type='text' name='name_confirm' value=''></td></tr>
		<tr><td>Email:</td><td><input type='text' name='email' value=''></td></tr>
		<tr><td>Телефон:</td><td><input type='text' name='phone' value=''></td></tr>
		<tr><td>Способ доставки:</td><td>
			<label><input type="radio" name='delivery' value='self' checked="" data-type='self' data-cost='0'> Самовывоз <br><small>Киев, станция <img src='/img/icons/metro.jpeg' style="vertical-align:middle"> "Нивки"</small></label> <br>
			<label><input type="radio" name='delivery' value='subway' data-type='subway' data-cost='30'> Доставка до станции метро<br><small>доставка на любую станцию метро</small></label> <br>
			<label><input type="radio" name='delivery' value='global' data-type='global' data-cost=''> Доставка по Украине<br><small>"Новая Почта" или "Укрпочта"</small></label> <br>
		</td></tr>
		<tr class='delivery_input hidden' data-type='global'><td>Адрес доставки:</td><td><textarea style='height:60px' name='delivery_address'></textarea></td></tr>
		<tr class='delivery_input hidden' data-type='subway'><td>Метро доставки:</td><td>
			<select name='delivery_subway'>
				<option value=''>- выберите -</option>
				<option>Академгородок</option>
				<option>Арсенальная</option>
				<option>Берестейская</option>
				<option>Бориспольская</option>
				<option>Васильковская</option>
				<option>Вокзальная</option>
				<option>Выдубичи</option>
				<option>Вырлица</option>
				<option>Выставочный центр (ВДНХ)</option>
				<option>Героев Днепра</option>
				<option>Гидропарк</option>
				<option>Голосеевская</option>
				<option>Дарница</option>
				<option>Дворец спорта</option>
				<option>Дворец Украина</option>
				<option>Демеевская</option>
				<option>Днепр</option>
				<option>Дорогожичи</option>
				<option>Дружбы народов</option>
				<option>Житомирская</option>
				<option>Золотые Ворота</option>
				<option>Кловская</option>
				<option>Контрактовая площадь</option>
				<option>Красный хутор</option>
				<option>Крещатик</option>
				<option>Левобережная</option>
				<option>Лесная</option>
				<option>Лукьяновская</option>
				<option>Лыбидская</option>
				<option>Площадь Льва Толстого</option>
				<option>Майдан Незалежности</option>
				<option>Минская</option>
				<option>Нивки</option>
				<option>Оболонь</option>
				<option>Олимпийская (Республиканский стадион)</option>
				<option>Осокорки</option>
				<option>Петровка</option>
				<option>Печерская</option>
				<option>Позняки</option>
				<option>Политехнический институт</option>
				<option>Почтовая площадь</option>
				<option>Святошино</option>
				<option>Славутич</option>
				<option>Сырец</option>
				<option>Тараса Шевченко</option>
				<option>Театральная</option>
				<option>Университет</option>
				<option>Харьковская</option>
				<option>Черниговская</option>
				<option>Шулявская</option>
				<option>Теремки</option>
			</select>
		</td></tr>
		<tr><td>Ваши примечания:</td><td><textarea style='height:60px' name='notes'></textarea></td></tr>
		<tr><td></td><td><input type="submit" class='button' value='Оформить заказ' style='width:200px; font-size:12px'></td></tr>
	</table>
	</form>
<? } ?>
