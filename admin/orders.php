<?
	if ($_SESSION[access_level]==1) {
		$id = (int)$_GET[id]; 
	
		// LIST VIEW
		if ($id==0) {
			
			$content .= "
				<table class='table table-striped table-hover table-bordered'>
				<thead><tr><th>#</th><th>Имя</th><th>Телефон</th><th>Адрес доставки</th><th>Стоимость</th><th>Дата</th><th></th></tr></thead><tbody>";
				
			
			$res = $db->query("select * from orders ");
			while ($row=$db->fetch($res)) {
				$description = unserialize($row[description]);
				if ($description[delivery]=='self') $delivery = 'Самовывоз';
				elseif ($description[delivery]=='subway') $delivery = $description[delivery_subway];
				else $delivery = $description[delivery_address];
				$content .= "<tr>
					<td>$row[id]</td>
					<td>$description[name]</td>
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
				<tr><td>Имя</td><td>".$row[description][name]."</td><tr>
				<tr><td>Email</td><td>".$row[description][email]."</td><tr>
				<tr><td>Телефон</td><td>".$row[description][phone]."</td><tr>
				<tr><td>Способ доставки</td><td>".$row[description][delivery]."</td><tr>
				<tr><td>Адрес доставки</td><td>".$row[description][delivery_address]."</td><tr>
				<tr><td>Метро доставки</td><td>".$row[description][delivery_subway]."</td><tr>
				<tr><td>Заметки</td><td>".$row[description][notes]."</td><tr>
				<tr><td>Заказ</td><td>";
			foreach (unserialize($row[items]) as $item) {
				$row_item = $db->get_row("select * from items where id='$item[id]'");
				$content .= "<br><a href='/index.php?module=items&id=$row_item[id]'>{$row_item[name]} {$item[variant]}</a>";
			}
			$content .= "</td></tr></tbody></table>";
		}
	}
?>