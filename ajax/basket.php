<?
	include("../classes/class_basket.php");
	$cbasket = new CBasket();
	if ($_REQUEST[action]=='add') {
		$cbasket->addItem(array(
			'id' => $_REQUEST[id],
			'variant' => $_REQUEST[variant],
			'count' => 1,
		));
		$cbasket->save();
		echo "<i class='fa fa-smile-o fa-4x'></i>";
		add_log('basket', "Item (ID:$_REQUEST[id]) added to cart");
	}
	
	if ($_REQUEST[action]=='delete') {
		$cbasket->removeItem($_REQUEST[id]);
		$cbasket->save();
		header("location: /cart");
	}
	
	if ($_REQUEST[action]=='change_count') {
		//$cbasket->removeItem($_REQUEST[id]);
		$item = $cbasket->getItem($_GET[id]);
		$item[count] += (int)$_REQUEST[value];
		if ($item[count]<1) $item[count] = 1;
		$cbasket->updateItem($_GET[id], $item);
		$cbasket->save();
		header("location: /cart");
	}
?>