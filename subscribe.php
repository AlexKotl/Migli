<?
	if (isset($_REQUEST[submit_but])) {
		$email = $_REQUEST[email];
		if ($db->get_row("select id from subscribe where email='$email'")>0) {
			$db->query("update subscribe set flag=1 where email='$email'");
			$tpl[content] = "<br><br><div class='sys_message'>Подписка обновлена</div><p>";
		}
		elseif ($email!='') {
			$email = str_replace(array('"',"'"), '' ,$email);
			$db->insert('subscribe', array(
				'email' => $email,
				'flag' => 1,
			)) or die(mysql_error());
			$tpl[content] = "<br><br><div class='sys_message'>Подписка оформлена</div><p>";
		}
		
	}
	$sys_message = "Подписка оформлена.";
?>