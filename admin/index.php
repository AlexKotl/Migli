<?	
	ini_set('display_errors',1);
	error_reporting(E_ALL && ~E_NOTICE);
	include "../classes/class_mysql.php";
	include "functions.php";
	include "config.php";
	session_start();
	$db = new CMysql();
	
	// try to login
	if ($_REQUEST[login]!='') {
		$is_success = false;
		foreach ($user_accounts as $v) {
			if ($_REQUEST[login]==$v[login] && $_REQUEST[password]==$v[password]) {
				$_SESSION[account_login] = $_REQUEST[login];
				$_SESSION[access_level] = 1;
				$is_success = true;
				add_log('login',"Login to panel as {$_REQUEST[login]}");
			}
		}
		if (!$is_success) add_log('login',"Wrong login for {$_REQUEST[login]}, password: {$_REQUEST[password]}");
	}
	if ($_REQUEST[action]=='exit') {
		session_unset();
	}
	
	if ($_SESSION[access_level]!=1) {
		include "inc/login_form.html";
	}
	else {				
		
		$module = $_GET[module];
		include "header.php";	
		include "$module.php";
		if ($sys_message!='') echo "<div class='alert alert-".(strpos(strtolower($sys_message),'ошибка')!==false ? 'error' : 'success')."'>$sys_message</div>";
		echo $content;
		include "footer.php";
	}
?>