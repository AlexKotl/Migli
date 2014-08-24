<?
if ($_SESSION[access_level]==1) {
	$id = (int)$_REQUEST[id];
	
	if ($_GET[action]=='write') {
		if ($_REQUEST[name]=='') die('Enter name');
		if ($id==0) $db->insert('categories',array(
			'name'=>$_REQUEST[name], 
			'parent_id'=>$_REQUEST[parent_id],
			'flag' => 1,			
		));
		else $db->query("update categories set name='$_REQUEST[name]' where id='$id'");
		$sys_message = "Изменения сохранены";
	}
	if ($_GET[action]=='block') {
		$db->query("update categories set flag='2' where id='$id'");
		$sys_message = "Изменения сохранены";
	}
	
	if ($_GET[action]=='' || $_GET[action]=='write' || $_GET[action]=='block') {
		$content .= "
			<table class='table table-hover table-bordered'>
			<thead><tr><th>#</th><th>Название</th><th>Продуктов</th><th colspan=3></th></tr></thead><tbody>";
		
		$res = $db->query("select *, (select count(*) from items where category_id=categories.id and flag=1) as items_count from categories where parent_id=0 and flag=1");
		while ($row=$db->fetch($res)) {
			$content .= "<tr class='strong'>
				<td>$row[id]</td>
			    <td>$row[name]</td>
			    <td>$row[items_count]</td>
			    <td><a href='?module=seo&category_id=$row[id]' title='SEO'><img src='images/basic/globe.png'></a></td>
			    <td><a href='?module=$module&action=edit&id=$row[id]' title='Редактировать'><img src='images/basic/edit.png'></a></td>
			    <td><a href='?module=$module&action=block&id=$row[id]' title='Заблокировать'><img src='images/basic/block.png'></a></td>
			    <td><a href='?module=$module&action=add&parent_id=$row[id]' title='Добавить подгатегорию'><img src='images/basic/plus.png'></a></td>
			    </td>
			  </tr>";
			$res_sub = $db->query("select *, (select count(*) from items where category_id=categories.id and flag=1) as items_count from categories where parent_id=$row[id] and flag=1");
			while ($row_sub=$db->fetch($res_sub)) {
				$content .= "<tr>
					<td>$row_sub[id]</td>
				    <td>⇢ $row_sub[name]</td>
				    <td>$row_sub[items_count]</td>
				   	<td><a href='?module=seo&category_id=$row_sub[id]' title='SEO'><img src='images/basic/globe.png'></a></td>
				    <td><a href='?module=$module&action=edit&id=$row_sub[id]' title='Редактировать'><img src='images/basic/edit.png'></a></td>
					<td><a href='?module=$module&action=edit&id=$row_sub[id]' title='Заблокировать'><img src='images/basic/block.png'></a>				    </td>
					<td></td>
				  </tr>";
			}
		}
		$content .= "</tbody></table>";
	}
	
	elseif ($_GET[action]=='edit' || $_GET[action]=='add') {
		$row = $db->get_row("select * from categories where id='$id'");
		$content .= "<form class='form-horizontal' action='?module=$module&action=write&id=$_GET[id]&parent_id=$_GET[parent_id]' method='post' enctype='multipart/form-data'>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Название</label>
			    <div class='controls'>
			      <input type='text' id='inputEmail' name='name' placeholder='' value='$row[name]'>
			    </div>
			  </div>
			  		    
			  <div class='control-group'>
			    <div class='controls'>
			      <button type='submit' class='btn'>Сохранить</button>
			    </div>
			  </div>
			</form>
";
	}
		
}
?>