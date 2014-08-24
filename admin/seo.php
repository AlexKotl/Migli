<?
if ($_SESSION[access_level]==1) {
	$id = (int)$_REQUEST[id];
	
	//if ($id>0) 
	{
		if (isset($_REQUEST[submit_but])) {
			if ($id==0) {
				$db->insert('seo', array(
					'item_id' => $_REQUEST[item_id], 'category_id'=>$_REQUEST[category_id], 'title', 'description', 'keywords', 'seo_text', 'url', 
				)) or die(mysql_error());
				$sys_message = "Запись добавлена";
			}
			else {
				$db->update('seo', $id, array(
					'item_id'=>$_REQUEST[item_id], 'category_id'=>$_REQUEST[category_id], 'title', 'description', 'keywords', 'seo_text', 'url', 
				)) or die(mysql_error());
				$sys_message = "Изменения сохранениы";
			}
			
		}
		
		$row = $db->get_row("select * from seo where true "
			.($_GET[item_id]>0 ? "and item_id='$_GET[item_id]'" : '')
			.($_GET[category_id]>0 ? "and category_id='$_GET[category_id]'" : '')
			.($_GET[id]>0 ? "and id='$_GET[id]'" : '')
		);
		$id = $row[id];
		$content .= "
			
			<form class='form-horizontal' action='?module=$module&category_id=$_REQUEST[category_id]&item_id=$_REQUEST[item_id]&id=$id' method='post' enctype='multipart/form-data'>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Title</label>
			    <div class='controls'>
			      <input type='text' name='title' placeholder='' value='$row[title]' style='width:400px'>
			    </div>
			  </div>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Description</label>
			    <div class='controls'>
			      <textarea name='description' style='width:400px'>$row[description]</textarea>
			    </div>
			  </div>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Keywords</label>
			    <div class='controls'>
			      <textarea name='keywords' style='width:400px'>$row[keywords]</textarea>
			    </div>
			  </div>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Дополнительный SEO-текст</label>
			    <div class='controls'>
			      <textarea name='seo_text' style='width:400px'>$row[seo_text]</textarea>
			    </div>
			  </div>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>URL</label>
			    <div class='controls'>
			      <input type='text' name='url' placeholder='' value='$row[url]' style='width:400px'>
			    </div>
			  </div>

					    
			  <div class='control-group'>
			    <div class='controls'>
			      <button type='submit' class='btn' name='submit_but'>Сохранить</button>
			    </div>
			  </div>
			</form>
		";


	}

}
?>