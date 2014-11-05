<?
	$tpl[content] = file_get_contents('tpl/'.$_REQUEST[page].'.tpl');
	$tpl[content] = "<div style='padding:10px 20px'>".$tpl[content].'</div>';
?>