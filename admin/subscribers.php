<?
	if ($_SESSION[access_level]==1) {
		$id = (int)$_REQUEST[id]; 
		$content .= "<div class='page-header'>  <h3>Подписчики</h3></div>";
		
		// LIST VIEW
		if ($_GET[action]=='' || $_GET[action]=='write') {
			
			$content .= "
				<table class='table table-striped table-hover table-bordered'>
				<thead><tr><th>#</th><th>Email</th><th colspan=2></th></tr></thead><tbody>";
				
			
			$res = $db->query("select * from subscribe order by id desc ");
			while ($row=$db->fetch($res)) {
				$content .= "<tr>
					<td>$row[id]</td>
				    <td>$row[email]</td>
				    <td>
				    	<a href='?module=$module&action=edit&id=$row[id]&category_id=$row[category_id]' title='Редактировать'><img src='images/basic/edit.png'></a>
				    </td><td>
				    	<a href='?module=$module&action=delete&id=$row[id]' title='Удалить' onclick=\"return confirm('Удалить?');\"><img src='images/basic/block.png'></a>
				    </td>
				  </tr>";
			}
			$content .= "</tbody></table>";
		}
		
	}

?>