<?
if ($_SESSION[access_level]==1) {
	$content .= "
				<table class='table table-striped table-hover table-bordered'>
				<thead><tr><th>Тип</th><th>Описание</th><th>Время</th><th>IP</th></tr></thead><tbody>";
	$res = $db->query("select * from log order by timestamp desc limit 300");
	while ($row=$db->fetch($res)) {
		$content .= "<tr ".(strpos($row[timestamp],date('Y-m-d'))!==false ? "class='success'" : '').">
			<td>$row[type]</td>
			<td>$row[description]</td>
			<td>$row[timestamp]</td>
			<td>$row[ip]</td>
		  </tr>";
	}
	$content .= "</tbody></table>";
}
?>