<?
	if (isset($_REQUEST[submit_but])) {
		$name = addslashes($_REQUEST[name]);
		$phone = addslashes($_REQUEST[phone]);
		if (empty($name) || empty($phone)) {
			$tpl[content] .= "<div class='sys_message error'>Введите имя и телефон.</div>";
		}
		else {
			add_log('callback',"Запрос на обратный звонок от {$name} - {$phone}");
			mailNotification('Запрос на обратный звонок',"Имя: {$name}\nТелефон: {$phone}");
			$tpl[content] .= "<div class='sys_message'>Спасибо. Наш менеджер свяжется с Вами в ближайшее время.</div>";
		}
	}
	else {
		$tpl[content] .= get_tpl('callback.tpl');
	}	
?>