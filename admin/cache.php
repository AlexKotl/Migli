<?
	if ($_GET[action]=='edit') {
		if (isset($_REQUEST[submit_but])) {
			$db->query("update cache set value='{$_REQUEST[value]}' where type='{$_REQUEST[type]}'");
			$sys_message = "Изменения внесены.";
		}
		
		$row = $db->get_row("select * from cache where type='{$_REQUEST[type]}'");
		
		$content .= "<form action='' method='post'>
			<textarea name='value' style='width:300px' rows=5>{$row[value]}</textarea>
			<p><input type='submit' name='submit_but' value='Save' class='btn'>
		</form>";
	}
?>