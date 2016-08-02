<?
	if ($_SESSION[access_level]==1) {
		$id = (int)$_GET[id]; 
		
		$content .= "
			<a href='?module=$module&action=&status=2' class='btn btn-warning pull-right btn-small' style='margin-left:10px'>Новые</a> 
			<a href='?module=$module&action=&status=1' class='btn btn-success pull-right btn-small' style='margin-left:10px'>Выполненные</a>
			<a href='?module=$module&action=&status=3' class='btn btn-danger pull-right btn-small' style='margin-left:10px'>Отклоненные</a>
			<a href='?module=$module&action=statistics' class='btn pull-right btn-small'>Статистика</a>
			<br/><br/>";
		
		if ($_GET[action]=='flag') {
			$db->query("update orders set status='$_GET[flag]' where id=$id") or die(mysql_error());
			$id = 0;
			$sys_message = "Статус товара изменен.";
		}
	
		// LIST VIEW
		if ($id==0) {
			
			$content .= "
				<table class='table table-striped table-hover table-bordered'>
				<thead><tr><th>#</th><th>Имя</th><th>Телефон</th><th>Адрес доставки</th><th>Стоимость</th><th>Дата</th><th></th></tr></thead><tbody>";
				
			
			$res = $db->query("select * from orders where status='{$_REQUEST[status]}'");
			while ($row=$db->fetch($res)) {
				$description = unserialize($row[description]);
				if ($description[delivery]=='self') $delivery = 'Самовывоз';
				elseif ($description[delivery]=='subway') $delivery = $description[delivery_subway];
				else $delivery = $description[delivery_address];
				$content .= "<tr>
					<td>$row[id]</td>
					<td>$description[name] $description[surname]</td>
					<td>$description[phone]</td>
				    <td>$delivery</td>
				    <td>$row[price] грн</td>
				    <td>".date('Y-m-d G:i',$row[timestamp])."</td>
				    <td>
				    	<a href='?module=$module&id=$row[id]'><img src='images/basic/search.png'></a>
				    </td>
				  </tr>";
			}
			$content .= "</tbody></table>";
		}
		
		// ORDER DETAILS
		if ($id>0) {
			$row = $db->get_row("select * from orders where id='$id'");
			$row[description] = unserialize($row[description]);
			$content .= "<div class='page-header'>  <h3>Детали заказа</h3></div> 
				<table class='table table-striped table-hover table-bordered'><tbody>
				<tr><td>Имя</td><td>".$row[description][name]." ".$row[description][surname]."</td><tr>
				<tr><td>Email</td><td>".$row[description][email]."</td><tr>
				<tr><td>Телефон</td><td>".$row[description][phone]."</td><tr>
				<tr><td>Способ доставки</td><td>".$row[description][delivery]."</td><tr>
				<tr><td>Адрес доставки</td><td>".$row[description][delivery_address]."</td><tr>
				<tr><td>Метро доставки</td><td>".$row[description][delivery_subway]."</td><tr>
				<tr><td>Заметки</td><td>".$row[description][notes]."</td><tr>
				<tr><td>Сумма по товарам</td><td>".$row[price]."</td><tr>
				<tr><td>Заказ</td><td>";
			foreach (unserialize($row[items]) as $item) {
				$row_item = $db->get_row("select * from items where id='$item[id]'");
				$content .= "<br><a href='/index.php?module=items&id=$row_item[id]'>{$row_item[name]} {$item[variant]} ({$row_item[price]}) - {$item[count]} шт</a>"
					.($row_item[flag]!=1 ? " - нет в наличии" : '');
			}
			$content .= "</td></tr></tbody></table>
				<a href='?module=$module&id=$id&action=flag&flag=3' class='btn btn-danger'>Отклонить заказ</a>
				<a href='?module=$module&id=$id&action=flag&flag=1' class='btn btn-success'>Заказ выполнен</a>";
			
		}
		
		// STATISTICS
		if ($_GET[action]=='statistics') {
			$res = $db->query("SELECT sum(price) as total, FROM_UNIXTIME(timestamp,'%Y-%m') as month from orders where status=1 or status=2 group by month");
			while ($row=$db->fetch($res)) {
				$content .= "<br>$row[month]: <b>".number_format($row[total]).'</b> грн';
			}
		}
	}
?>