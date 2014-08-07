<?
	$title = 'Figli-Migli topshop';
	$description = 'Интернет магазин приятных подарков для девушек';
	
	if ($module=='items') {
		if ($id>0) {
			$title = "Купить {$row[name]}";
		}
		else {
			if (isset($_REQUEST[category])) {
				$row_cat = $db->get_row("select * from categories where id='".(int)$_REQUEST[category]."'");
				$title = "Figli-Migli topshop - $row_cat[name]. Купить $row_cat[name] на подарок";
			}
		}
	}
	
	$tpl[site_title] = $title;
	$tpl[site_description] = $description;
?>