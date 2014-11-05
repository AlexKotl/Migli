<?
	
	extract($_REQUEST);
	
	if (isset($_REQUEST[done])) {
		$tpl[content] .= "<div class='sys_message'>Спасибо. Ваше сообщение было отправлено.</div>";
	}
	elseif (isset($_REQUEST[submit_but])) {
		if ($email_confirm!='') {
			$tpl[content] .= "<div class='sys_message red'>Your message sent</div>";
			mail('support@figli-migli.net','Figli-Migli: spam block', "Spam blocked. Message:\n$message");
		}
		elseif ($message=='' || $name=='') {
			$tpl[content] .= "<div class='sys_message error'>Заполните все поля.</div>";
		}
		else {
			$message = "Name: $name\nEmail: $email\n\n$message\n\nIP: ".$_SERVER['REMOTE_ADDR'];
			mail("support@filgi-migli.net,info@figli-migli.net","Figli-Migli Contact Form: $subject",$message,"From: $name <$email>");
			header("location: /contacts?done");
		}		
	}
	else {

		$tpl[content] = get_tpl('contact.tpl');
	}
			
?>