<!DOCTYPE html>
<html>
<head>
	<title>Figli-Migli</title>

	<link href="/css/style.css" rel="stylesheet">
	<link href="/css/jquery.fancybox.css" rel="stylesheet">
	
	<script src="/js/jquery-2.1.0.min.js"></script>
	<script src="/js/jquery.fancybox.pack.js"></script>
	<script src="/js/common.js"></script>
	
	<link href='http://fonts.googleapis.com/css?family=Lobster&subset=cyrillic,latin' rel='stylesheet' type='text/css'>
	
</head>
<body>
	<a href='#' class='scrollerDiv'><b>Вверх</b></a>
	<div class='siteHead'>
		<a href='/cart'><div class='basket'>
			Корзина
			<br><small><?= $tpl[basket_content] ?></small>
		</div></a>
		<div class='contacts'>
			<i class='colored'>Телефоны:</i>
			<br>(093) 686-2828
			<br>(067) 587-1111
		</div>
		<div class='contacts'>
			<i class='colored'>Адрес:</i>
			<br>Киев, ул. Щербакова
			<br><i>пн-пт 9:00-18:00</i>
		</div>		
		<a href='/'><div class='siteLogo'><b>Figli-Migli</b> top shop</div></a>
	</div>	
	<br clear="all">
	
	<div class="topMenu">
		<ul>
			<li><a href='/'>Новинки</a></li>
			<?= $tpl[menu] ?>
		</ul>
	</div>
	<div class='mainContent'>
		
		<?= $tpl[content] ?> 
		<br clear="all">
	</div>
	<div class="siteFooter">
		Copyright &copy; 2014 Figli-Migli
	</div>

</body>
</html>