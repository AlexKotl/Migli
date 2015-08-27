<?
	function format_url($type, $data=NULL) {
		$url = '';
		if ($type=='item') {			
			$url = translit($data[name]);
			$url = preg_replace('/[^A-Za-z0-9_\-]/', '', $url);
			$url = preg_replace('/[-]+/', '-', $url);
			$url = "/details/$url-$data[id].html";
		}
		elseif ($type=='images') {			
			$url = translit($data[name]);
			$url = preg_replace('/[^A-Za-z0-9_\-]/', '', $url);
			$url = preg_replace('/[-]+/', '-', $url);
			$url = "/$data[id]/$url-pictures.html";
		}
		elseif ($type=='category') {
			$url = "/store";
			if ($data[parent_id]>0) $url .= "/".preg_replace('/[^A-Za-z0-9_\-]/', '', translit($data[parent_name]))."-$data[parent_id]";
			if ($data[id]>0) $url .= '/'.preg_replace('/[^A-Za-z0-9_\-]/', '', translit($data[name]))."-$data[id]";
		}
		elseif ($type=='tag') {
			$url = "/list";
			$url .= "/".$data;
		}
		return $url;
	}
	
	function translit($str) {
		$tr = array(
			"А"=>"A", "Б"=>"B", "В"=>"V", "Г"=>"G",
			"Д"=>"D", "Е"=>"E", "Ж"=>"J", "З"=>"Z", "И"=>"I",
			"Й"=>"Y", "К"=>"K", "Л"=>"L", "М"=>"M", "Н"=>"N",
			"О"=>"O", "П"=>"P", "Р"=>"R", "С"=>"S", "Т"=>"T",
			"У"=>"U", "Ф"=>"F", "Х"=>"H", "Ц"=>"Ts", "Ч"=>"Ch",
			"Ш"=>"Sh", "Щ"=>"Sch", "Ъ"=>"", "Ы"=>"Y", "Ь"=>"",
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
		include dirname(__FILE__)."/../tpl/$file"; 
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
	
	function add_log($type, $description='') {
		if ($description=='') $description = $type;
		CMysql::insert('log', array(
			'type' => $type,
			'description' => $description,
			'ip' => $_SERVER[REMOTE_ADDR],			
		));
	}
	
	function send_mail($to,$subject,$message) {
		mail($to, $subject, $message, "From: \"Figli-Migli topsho\" <info@figli-migli.net>");
	}
	
	// функция обрезает изображение, если задано разрешение, и уменьшает до нужных границ
	function resize_image($filename, $dest_file, $width_limit, $height_limit, $fixed_asp=0, $params=0) {
		//include_once "inc/imagecreatefrombmp.php";
		$image_src = @ImageCreateFromJpeg($filename);
		if ($image_src==false) $image_src = @imagecreatefrompng($filename);
		if ($image_src==false) $image_src = @imagecreatefromgif($filename);
		//if ($image_src==false) $image_src = ImageCreateFromBMP($filename);
		if ($image_src==false) return false;
		//$width_limit=$preview_image_width; $height_limit=$preview_image_height;
		list($src_width, $src_height) = getimagesize($filename);
		$img_asp = $src_width / $src_height;
		
		// обрезаем изображение
		if ($fixed_asp!=0) {
			if ($img_asp > $fixed_asp) {// зашкал по ширине
				$side_crop = ($src_width - $src_height*$fixed_asp) / 2;  // кол-во пикселей для обрезки по сторонам
				imagecopyresampled($image_src, $image_src, 0, 0, $side_crop, 0, $src_height*$fixed_asp, $src_height, $src_height*$fixed_asp, $src_height);
				$src_width = $src_height*$fixed_asp; // для дальнейшего использования
			}
			else {// зашкал по высоте
				$side_crop = ($src_height - $src_width / $fixed_asp) / 2;  // кол-во пикселей для обрезки сверху
				imagecopyresampled($image_src, $image_src, 0, 0, 0, $side_crop, $src_width, $src_width/$fixed_asp, $src_width, $src_width/$fixed_asp);
				$src_height = $src_width / $fixed_asp; // для дальнейшего использования
			}
			$img_asp = $src_width / $src_height;
		}
		
		// подгоняем под границы
		$img_asp = $src_width / $src_height;
		$lim_asp = $width_limit / $height_limit;
		
		if ($img_asp >= $lim_asp && $src_width>$width_limit) {       // если зашкаливает ширина
			$new_width = $width_limit;
			$new_height = $src_height * $new_width / $src_width;
		}
		else if ($img_asp < $lim_asp && $src_height>$height_limit) { // если зашкаливает высота
			$new_height = $height_limit;
			$new_width = $src_width * $new_height / $src_height;
		}
		else {                                                       // если ничего не зашкаливает
			$new_width = $src_width;
			$new_height = $src_height;
		}
		
		//if (($new_height>=$src_height || $new_width>=$src_width) && $fixed_asp==0) return false;
		
		$image_dest = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($image_dest, $image_src, 0, 0, 0, 0, $new_width, $new_height, $src_width, $src_height) or die ("Image resize failed");
		if ($params[angle]!='') $image_dest = imagerotate($image_dest, $params[angle], 0);
		$r = ImageJpeg($image_dest,$dest_file,80) or die("Cannot output image to file");
		
		// чистим память
		imagedestroy($image_src);
		imagedestroy($image_dest);
		return $r;
	}
	
?>