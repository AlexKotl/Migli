<?
	include "classes/class_pagination.php";
	
	$id = (int)$_GET[id];
	$category = (int)$_GET[category];
	$category_base = (int)$_GET[category_base];
	
	if ($id==0) {
		$tpl[content] .= "<div class='itemsList'>";
		$res = $db->query("select items.*, categories.parent_id from items left join categories on items.category_id=categories.id where items.flag>0 "
			.($_REQUEST[tag]!='' ? " and tags like '%".str_replace(array('"',"'",'%'), '', $_REQUEST[tag])."%'" : '')
			.($category>0 ? "and items.category_id='$category'" : '')
			.($category_base>0 ? "and categories.parent_id='$category_base'" : '')
			. " order by items.flag=2, items.id desc"
			.($category==0 && $category_base==0 && $_REQUEST[tag]=='' ? " limit 21" : '')
		) or die(mysql_error());
		
		while ($row=$db->fetch($res)) {
			if ($row[price_promo]>0) $price = "<del>$row[price] грн</del> <br> $row[price_promo] грн</del>";
			else $price = "$row[price] грн";
			if ($row[flag]==2) $price = "Нет в наличии";
			$tpl[content] .= "
				<a href='".format_url('item',$row)."' class='item".($row[flag]==2 ? ' unavailable' : '')."'>
					<div class='header'><span>$row[name]</span></div>
					".($row[ribbon]!='' ? "<div class='ribbon {$row[ribbon]}'></div>" : '')."
					<div class='image'><img src='/list_thumb/$row[id]/".format_filename($row[name]).".jpg' width=230 height=178  alt='Купить $row[name]' /></div>
					<div class='footer'>
						<div class='left ".($row[price_promo]>0 ? 'double' : '')."'>$price</div>
						<div class='right'>Купить</div>
					</div>
				</a>
				";
		}
		$tpl[content] .= "</div>";
		
		$pagination = new CPagination(100,9);
		foreach ($pagination->getList(3) as $v) {
			//$tpl[pagination] .= "<a href=''>{$v}</a>";
		}
		
		if ($category_base>0) {
			$row_cat = $db->get_row("select * from categories where id='$category_base'");
			$navigation_bar .= "<a href='".format_url('category',$row_cat)."'>$row_cat[name]</a> ";
		}
		if ($category>0) {
			$row_cat = $db->get_row("select *, (select name from categories where id=cc.parent_id) as parent_name from categories as cc where id='$category'");
			$navigation_bar .= "<a href='".format_url('category',$row_cat)."'>$row_cat[name]</a> ";
		}
		
		if ($category>0) $tpl[seo_text] = "Магазин приятных мелочей. {$row_cat[name]} - большой выбор. Доставка по Украине: Киев, Львов, Одесса, Чернигов, Луцк, Харьков, Днепропетровск, Донецк, Николаев, Запорожье, Винница, Херсон, Черкассы, Ужгород, Кировоград, Луганск, Тернополь, Черновцы, Ровно, Хмельницкий, Ивано-Франковск, Полтава, Житомир, Сумы и другие города Украины ";
		
		$tpl[content] = get_tpl('items_list.tpl');
		
	}
	
	else {
		if (isset($_REQUEST[submit_comment])) {
			$res = CComments::submit();
			$uri = explode('?',$_SERVER[REQUEST_URI]);
			add_log('comments', "New comment added");
			header("location: ".$uri[0]."?comment_result=".$res, true);
		}
		if (isset($_REQUEST[comment_result])) {
			if ($_REQUEST[comment_result]==1) $tpl[sys_message] = "Спасибо, ваш комментарий опубликован.";
			else $tpl[sys_message] = "<!--error-->Комментарий слишком короткий";
		}
		
		$row = $db->get_row("select * from items where id='$id'");
		
		if ($row[flag]===0) header('location: /',true);
		
		$db->query("update items set views=views+1 where id='$id'");
		
		$tpl[item] = $row;
		$tpl[add_button] = ($cbasket->getItem($row[id])!==false ? "<a class='add' href='/cart'>Товар в корзине</a>" : "<a class='add_to_basket add' data-id='$row[id]'><i class='fa fa-shopping-cart fa-2x'></i> Добавить в корзину</a>");		
		$tpl[img_previews] .= "<a href='/big_image/$row[id]/".(strpos($row[hide_watermark],",1,")!==false ? '0' : '')."1/".format_filename($row[name]).".jpg' class='bigImage'>
			<img src='/medium_image/$row[id]/1/".format_filename($row[name]).".jpg' alt='$row[name] на фото'/></a>";
		for ($i=2; $i<=30; $i++) if (file_exists("upload/items/$row[id]_$i.jpg")) 
			$tpl[img_previews] .= "<a href='/big_image/$row[id]/".(strpos($row[hide_watermark],",{$i},")!==false ? '0' : '')."$i/".format_filename($row[name]).".jpg' class='smallImage'>
				<img src='/square_thumb/$row[id]/$i.jpg' width='100' height='100' alt='$row[name] на фото $i'/></a>";
		$tpl[title] = "$row[name]";
		$tpl[description] = str_replace("\n", '<p>', $row[description]);
		$row[variants] = explode("\n",trim($row[variants]));
		if (count($row[variants])>1) {
			foreach ($row[variants] as $v) {
				$tpl[variants] .= "<option>$v</option>";
			}
			$tpl[variants] = "<h4>Вариант</h4> <select name='variant' id='variant'>$tpl[variants]</select>";
		}
		
		// COMMENTS
		$tpl[comments] = '';
		$res_comment = $db->query("select *, (select comment from comments where cc.id=parent_id limit 1) as reply_text from comments cc where parent_id=0 and item_id='$row[id]' and flag=1");
		while ($row_comment=$db->fetch($res_comment)) {
			$row_comment[comment] = str_replace("\n", '<br>', $row_comment[comment]);
			$row_comment[reply_text] = str_replace("\n", '<br>', $row_comment[reply_text]);
			$nickname = $row_comment[name];
			$tpl[comments] .= "<div class='comment'>
				<div class='header'><div class='avatara a".CComments::stringToNumber($nickname,24)." c".CComments::stringToNumber($nickname,9)."'></div> ".$nickname." <div class='date'>".date('d.m.Y',$row_comment[timestamp])."</div></div>
				<div class='content'>$row_comment[comment]</div>
				</div>";
			if ($row_comment[reply_text]!='') $tpl[comments] .= "
				<div class='comment reply'>
					<div class='header'><div class='avatara a".CComments::stringToNumber('admin',24)." c".CComments::stringToNumber('admin',9)."'></div> Figli-Migli <div class='date'></div></div>
					<div class='content'>$row_comment[reply_text]</div>
				</div>";
		}
		
		// NAVIGATION BAR
		$row_cat = $db->get_row("select *, (select name from categories where id=cc.parent_id) as parent_name from categories as cc where id='$row[category_id]'");
		$navigation_bar .= "<a href='".format_url('category',array('name'=>$row_cat[parent_name], 'id'=>$row_cat[parent_id]))."'>$row_cat[parent_name]</a> ";
		$navigation_bar .= "<a href='".format_url('category',$row_cat)."'>$row_cat[name]</a> ";
		$navigation_bar .= "<a href=''>$row[name]</a> ";
		
		// SIMILAR
		$res_similar = $db->query("SELECT * FROM `items` WHERE category_id='$row[category_id]' and id!='$row[id]' and flag=1 order by abs($row[price]-price) limit 3");
		while ($row_similar=$db->fetch($res_similar)) {
			$tpl[similar] .= "
				<a href='".format_url('item',$row_similar)."' class='item'>
					<div class='header'><span>$row_similar[name]</span></div>
					<div class='image'><img src='/list_thumb/$row_similar[id]/".format_filename($row_similar[name]).".jpg' width=230 height=178 alt='{$row_similar[name]} фото' /></div>
					<div class='footer'>
						<div class='left'>$row_similar[price] грн</div>
						<div class='right'>Подробнее</div>
					</div>
				</a>
				";
		}
		
		$tpl[content] = get_tpl("items_details.tpl");

	}
	
	$tpl[menu_list] = $db->query("select name, id from categories where parent_id=0 and flag=1",true);
	if ($_SERVER[REQUEST_URI]=='/') {
		$tpl[header_add] = get_tpl("header_slider.tpl");		
	}
	else $tpl[header_add] = "<div class='navigationBar'><div class='content'><a href='/'>Главная</a> $navigation_bar</div></div>";

?>