<?
	$max_pictures = 30;

	if ($_SESSION[access_level]==1) {
		$id = (int)$_REQUEST[id]; 
		$content .= "
			<a href='?module=$module&action=add&category_id=$_GET[category_id]' class='btn btn-primary pull-right btn-small' style='margin-left:10px'>Добавить новый товар</a>
			<a href='?module=$module&category_id=$_GET[category_id]&flag=2' class='btn btn-warning pull-right btn-small'>Корзина</a>
			<div class='page-header'>  <h3>Товар</h3></div>";
		
		// FLAG ITEM
		if ($_GET[action]=='flag') {
			$db->query("update items set flag='{$_GET[val]}' where id='$id'") or die(mysql_error());
			$sys_message = "Изменения сохранены";
			add_log('items',"Item flagged as {$_GET[val]} (ID:{$id})");
		}
		
		// LIST VIEW
		if ($_GET[action]=='' || $_GET[action]=='write' || $_GET[action]=='flag') {
			
			$content .= "
				<table class='table table-striped table-hover table-bordered'>
				<thead><tr><th>#</th><th>Картинка</th><th style='width1:30%'>Название</th><th>Тэги</th><th>Цена</th><th>Акция</th><th>Нал</th><th>Пр</th><th colspan=4></th></tr></thead><tbody>";
				
			
			$res = $db->query("select * from items where category_id='$_REQUEST[category_id]' and ".($_GET[flag]===0 ? "flag=0 " : "(flag=2 or flag=1)")) or die(mysql_error());
			while ($row=$db->fetch($res)) {
				if (strlen($row[tags])>50) $row[tags] = mb_substr($row[tags], 0,50,'utf-8').'...';
				$content .= "<tr ".($row[flag]==2 ? "class='error'" : '').">
					<td>$row[id]</td>
					<td><img src='/img.php?file=upload/items/$row[id]_1.jpg&width=50'></td>
				    <td><a href='/?id=$row[id]'>$row[name]</a></td>
				    <td><small>$row[tags]</small></td>
				    <td>$row[price] грн</td>
				    <td>".($row[price_promo]>0 ? "$row[price_promo] грн" : '')."</td>
				    <td>$row[stock_count]</td>
				    <td>$row[views]</td>
				    <td>
				    	<a href='?module=seo&action=edit&item_id=$row[id]' title='Редактировать SEO'><img src='images/basic/globe.png'></a>
				    </td><td>
				    	<a href='?module=$module&action=edit&id=$row[id]&category_id=$row[category_id]' title='Редактировать'><img src='images/basic/edit.png'></a>
				    </td>
				    <td>
				    	<a href='?module=$module&action=flag&id=$row[id]&val=".($row[flag]==2 ? 1 : 2)."&category_id=$row[category_id]' title='".($row[flag]==2 ? "Товар появился" : "Отметить как нет в наличии")."' ><img src='images/basic/warning.png'></a>
				    </td>
				    <td>
				    	<a href='?module=$module&action=delete&id=$row[id]' title='Удалить' onclick=\"return confirm('Удалить?');\"><img src='images/basic/block.png'></a>
				    </td>
				  </tr>";
			}
			$content .= "</tbody></table>";
		}
		
		// DELETE ITEM
		if ($_GET[action]=='delete') {
			$db->query("update items set flag=0 where id='$id'");
			$sys_message = "Товар удален в корзину";
			add_log('items',"Item removed to bin (ID:{$id})");
		}
		
		// ADD ITEM
		if ($_GET[action]=='write') {
			$hide_watermark = ','.implode(',',array_keys($_REQUEST[hide_watermark])).',';
			if ($_REQUEST[name]=='' || $_REQUEST[description]=='') die('Enter name');
			
			if ($id==0) {				
				$_REQUEST[tags] = mb_convert_case($_REQUEST[tags], MB_CASE_LOWER, "UTF-8");
				$db->insert('items', array(
					'name', 'stock', 'description', 'stock_count', 'variants', 
					'name_ua', 'description_ua', 'variants_ua',
					'category_id' => $_REQUEST[item_cat], 'price', 'price_promo', 
					'flag' => 1, 'hide_watermark' => $hide_watermark, 'ribbon', 'tags',
				)) or die(mysql_error());
				$id = $db->last_insert_id('items');
									
				$sys_message = 'Товар добавлен';
				add_log('items',"Item added (ID:{$id})");
			}
			else {
				$db->update('items', $id, array(
					'name', 'stock', 'description', 'variants', 'name_ua', 'description_ua', 'variants_ua', 'stock_count', 'price', 'price_promo', 'hide_watermark' => $hide_watermark, 'ribbon', 'tags', 'category_id' => $_REQUEST[item_cat]
				)) or die(mysql_error());
				
				// fix first image
				if (!file_exists("../upload/items/$id"."_1.jpg")) {
					$n = 1;
					do { $n++; } while (!file_exists("../upload/items/$id"."_$n.jpg") && $n<=12);
					if ($n<=11) rename("../upload/items/$id"."_$n.jpg", "../upload/items/$id"."_1.jpg");
				}
				$sys_message = 'Изменения внесены';
				add_log('items',"Item updated (ID:{$id})");
			}
			$i = 0;
			foreach (explode('|',$_POST[files_added]) as $f) {
				if (trim($f)=='') continue;
				do {$i++;} while (file_exists("../upload/items/$id"."_$i.jpg"));
				//copy("inc/fileuploader/files/$f", "../upload/items/$id"."_$i.jpg");
				resize_image("inc/fileuploader/files/$f", "../upload/items/$id"."_$i.jpg", $settings[max_upload_width], $settings[max_upload_height]) or die("Cannor resize inc/fileuploader/files/$f -> ../upload/items/$id"."_$i.jpg $settings[max_upload_width] $settings[max_upload_height]");
			}
			
			CCache::updateTags();

			
		}
		
		if ($_GET[action]=='add' || $_GET[action]=='edit') {
			if ((int)$_REQUEST[category_id]==0) die('Категория не указана');
			if ($_REQUEST[del_pic]!='')	{
				unlink("../upload/items/$id"."_$_REQUEST[del_pic].jpg");
				$sys_message .= "Картинка удалена";
			}
			if ($_GET[make_main]!='') {
				$path = '../upload/items/'.$_GET[id].'_';
				$num = (int)$_GET[make_main];
				@rename("{$path}1.jpg", "{$path}1tmp.jpg");
				@rename("{$path}{$num}.jpg", "{$path}1.jpg");
				@rename("{$path}1tmp.jpg", "{$path}{$num}.jpg");
				$sys_message = "Порядок картинок изменен";
			}
			if ($id>0) $row = $db->get_row("select * from items where id='$id'");
			
			for ($i=1; $i<=$max_pictures; $i++) if (file_exists("../upload/items/$id"."_$i.jpg")) 
				$gallery .= "<img src='/img.php?file=upload/items/$row[id]_$i.jpg&width=100'> 
					<a href='?module=$module&action=$_REQUEST[action]&del_pic=$i&id=$id&category_id=$_REQUEST[category_id]'>[Удалить]</a> 
					<a href='?module=$module&action=$_REQUEST[action]&make_main=$i&id=$id&category_id=$_REQUEST[category_id]'>[Сделать главной]</a>
					<label style='margin-left:30px; display:inline'><input type='checkbox' name='hide_watermark[$i]' ".(strpos($row[hide_watermark],",{$i},")!==false ? 'checked' : '')."> Не накладывать лого</label>
					<p>";
			
			// categories list
			$res_cat = $db->query("select *, (select name from categories where c1.parent_id=id) as parent_name from categories as c1 where flag=1 and parent_id>0 order by parent_id, name");
			while ($row_cat=$db->fetch($res_cat)) {
				if ($prev_parent!=$row_cat[parent_name]) {
					$categories_select .= "</optgroup><optgroup label='{$row_cat[parent_name]}'>";
					$prev_parent = $row_cat[parent_name];
				}
				$categories_select .= "<option value='{$row_cat[id]}' ".($row[category_id]==$row_cat[id] || ($row[category_id]=='' && $_REQUEST[category_id]==$row_cat[id]) ? 'selected' : '').">{$row_cat[name]}</option>";
			}
			
			$content .= "
			
			<form class='form-horizontal' action='?module=$module&action=write&category_id=$_REQUEST[category_id]&id=$id' method='post' enctype='multipart/form-data'>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Название</label>
			    <div class='controls'>
			      <input type='text' id='inputEmail' name='name' placeholder='Название' value='$row[name]'>
			      <input type='text' id='inputEmail' name='name_ua' placeholder='Назва' value='$row[name_ua]'>
			    </div>
			  </div>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Описание</label>
			    <div class='controls'>
			      <textarea name='description' rows=10 placeholder='Описание'>$row[description]</textarea>
			      <textarea name='description_ua' rows=10 placeholder='Опис'>$row[description_ua]</textarea>
			    </div>
			  </div>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Варианты<br><small>по одному на каждой строке</small></label>
			    <div class='controls'>
			      <textarea name='variants' rows=3 placeholder='Варианты'>$row[variants]</textarea>
			      <textarea name='variants_ua' rows=3 placeholder='Варіанти'>$row[variants_ua]</textarea>
			    </div>
			  </div>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Цена (грн)</label>
			    <div class='controls'>
			      <div class='input-prepend input-append'><span class='add-on'>₴</span><input type='text' id='inputEmail' name='price' placeholder='' value='$row[price]' style='width:180px'></div>
			    </div>
			  </div>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Акционная цена</label>
			    <div class='controls'>
			      <div class='input-prepend input-append'><span class='add-on'>₴</span><input type='text' id='inputEmail' name='price_promo' placeholder='' value='$row[price_promo]' style='width:180px'></div>
			    </div>
			  </div>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Ленточка</label>
			    <div class='controls'>
			      <select name='ribbon'>
			      	<option value=''>нет</option>
			      	<option value='handmade' ".($row[ribbon]=='handmade' ? 'selected' : '').">Handmade</option>
			      	<option value='discount' ".($row[ribbon]=='discount' ? 'selected' : '').">Скидка</option>
			      	<option value='new' ".($row[ribbon]=='new' ? 'selected' : '').">Новинка</option>
			      	<option value='popular' ".($row[ribbon]=='popular' ? 'selected' : '').">Популярное</option>
			      </select>
			    </div>
			  </div>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Тэги</label>
			    <div class='controls'>
			      <input type='text' id='inputEmail' name='tags' placeholder='' value='$row[tags]'>
			    </div>
			  </div>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Категория</label>
			    <div class='controls'>
			      <select name='item_cat'>{$categories_select}</select>
			    </div>
			  </div>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Код товара</label>
			    <div class='controls'>
			      <input type='text' id='inputEmail' name='stock' placeholder='' value='$row[stock]'>
			    </div>
			  </div>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Доступно на складе</label>
			    <div class='controls'>
			      <input type='number' id='inputEmail' name='stock_count' placeholder='' min=0>
			    </div>
			  </div>
			  
			  $gallery 
			 
			   <span class='btn btn-success fileinput-button'>
		        <i class='glyphicon glyphicon-plus'></i>
		        <span>Выберите фотографии</span>
		        <input id='fileupload' type='file' name='files[]' multiple>
		    </span>
		    <input type='hidden' id='files_added' name='files_added' />
		    <br>
		    <br>
		    <div id='progress' class='progress'>
		        <div class='progress-bar progress-bar-success'></div>
		    </div>
		    <div id='files' class='files'></div>
		    
			  <div class='control-group'>
			    <div class='controls'>
			      <button type='submit' class='btn'>".($id>0 ? "Изменить" : "Добавить")."</button>
			    </div>
			  </div>
			</form>
			
			<script>
				$(function() {
					$('#fileupload').fileupload({
				        url: 'inc/fileuploader/',
				        dataType: 'json',
				        done: function (e, data) {
				            $.each(data.result.files, function (index, file) {
				                $('<p> <img src=\'inc/fileuploader/files/thumbnail/' + file.name + '\' >').appendTo('#files');
				                $('#files_added').val($('#files_added').val() + '|' + file.name);
				            });
				        },
				        progressall: function (e, data) {
				            var progress = parseInt(data.loaded / data.total * 100, 10);
				            $('#progress .progress-bar').css(
				                'width',
				                progress + '%'
				            );
				        }
				    })
				});
			</script>";
		}
	}
?>