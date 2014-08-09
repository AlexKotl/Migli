<?
	$title = 'Figli-Migli - подарки и весна всегда!';
	$description = 'Интернет магазин приятных подарков для девушек, приятные мелочи';
	
	if ($module=='items') {
		if ($id>0) {
			$title = "Купить {$row[name]} - {$row[description]}";
			$description = "{$row[description]} Магазин приятных подарков Figli-Migli";
		}
		else {
			if (isset($_REQUEST[category])) {
				$row_cat = $db->get_row("select * from categories where id='".(int)$_REQUEST[category]."'");
				$title = "$row_cat[name]. Купить $row_cat[name] на подарок. Figli-Migli topshop";
				$description = "Подарки, $row_cat[name], купить $row_cat[name]";
			}
		}
	}
	
	$tpl[site_title] = $title;
	$tpl[site_description] = $description;
?>