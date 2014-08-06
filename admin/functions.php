<?
	function format_url($type, $data=NULL) {
		$url = '';
		if ($type=='item') {			
			$url = translit($data[name]);
			$url = preg_replace('/[^A-Za-z0-9_\-]/', '', $url);
			$url = "/details/$url-$data[id].html";
		}
		elseif ($type=='category') {
			$url = "/store/".preg_replace('/[^A-Za-z0-9_\-]/', '', translit($data[name]))."-$data[id]";
			if ($data[parent_id]>0) $url .= "/".preg_replace('/[^A-Za-z0-9_\-]/', '', translit($data[parent_name]))."-$data[parent_id]";
		}
		return $url;
	}
	
	function translit($str) {
		$tr = array(
			"А"=>"A", "Б"=>"B", "В"=>"V", "Г"=>"G",
			"Д"=>"D", "Е"=>"E", "Ж"=>"J", "З"=>"Z", "И"=>"I",
			"Й"=>"Y", "К"=>"K", "Л"=>"L", "М"=>"M", "Н"=>"N",
			"О"=>"O", "П"=>"P", "Р"=>"R", "С"=>"S", "Т"=>"T",
			"У"=>"U", "Ф"=>"F", "Х"=>"H", "Ц"=>"TS", "Ч"=>"CH",
			"Ш"=>"SH", "Щ"=>"SCH", "Ъ"=>"", "Ы"=>"Y", "Ь"=>"",
			"Э"=>"E", "Ю"=>"YU", "Я"=>"YA", "а"=>"a", "б"=>"b",
			"в"=>"v", "г"=>"g", "д"=>"d", "е"=>"e", "ж"=>"j",
			"з"=>"z", "и"=>"i", "й"=>"y", "к"=>"k", "л"=>"l",
			"м"=>"m", "н"=>"n", "о"=>"o", "п"=>"p", "р"=>"r",
			"с"=>"s", "т"=>"t", "у"=>"u", "ф"=>"f", "х"=>"h",
			"ц"=>"ts", "ч"=>"ch", "ш"=>"sh", "щ"=>"sch", "ъ"=>"y",
			"ы"=>"y", "ь"=>"", "э"=>"e", "ю"=>"yu", "я"=>"ya",
			"І"=>"I", "Ї"=>"I", "ї"=>"i", "і"=>"i",
			" "=> "-", "."=> "", "/"=> "_"
		);
		return strtr($str,$tr);
	}
	
	function format_filename($str) {
		$str = translit(trim($str));
		$str = str_replace(' ','-', $str);
		$str = preg_replace("/[^a-zA-Z0-9\-]/", '', $str);
		return $str;
	}
	
	function get_tpl($file) {
		global $tpl;
		ob_start();
		include "tpl/$file";
		return ob_get_clean();
	}
	
	function mailNotification($subj,$content='') {
		global $notifications_email;
		if ($content=='') {
			$content = $subj;
			$subj = 'Some notification';
		}
		return mail($notifications_email, "Figli-Migli уведомление: {$subj}", $content);
	}
	
?>