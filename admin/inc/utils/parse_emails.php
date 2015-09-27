<?
	ini_set('display_errors', 1);
	include "../../../classes/class_mysql.php";
	include "../../../classes/class_cache.php";
	include "../../functions.php";
	include "../../config.php";
	
	$db = new CMysql();

	$res = $db->query("select * from orders where status=1");
	while ($row=$db->fetch($res)) {
		$row[description] = unserialize($row[description]);
		echo 'Email: '.$row[description][email];
		$db->insert('subscribe', array(
			'email' => $row[description][email],
			'name' => $row[description][name],
			'flag' => 1,
		));
	}
	
	echo "Done";
?>