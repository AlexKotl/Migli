<?
class CCache {
	function updateCache($type, $value) {
		if (CMySQL::get_row("select type from cache where type='$type'")!=false) {
			return CMySQL::query("update cache set value='$value', timestamp='".time()."' where type='$type'") or die(mysql_error());	
		}
		else {
			return CMySQL::query("insert into cache (type,value,timestamp) values (\"$type\", '$value', '".time()."')") or die(mysql_error());
		}
	}
	
	public function getCache($type) {
		return CMysql::get_row("select value from cache where type='$type' limit 1");
	}
	
	public function updateTags() {
		$tags = array();
		$res = CMySQL::query("select * from items where flag=1");
		while ($row=CMySQL::fetch($res)) {
			foreach (explode(',',$row[tags]) as $v) {
				$v = trim(mb_convert_case($v, MB_CASE_LOWER, "UTF-8"));
				if ($v=='') continue;
				$tags[$v]++;
			}
		}
		ksort($tags);
		self::updateCache('tags',serialize($tags));
	}
}
?>