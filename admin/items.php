<?
//$sys_message = 'test';
	if ($_SESSION[access_level]==1) {
		$id = (int)$_REQUEST[id]; 
		$content .= "<a href='?module=$module&action=add&category_id=$_GET[category_id]' class='btn btn-primary pull-right btn-small'>Добавить новый товар</a>
			<div class='page-header'>  <h3>Товар</h3></div>";
		
		// LIST VIEW
		if ($_GET[action]=='' || $_GET[action]=='write') {
			
			$content .= "
				<table class='table table-striped table-hover table-bordered'>
				<thead><tr><th>#</th><th>Картинка</th><th>Название</th><th>Цена</th><th>Акция</th><th>Доступно</th><th colspan=2></th></tr></thead><tbody>";
				
			
			$res = $db->query("select * from items where category_id='$_REQUEST[category_id]' and flag=1 ");
			while ($row=$db->fetch($res)) {
				$content .= "<tr>
					<td>$row[id]</td>
					<td><img src='/img.php?file=upload/items/$row[id]_1.jpg&width=50'></td>
				    <td>$row[name]</td>
				    <td>$row[price] грн</td>
				    <td>".($row[price_promo]>0 ? "$row[price_promo] грн" : '')."</td>
				    <td>$row[stock_count]</td>
				    <td>
				    	<a href='?module=$module&action=edit&id=$row[id]&category_id=$row[category_id]' title='Редактировать'><img src='images/basic/edit.png'></a>
				    </td><td>
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
		}
		
		// ADD ITEM
		if ($_GET[action]=='write') {
			if ($id==0) {
				if ($_REQUEST[name]=='') die('Enter name');
				$db->insert('items', array(
					'name', 'stock', 'description', 'stock_count', 'variants', 'category_id' => $_REQUEST[category_id], 'price', 'price_promo', 'flag' => 1
				)) or die(mysql_error());
				$id = $db->last_insert_id('items');
									
				$sys_message = 'Товар добавлен';
			}
			else {
				$db->update('items', $id, array(
					'name', 'stock', 'description', 'variants', 'stock_count', 'price', 'price_promo'
				)) or die(mysql_error());
				
				// fix first image
				if (!file_exists("../upload/items/$id"."_1.jpg")) {
					$n = 1;
					do { $n++; } while (!file_exists("../upload/items/$id"."_$n.jpg") && $n<=12);
					if ($n<=11) rename("../upload/items/$id"."_$n.jpg", "../upload/items/$id"."_1.jpg");
				}
				$sys_message = 'Изменения внесены';
			}
			$i = 0;
			foreach (explode('|',$_POST[files_added]) as $f) {
				if (trim($f)=='') continue;
				do {$i++;} while (file_exists("../upload/items/$id"."_$i.jpg"));
				copy("inc/fileuploader/files/$f", "../upload/items/$id"."_$i.jpg");
			}

			
		}
		
		if ($_GET[action]=='add' || $_GET[action]=='edit') {
			if ($_REQUEST[del_pic]!='')	{
				unlink("../upload/items/$id"."_$_REQUEST[del_pic].jpg");
				$sys_message .= "Картинка удалена";
			}
			if ($id>0) $row = $db->get_row("select * from items where id='$id'");
			
			for ($i=1; $i<=12; $i++) if (file_exists("../upload/items/$id"."_$i.jpg")) 
				$gallery .= "<img src='/img.php?file=upload/items/$row[id]_$i.jpg&width=100'> <a href='?module=$module&action=$_REQUEST[action]&del_pic=$i&id=$id'>[Удалить]</a><p>";
			
			$content .= "
			
			<form class='form-horizontal' action='?module=$module&action=write&category_id=$_REQUEST[category_id]&id=$id' method='post' enctype='multipart/form-data'>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Название</label>
			    <div class='controls'>
			      <input type='text' id='inputEmail' name='name' placeholder='' value='$row[name]'>
			    </div>
			  </div>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Описание</label>
			    <div class='controls'>
			      <textarea name='description' rows=10>$row[description]</textarea>
			    </div>
			  </div>
			  <div class='control-group'>
			    <label class='control-label' for='inputEmail'>Варианты<br><small>по одному на каждой строке</small></label>
			    <div class='controls'>
			      <textarea name='variants' rows=3>$row[variants]</textarea>
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