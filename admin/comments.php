<?
	if ($_SESSION[access_level]==1) {
		$id = (int)$_GET[id]; 
		
		$content .= "
			<a href='?module=$module&action=&flag=0' class='btn btn-warning pull-right btn-small' style='margin-left:10px'>Не подтвержденные</a> 
			<a href='?module=$module&action=&flag=1' class='btn btn-success pull-right btn-small' style='margin-left:10px'>Подтвержденные</a>
			<a href='?module=$module&action=&flag=2' class='btn btn-danger pull-right btn-small'>Удаленные</a>
			<br/><br/>";
		
		if ($_GET[action]=='flag') {
			$db->query("update comments set flag='$_GET[flag]' where id=$id") or die(mysql_error());
			$id = 0;
			$sys_message = "Комментарий изменен.";
		}
	
		// LIST VIEW
		if ($id==0 && $_GET[action]=='') {
			$content .= "
				<table class='table table-striped table-hover table-bordered'>
				<thead><tr><th>#</th><th>Товар</th><th>Имя</th><th>Комментарий</th><th>Ответ</th><th>Время</th><th colspan=3></th></tr></thead><tbody>";
				
			$res = $db->query("SELECT *, (select id from comments where cc.id=parent_id limit 1) as reply_id,
				(select name from items where id=cc.item_id) as item_name
				FROM `comments` cc where parent_id=0 && flag=".(int)$_GET[flag]) or die(mysql_error());
			while ($row=$db->fetch($res)) {
				$content .= "<tr>
					<td>$row[id]</td>
					<td><a href='/?module=items&id=$row[item_id]'><img src='/img.php?file=upload/items/$row[item_id]_1.jpg&width=50' title='$row[item_name]'></a></td>
					<td>$row[name]</td>
				    <td style='width:50%'>$row[comment]</td>
				    <td>".($row[reply_id]>0 ? "<img src='images/basic/tick.png'>" : '')."</td>
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
			if ($_REQUEST[text]!='') {
				//die('done');
				if ($_REQUEST[id]!='') $db->update('comments',$_REQUEST[id], array('comment'=>$_REQUEST[text]));
				else $db->insert('comments', array(
					'name' => 'admin',
					'item_id',
					'parent_id' => $_REQUEST[parent_id],
					'comment' => $_REQUEST[text],
					'timestamp' => time(),
					'flag' => 1,
					'ip' => $_SERVER[REMOTE_ADDR],
				)) or die(mysql_error());
				$sys_message = 'Ответ сохранен';
			}
			$row = $db->get_row("select * from comments where id='$_GET[parent_id]'");
			$row_reply = $db->get_row("select * from comments where parent_id=$row[id] limit 1");
			$content .= "
				<form action='?module=$module&action=$_REQUEST[action]&parent_id=$_GET[parent_id]&item_id=$row[item_id]&id=$row_reply[id]' method='post'>
				<div class='page-header'>  <h3>Ответить на комментарий</h3></div> 
				<h4>Коментарий</h3>
				<quote>$row[comment]</quote>
				<h4>Ваш ответ:</h3>
				<textarea name='text' style='height:100px; width:400px'>$row_reply[comment]</textarea>
				<p/><input type='submit' class='btn btn-success' value='Ответить'>
				";
			$content .= "";
			
		}
		
	}
?>