<?
	$title = 'Figli-Migli topshop';
	$description = '';
	
	if ($module=='items') {
		if ($id>0) {
			$title = "Купить {$row[name]}";
		}
		else {
			//$title = "";
		}
	}
	
	$tpl[site_title] = $title;
	$tpl[description] = $description;
?>