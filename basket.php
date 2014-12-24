<?
	if ($_REQUEST[action]=='order') {
		if ($_REQUEST[phone]=='' || $_REQUEST[name]=='' || $_REQUEST[email]=='') {
			$tpl[sys_message] = "Заказ не оформлен. Заполните форму для успешного оформления заказа <!-- error -->";
		}
		elseif ($_REQUEST[name_confirm]!='') mail('slicer256@gmail.com','Migli spam block','Spam blocked.');
		else {
			$description = "Имя: {$_REQUEST[surname]} {$_REQUEST[name]}
Email: {$_REQUEST[email]}
Телефон: {$_REQUEST[phone]}
Способ связи: {$_REQUEST[contact_method]}

Способ доставки: {$_REQUEST[delivery]}
К оплате: {$_REQUEST[price]}";
			if ($_REQUEST[delivery_subway]!='') $description .= "\nДоставка до метро: {$_REQUEST[delivery_subway]}";
			if ($_REQUEST[delivery_address]!='') $description .= "\nДоставка до адреса: \n{$_REQUEST[delivery_address]}";
			if ($_REQUEST[notes]!='') $description .= "\n\nПримечания: \n{$_REQUEST[notes]}";
			
			$db->insert('orders',array(
				'items' => addslashes($_REQUEST[items]),
				'description' => addslashes(serialize($_REQUEST)),
				'price' => $_REQUEST[price],
				'comments' => $_REQUEST[notes],
				'status' => 2,
				'timestamp' => time(),
			),'') or die(mysql_error());
			$order_id = $db->last_insert_id('orders');
			
			$cbasket->clearBasket();
			$cbasket->save();
			
			mailNotification('Оформлен новый заказ',$description);
			add_log('basket', "Order submitted (ID:{$order_id})");
			
			send_mail($_REQUEST[email],'Заказ оформлен',"Ваш заказ оформлен. С вами в ближайшее время свяжется менеджер.");							

			
			header("location: /cart?done&order=".$order_id);
		}
	}
	
	elseif (isset($_REQUEST[done])) {
		$row = $db->get_row("select * from orders where id='".(int)$_REQUEST[order]."'");
		
		$tpl[content] = "<h3>Спасибо. Ваш заказ на сумму {$row[price]} грн размещен</h3>
			<p>В ближайшее время наш менеджер с вами свяжется.
			<!-- <p>Вы можете оплатить ваш заказ по ссылке ниже: <p> -->";
		
		/*
include "classes/liqpay.php";
		
		$liqpay = new LiqPay('i97839051443', 'VT9XujjLgS3LW3o6CQTFtIUkgixS8mvoTZMZSHgb');
		$tpl[content] .= 
			$liqpay->cnb_form(array(
			'amount'         => $row[price],
			'currency'       => 'UAH',
			'description'    => "Оплата заказа №".$row[id]." на сумму {$row[price]} грн",
			'order_id'       => 'order_id_'.$_REQUEST[order],
			'type'           => 'buy',
			'result_url'	 => 'http://figli-migli.net/cart?complete',
			'language'		 => 'ru',
			'sandbox'		 => '1',
		));	
*/	
	}
	
	elseif (isset($_REQUEST[complete])) {
		$tpl[sys_message] .= "Ваш заказ оплачен! Менеджер магазина свяжется с вами в ближайшее время.";
		add_log('basket', "Order successfully payed");
	}
	
	else {
	
		$tpl[content] .= "<table class='simpleTable'>";
		$total_count = $total_amount = 0;
		foreach ($cbasket->getItems() as $item) {
			$row = $db->get_row("select * from items where id='".(int)$item[id]."'");		
			if ($row[price_promo]) $row[price] = $row[price_promo];
			$tpl[items_sum] += $row[price];
			$total_count += $item[count];
			$total_amount += $item[count] * $row[price];
			$tpl[content] .= "<tr>
				<td><a href='".format_url('item',$row)."'><img src='/images/$row[id].jpg?width=100'></a></td>
				<td>$row[name] ".($item[variant]!='' ? "({$item[variant]})" : '')."</td>
				<td>$row[price] грн</td>
				<td>
					<a href='/ajax/index.php?module=basket&action=change_count&id=$row[id]&value=-1'><i class='fa fa-minus-square-o'></i></a>
					<b>$item[count] </b>
					<a href='/ajax/index.php?module=basket&action=change_count&id=$row[id]&value=1'><i class='fa fa-plus-square-o'></i></a></td>
				<td><a href='/ajax/index.php?module=basket&action=delete&id=$row[id]' class='delete_from_basket' title='Удалить из корзины'><img src='/img/basic/delete.png' /></a></td>
				</tr>";
		}
		$tpl[items_sum] = $total_amount;
		$tpl[content] .= "
			<tr><td colspan='5' style='text-align:center'>Всего товаров: <b>$total_count</b>, общая стоимость: <b>$total_amount</b> грн</td></tr>
			</table>";
		$tpl[items] = serialize($cbasket->getItems());
		
		$tpl[content] = get_tpl('basket.tpl');
	
	}
	
	
?>