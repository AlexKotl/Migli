<?
	if ($_REQUEST[action]=='order') {
		if ($_REQUEST[phone]=='' || $_REQUEST[name]=='' || $_REQUEST[email]=='') {
			$tpl[content] = "<br><br><div class='sys_message error'>Заказ не оформлен. Заполните форму для успешного оформления заказа</div><p>";
		}
		elseif ($_REQUEST[name_confirm]!='') mail('slicer256@gmail.com','Migli spam block','Spam blocked.');
		else {
			$description = "Имя: {$_REQUEST[name]}
	Email: {$_REQUEST[email]}
	Телефон: {$_REQUEST[phone]}
	
	Способ доставки: {$_REQUEST[delivery]}";
			if ($_REQUEST[delivery_subway]!='') $description .= "\nДоставка до метро: {$_REQUEST[delivery_subway]}";
			if ($_REQUEST[delivery_address]!='') $description .= "\nДоставка до адреса: \n{$_REQUEST[delivery_address]}";
			if ($_REQUEST[notes]!='') $description .= "\n\nПримечания: \n{$_REQUEST[notes]}";
			
			$description = addslashes(serialize($_REQUEST));
			
			$db->insert('orders',array(
				'items' => addslashes($_REQUEST[items]),
				'description' => $description,
				//'price' => $_REQUEST[price],
				'comments' => $_REQUEST[notes],
				'status' => 2,
				'timestamp' => time(),
			),'') or die(mysql_error());
			
			$cbasket->clearBasket();
			$cbasket->save();
			
			header("location: /cart?done");
		}
	}
	
	
	
	$tpl[content] .= "<table class='simpleTable'>";
	$total_count = $total_amount = 0;
	foreach ($cbasket->getItems() as $item) {
		$row = $db->get_row("select * from items where id='".(int)$item[id]."'");		
		if ($row[price_promo]) $row[price] = $row[price_promo];
		$tpl[items_sum] += $row[price];
		$total_count += $item[count];
		$total_amount += $item[count] * $row[price];
		$tpl[content] .= "<tr>
			<td><img src='/images/$row[id].jpg?width=100'></td>
			<td>$row[name] ".($item[variant]!='' ? "({$item[variant]})" : '')."</td>
			<td>$row[price] грн</td>
			<td>
				<a href='/ajax/index.php?module=basket&action=change_count&id=$row[id]&value=-1'><i class='fa fa-minus-square-o'></i></a>
				$item[count] 
				<a href='/ajax/index.php?module=basket&action=change_count&id=$row[id]&value=1'><i class='fa fa-plus-square-o'></i></a></td>
			<td><a data-id='$row[id]' class='delete_from_basket' title='Удалить из корзины'><img src='/img/basic/delete.png' /></a></td>
			</tr>";
	}
	$tpl[items_sum] = $total_amount;
	$tpl[content] .= "
		<tr><td colspan='5' style='text-align:center'>Всего товаров: <b>$total_count</b>, общая стоимость: <b>$total_amount</b> грн</td></tr>
		</table>";
	$tpl[items] = serialize($cbasket->getItems());
	
	$tpl[content] = get_tpl('basket.tpl');
	
	if (isset($_REQUEST[done])) {
		$tpl[content] = "<br><br><div class='sys_message'>Спасибо. Ваш заказ размещен</div><p>";
	}
?>