<!DOCTYPE html>
<html>
<head>
	<title>Figli-Migli</title>
	
	<link href="/css/bootstrap.min.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
	
	<script src="/js/jquery-2.1.0.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/jquery.ui.widget.js"></script>
	<script src="/js/jquery.fileupload.js"></script>
	
	
	
</head>
<body>

<div class='container'>
	<div class="row">
		<div class="span12" id='header'>
			
			<div class="navbar  ">
				<div class="navbar-inner">
					<a class="brand" href="/admin">Figli-Migli - панель управления</a>
				</div>
			</div>
			
		</div>
	</div>
	
	
	<div class="row" id='content'>
		<div class="span3" style='margin-left:0'>
			
			<ul class="nav nav-list well">
				<li class="nav-header">Магазин</li>				
				<?
					$res = $db->query("select *, (select count(*) from items where category_id=categories.id and flag>0) as items_count from categories where flag=1 and parent_id=0");
					while ($row=$db->fetch($res)) {
						echo "<li><a><i class='icon-hand-right'></i> ".substr($row[name],0,32)." </a></li>";
						$res_sub = $db->query("select *, (select count(*) from items where category_id=categories.id and flag>0) as items_count from categories where flag=1 and parent_id=$row[id]");
						while ($row_sub=$db->fetch($res_sub)) {
							echo "<li class='subcat'><a href='?module=items&category_id=$row_sub[id]'>".substr($row_sub[name],0,32)." <span class='badge badge-info pull-right'>$row_sub[items_count]</span></a></li>";
						}
					}
					
				?>
				
				<li class="nav-header">Управление магазином</li>
				<li><a href="?module=categories"><i class="icon-tasks"></i> Редактор категорий</a></li>
				<? 
				$count = $db->get_row("select count(*) from orders where status=2");
				$count_comments = $db->get_row("select count(*) from comments where flag=0 and parent_id=0");
				echo "<li><a href='?module=comments'><i class='icon-shopping-cart'></i> Комментарии <span class='badge badge-important pull-right'>".($count_comments>0 ? $count_comments : '')."</span></a></li>";
				echo "<li><a href='?module=orders'><i class='icon-list-alt'></i> Список заказов <span class='badge badge-important pull-right'>".($count>0 ? $count : '')."</span></a></li>";
				echo "<li><a href='?module=subscribers'><i class='icon-envelope'></i> Подписчики <span class='badge badge-important pull-right'></span></a></li>" 
				?>
				<li><a href="?module=log"><i class="icon-eye-open"></i> История</a></li>
				<li><a href="?module=fun"><i class="icon-thumbs-up"></i> Повышатель настроения</a></li>
				<li><a href="?action=exit"><i class="icon-off"></i> Выход</a></li>
			</ul>
		</div>
		<div class="span9" style='margin-right:0'>
			
			
			
		