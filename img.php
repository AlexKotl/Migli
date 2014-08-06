<?
	//include "config.php";
	extract($_REQUEST);
	$filename = $file;
	error_reporting(~E_ALL);
	$max_item_prev_width = 800;
	$max_item_prev_height = 600;
	if (!isset($quality)) $quality = 80;
	$respond_code = 200;

	if (file_exists($filename)==false) {
		$filename = isset($emptyimage) ? $emptyimage : "img/no_image.jpg";
		//$respond_code = 404;
	}
	$image_src = @ImageCreateFromJpeg($filename);
	if ($image_src==false) {
		$image_src = ImageCreateFromPng($filename);
		$image_type = 'png';
	}
	list($src_width, $src_height) = getimagesize($filename);

	if (isset($_GET['width'])) $max_item_prev_width = $_GET['width'];
	if (isset($_GET['height'])) $max_item_prev_height = $_GET['height'];
	$lim_asp = $max_item_prev_width / $max_item_prev_height;
	$img_asp = $src_width / $src_height;

	// кропим изображение
	$fixed_asp = (float)$fixed_asp;
	if ($fixed_asp!=0) { //$fixed_asp = $img_asp;
		if ($img_asp > $fixed_asp) {// зашкал по ширине
			$side_crop = ($src_width - $src_height*$fixed_asp) / 2;	// кол-во пикселей для обрезки по сторонам
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

	// уменьшаем
	if (($img_asp >= $lim_asp) && ($max_item_prev_width<$src_width)) {
			 $new_width = $max_item_prev_width;
			 $new_height = $src_height * $new_width / $src_width;
			 //echo "1";
	}
	else if ($max_item_prev_height<$src_height){
		$new_height = $max_item_prev_height;
		$new_width = $src_width * $new_height / $src_height;
		//echo "2";
	}
	else { // если не надо уменьшать
			$new_height = $src_height;
			$new_width = $src_width;
			//echo "3";
	}
	$new_height = round($new_height); $new_width = round($new_width);
	//Header("Content-type: image/jpeg");
	//echo (memory_get_usage(true)/1024)."<p>";

	$image_dest = imagecreatetruecolor($new_width, $new_height);
	
	if ($image_type == 'png') {
		 if (isset($_GET['transparent'])) {
		 	imagesavealpha($image_dest, true);
		 	$trans_colour = imagecolorallocatealpha($image_dest, 0, 0, 0, 127);
		 	imagefill($image_dest, 0, 0, $trans_colour);
		 }
		 else {
		 	$img_color  = imagecolorallocate($image_dest, 255, 255, 255); // белый цвет, не прзрачный
		 	imagefilledrectangle($image_dest, 0, 0, $new_width, $new_height, $img_color);
		 }
	}

	imagecopyresampled($image_dest, $image_src, 0, 0, 0, 0, $new_width, $new_height, $src_width, $src_height);
	// если картинка большая то добавляем копирайты
	if ($new_width>400 && $new_height>300 && !isset($_GET[no_watermark])) {
		$logo_image = ImageCreateFromPNG("img/watermark.png");
		imagecopy($image_dest, $logo_image, $new_width-290, $new_height-70, 0, 0, 270, 56);
	}
	
	// делаем картинку ЧБ
	if (isset($_GET[grey])) {
		imagefilter($image_dest, IMG_FILTER_GRAYSCALE);
	}

	if ($output_type=='gif') {
		Header("Content-type: image/gif");
		ImageGif($image_dest);
	}
	elseif ($image_type == 'png') {
		Header("Content-type: image/png");
		ImagePng($image_dest); // в браузер
	}
	else {
		Header("Content-type: image/jpeg", true, $respond_code);
		ImageJpeg($image_dest,null,$quality); // в браузер
	}

	// чистим память
	imagedestroy($image_src);
	imagedestroy($image_dest);

?>