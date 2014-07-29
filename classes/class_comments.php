<?
	class CComments {
		public function submit() {
			$_REQUEST[comment] = strip_tags($_REQUEST[comment]);
			if (strlen($_REQUEST[comment])<5) return false;
			$_REQUEST[name] = str_replace(array('"',"'"),'',$_REQUEST[name]);
			CMysql::insert('comments', array(
				'parent_id' => 0,
				'item_id' => $_REQUEST[item_id],
				'name' => $_REQUEST[name],
				'email' => $_REQUEST[email],
				'comment' => $_REQUEST[comment],				
				'timestamp' => time(),
				'ip' => $_SERVER[REMOTE_ADDR],
			)) or die(mysql_error());
			return true;
		}
	}
?>