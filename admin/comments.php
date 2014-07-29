<?
	if ($_SESSION[access_level]==1) {
		$id = (int)$_GET[id]; 
		
		if ($_GET[action]=='flag') {
			$db->query("update comments set flag='$_GET[flag]' where id=$id") or die(mysql_error());
			$id = 0;
			$sys_message = "Комментарий изменен.";
		}
	
		// LIST VIEW
		if ($id==0) {
			$content .= "
				<table class='table table-striped table-hover table-bordered'>
				<thead><tr><th>#</th><th>Имя</th><th>Email</th><th>Комментарий</th><th>Время</th><th colspan=3></th></tr></thead><tbody>";
				
			
			$res = $db->query("select * from comments where flag=0");
			while ($row=$db->fetch($res)) {
				$content .= "<tr>
					<td>$row[id]</td>
					<td>$row[name]</td>
					<td>$row[email]</td>
				    <td style='width:50%'>$row[comment]</td>
				    <td>".date('Y-m-d',$row[timestamp])."</td>
				    <td><a href='?module=$module&action=flag&id=$row[id]&flag=1' title='Publish'><img src='images/basic/tick.png'></a></td>
				    <td><a href='?module=$module&action=reply&parent_id=$row[id]' title='Reply'><img src='images/basic/reply.png'></a></td>				    
				    <td><a href='?module=$module&action=flag&id=$row[id]&flag=2' title='Reject'><img src='images/basic/delete.png'></a></td>
				  </tr>";
			}
			$content .= "</tbody></table>";
		}
		
		// ORDER DETAILS
		if ($_GET[parent_id]>0 && $_GET[action]=='reply') {
			$row = $db->get_row("select * from comments where id='$_GET[parent_id]'");
			$content .= "<div class='page-header'>  <h3>Ответить на комментарий</h3></div> 
				<quote>$row[comment]</quote>
				<table class='table table-striped table-hover table-bordered'><tbody>
				<tr><td>Имя</td><td>".$row[description][name]."</td><tr>
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
				$content .= "<br><a href='/index.php?module=items&id=$row_item[id]'>{$row_item[name]} {$item[variant]} ({$row_item[price]})</a>";
			}
			$content .= "</td></tr></tbody></table>
				<a href='?module=$module&id=$id&action=flag&flag=3' class='btn btn-danger'>Отклонить заказ</a>
				<a href='?module=$module&id=$id&action=flag&flag=1' class='btn btn-success'>Заказ выполнен</a>";
			
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
				<tr><td>Сумма по товарам</td><td>".$row[price]."</td><tr>
				<tr><td>Заказ</td><td>";
			foreach (unserialize($row[items]) as $item) {
				$row_item = $db->get_row("select * from items where id='$item[id]'");
				$content .= "<br><a href='/index.php?module=items&id=$row_item[id]'>{$row_item[name]} {$item[variant]} ({$row_item[price]})</a>";
			}
			$content .= "</td></tr></tbody></table>
				<a href='?module=$module&id=$id&action=flag&flag=3' class='btn btn-danger'>Отклонить заказ</a>
				<a href='?module=$module&id=$id&action=flag&flag=1' class='btn btn-success'>Заказ выполнен</a>";
			
		}
	}
?>