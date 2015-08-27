<?
	include "../../classes/class_mysql.php";
	
	include "../functions.php";
	include "../config.php";
	session_start();
	$db = new CMysql();
	
	$limit = (int)$_REQUEST[limit];
	$page = (int)$_REQUEST[page];
	
	$path = "../../upload/items";
	$res = $db->query("select * from items limit ".($page * $limit).", {$limit}");
	while ($row=$db->fetch($res)) {
		for ($i=1; $i<=15; $i++) {
			if (file_exists("$path/$row[id]_{$i}.jpg")) {
				echo "<li>Resizing $path/$row[id]_{$i}.jpg. ";
				$r = resize_image("$path/$row[id]_{$i}.jpg", "$path/$row[id]_{$i}.jpg", $settings[max_upload_width], $settings[max_upload_height]);
				if (!$r) echo "Not resized.";
			}
		}
	}
?>