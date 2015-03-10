<?
	include "../classes/class_mail.php";
	
	if ($_SESSION[access_level]==1) {
		$id = (int)$_REQUEST[id]; 
		$content .= "
			<a href='?module=$module&action=routing' class='btn btn-primary pull-right btn-small' style='margin-left:10px'>Добавить рассылку</a>
			<a href='?module=$module' class='btn btn-warning pull-right btn-small'>Список подписчиков</a>
			<div class='page-header'>  <h3>Подписчики</h3></div>
			";
		
		if ($_GET[action]=='flag') {
			$db->query("update subscribe set flag='$_GET[flag]' where id=$id") or die(mysql_error());
			$id = 0;
			$sys_message = "Подписчик изменен.";
		}
		
		// LIST VIEW
		if ($_GET[action]=='' || $_GET[action]=='write') {
			
			$content .= "
				<table class='table table-striped table-hover table-bordered'>
				<thead><tr><th>#</th><th>Email</th><th colspan=2></th></tr></thead><tbody>";
				
			
			$res = $db->query("select * from subscribe order by id desc ");
			while ($row=$db->fetch($res)) {
				$content .= "<tr ".($row[flag]==2 ? "class='error'" : '').">
					<td>$row[id]</td>
				    <td>$row[email]</td>
				    <td>
				    	<a href='?module=$module&action=edit&id=$row[id]&category_id=$row[category_id]' title='Редактировать'><img src='images/basic/edit.png'></a>
				    </td><td>
				    	<a href='?module=$module&action=flag&id=$row[id]&flag=".($row[flag]==1 ? '2' : '1')."' title='Заблокировать' onclick=\"return confirm('Заблокировать?');\"><img src='images/basic/block.png'></a>
				    </td>
				  </tr>";
			}
			$content .= "</tbody></table>";
		}
		
		// ROUTING FORM
		if ($_GET[action]=='routing') {
			if (isset($_REQUEST[preview_but])) {
				$tpl[mail_content] = $_REQUEST[mail_content];
				$tpl[mail_content] = str_replace("\n", '<br>', $tpl[mail_content]);
				$tpl[mail_title] = $_REQUEST[title];
				$content = get_tpl("../admin/inc/mail_blank.html");
			}
			elseif (isset($_REQUEST[submit_but])) {
				
				$tpl[mail_content] = $_REQUEST[mail_content];
				$tpl[mail_content] = str_replace("\n", '<br>', $tpl[mail_content]);
				$tpl[mail_title] = $_REQUEST[title];
				$message = get_tpl("../admin/inc/mail_blank.html");
				
				$res = $db->query("select * from subscribe where flag=1 and email like '%slicer%' order by id desc ");
				while ($row=$db->fetch($res)) {
					$cmail = new CMail('html');
					$cmail->to = $row[email];
					$cmail->subject = $_REQUEST[title];
					$cmail->message = $message;
					$cmail->send();
	
					$sys_message .= "Отправлено на email: $row[email]<br>";
				}
				$sys_message .= "<p>Рассылка выполнена";
			}
			else {
				$content .= "<form class='form-horizontal' action='?module=$module&action=routing' method='post' enctype='multipart/form-data'>
				  <div class='control-group'>
				    <label class='control-label' for='inputEmail'>Заголовок</label>
				    <div class='controls'>
				      <input type='text' id='inputEmail' name='title' placeholder='' value='$row[name]'>
				    </div>
				  </div>
				  <div class='control-group'>
				    <label class='control-label' for='inputEmail'>Содеражние</label>
				    <div class='controls'>
				      <textarea name='mail_content' style='height:300px' placeholder='Можно использовать HTML: <b>жирный</b>, <i>курсив</i>, <u>подчеркнутый</u>'></textarea>
				    </div>
				  </div>
				  <div class='control-group'>
				    <div class='controls'>
				      <button type='submit' name='preview_but' class='btn'>Предпросмотр</button> 
				      <button type='submit' name='submit_but' class='btn btn-primary'>Разослать</button>
				    </div>
				  </div>
				 </form>";
			}
		}
	}

?>