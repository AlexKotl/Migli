<?
	session_start();
	
	ini_set('display_errors',1);
	error_reporting(E_ALL && ~E_NOTICE);
	include "classes/class_mysql.php";
	include "classes/class_basket.php";
	include "classes/class_comments.php";
	include "classes/class_cache.php";
	include "admin/config.php";
	include "admin/functions.php";
	$db = new CMysql();
	$cbasket = new CBasket();
	$tpl = array();
		
	// create menu
	$tpl[basket_content] = ($cbasket->getItemsCount()==0 ? 'пусто' : "В корзине: <span id='basket_count'>".$cbasket->getItemsCount()."</span>");
	$cur_parent = 0; $is_submenu_opened = false;
	$res = $db->query("SELECT c1.id as parent_id, c1.name as parent_name, c2.id as id, c2.name as name FROM categories c1
		left join categories c2 on c2.parent_id = c1.id
		where c1.parent_id=0");
	while ($row=$db->fetch($res)) {
		if ($cur_parent!=$row[parent_id] && $is_submenu_opened) {
			$tpl[menu] .= "</ul></li>\n";
			$tpl[left_menu] .= "</ul>\n";
			$is_submenu_opened = false;
		}
		
		if ($row[id]==NULL) {
			$tpl[menu] .= "<li><a href='".format_url('category',$row)."'>$row[parent_name]</a></li>\n";
			$tpl[left_menu] .= "<li><a href=''><i class='fa fa-plus-circle'></i> $row[parent_name]</a></li>";
		}
		elseif ($cur_parent!=$row[parent_id]) { // begin new submenu
			$row_base = $row; $row_base[id] = NULL;
			$tpl[menu] .= "<li><a href='".format_url('category',$row_base)."'>$row[parent_name]</a> 
				<ul style='display:none'>
				<li><a href='".format_url('category',$row)."'>$row[name]</a></li>\n";
			$tpl[left_menu] .= "<li><a href='".format_url('category',$row_base)."' class='active'><i class='fa fa-minus-circle'></i> $row[parent_name]</a> 
				<ul>
				<li><a href='".format_url('category',$row)."'><i class='fa fa-angle-right'></i> $row[name]</a></li>\n";
			$cur_parent = $row[parent_id];
			$is_submenu_opened = true;
		}
		else {
			$tpl[menu] .= "<li><a href='".format_url('category',$row)."'>$row[name]</a></li>\n";
			$tpl[left_menu] .= "<li><a href='".format_url('category',$row)."'><i class='fa fa-angle-right'></i> $row[name]</a></li>\n";
		}

	}
	
	// format tags
	$tags = unserialize(CCache::getCache('tags'));
	$max = max($tags);
	foreach ($tags as $k => $v) {
		$pos = round($v / $max* 5);
		$tpl[tags] .= "<a href='".format_url('tag',$k)."' class='size{$pos}' title='{$k} - {$v}'>".mb_convert_case($k, MB_CASE_TITLE, "UTF-8")."</a>";
	}
	
	$tpl[left_menu] = get_tpl('left_menu.tpl');
	
	// include module
	$module = preg_replace('/([^a-z])/','',$_GET[module]);
	if ($module=='') $module = 'items';
	
	include "{$module}.php";
	include "seo.php";	
	include 'tpl/main.tpl';
?>