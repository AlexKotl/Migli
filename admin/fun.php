<?
	include("../classes/class_comments.php");
	$nick = CComments::generateNick();
	// stringToNumber($nick,23);
	echo "<div></div><div style='margin:50px auto; font-size:30px'>$nick</div> <a href=''>[обновить]</a>";
?>