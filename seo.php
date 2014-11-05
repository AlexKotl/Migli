<?
	$title = 'Figli-Migli - подарки и весна всегда!';
	$description = 'Интернет магазин приятных подарков для девушек, приятные мелочи';
	$keywords = 'подарки, мелочи, девушкам, подарки для девушек, магазин, купить, для дома, очки, часы, украшения, серьги, браслеты, аксессуары, колготки с рисунком, шарфы, бабочки, канцелярия, стикеры, блокноты, чехол для телефона, органайзеры';
	
	if ($module=='items') {
		if ($id>0) {
			$title = "{$row[name]} - описание, цена, отзывы. Купить в Киеве за {$row[price]} грн";
			if (strlen($row[description])<120) $title .= " - {$row[description]}";
			$description = "{$row[description]} Магазин приятных подарков Figli-Migli. Доставка по Украине.";
		}
		else {
			if (isset($_REQUEST[category])) {
				$row_cat = $db->get_row("select * from categories where id='".(int)$_REQUEST[category]."'");
				$title = "$row_cat[name]. Купить $row_cat[name] на подарок. Figli-Migli topshop";
				$description = "Подарки, $row_cat[name], купить $row_cat[name]";
			}
			elseif (isset($_REQUEST[tag])) {
				$title = ucfirst($_REQUEST[tag]).". Купить в магазине приятных мелочей.";
				$description = ucfirst($_REQUEST[tag]).", большой выбор в интернет-магазине приятных мелочей и подарков.";
			}
		}
	}

	$row_seo = $db->get_row("select * from seo where url='".$_SERVER[REQUEST_URI]."' 
		or (item_id='".(int)$row[id]."' and item_id>0) 
		or (category_id='".(int)$_REQUEST[category]."' and category_id>0)");
	if (trim($row_seo[title])!='') $title = $row_seo[title];
	if (trim($row_seo[description])!='') $description = $row_seo[description];
	if (trim($row_seo[keywords])!='') $keywords = $row_seo[keywords];
	
	$tpl[site_title] = $title;
	$tpl[site_description] = $description;
	$tpl[site_keywords] = $keywords;
?>