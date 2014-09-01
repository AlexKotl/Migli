<?
	$id = (int)$_GET[id];
	$row = $db->get_row("select * from items where id='$id'");
	
	$site_title = "Фото - {$row[name]}";
	
	echo "<!DOCTYPE html> <html> <head>
	<title>{$site_title}</title>
	<style>
		body {margin:0; padding: 0; font-family: 'Open Sans', sans-serif; font-size: 11pt; background-color:#fff}
		h1 {font-size:1.3em; color:#2e2e2e}
		a {color:#474747; text-decoration:underlined}
		.images {width:auto; margin:auto; text-align:center}
		.images div {margin:5px}
	</style>
</head>
<body>
	<div class='images'>
	<h1>Картинки: $row[name]</h1>
	<a href='".format_url('item',$row)."'>Вернуться на страницу описания</a>
	";

	for ($i=1; $i<=20; $i++) if (file_exists("../upload/items/$row[id]_$i.jpg")) {	
		if ($i%4 == 3) $alt = "Фото {$row[name]}"; 
		elseif ($i%4 == 2) $alt = "Картинка {$row[name]}"; 
		elseif ($i%4 == 1) $alt = "{$row[name]} изображение"; 
		else $alt = "{$row[name]} - фотография"; 
		echo "<div><img src='/big_image/$row[id]/".(strpos($row[hide_watermark],",{$i},")!==false ? '0' : '')."$i/".format_filename($row[name]).".jpg' alt='$alt' title='$alt'><div>";
	}


echo "
	<a href='".format_url('item',$row)."'>Вернуться на страницу описания</a>
	</div></body></html>";
?>