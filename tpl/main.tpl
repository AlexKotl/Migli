<!DOCTYPE html>
<html>
<head>
	<title><?= $tpl[site_title] ?></title>

	<link href="/css/style.less" rel="stylesheet/less">
	<link href="/css/jquery.fancybox.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	
	<script src="/js/less-1.3.3.min.js" type="text/javascript"></script>
	<script src="/js/jquery-2.1.0.min.js" type="text/javascript"></script>
	<script src="/js/jquery.fancybox.pack.js" type="text/javascript"></script>
	<script src="/js/jquery.slides.min.js" type="text/javascript"></script>
	<script src="/js/jquery.cookie.js" type="text/javascript"></script>
	<script src="/js/common.js" type="text/javascript"></script>
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
	
</head>
<body>
	<div class='siteHead'>
		<a href='/cart'><div class='basket'>
			<i class="fa fa-shopping-cart fa-lg"></i> <b>Корзина</b>
			<br><small><?= $tpl[basket_content] ?></small>
			<br>
			<a class='changeColor' style='background-color: #ff694c'></a>
			<a class='changeColor' style='background-color: #964991'></a>
			<a class='changeColor' style='background-color: #cd3781'></a>
			<a class='changeColor' style='background-color: #636cb2'></a>
			<a class='changeColor' style='background-color: #62af97'></a>
			<a class='changeColor' style='background-color: #558f43'></a>
			<a class='changeColor' style='background-color: #4b8e92'></a>
			<a class='changeColor' style='background-color: #d1be40'></a>
			<a class='changeColor' style='background-color: #4099d1'></a>
		</div></a>
		<div class='contacts'>
			<i class="fa fa-phone fa-lg"></i> <b>Телефоны:</b>
			<br>(093) 231 25 31 
			<br>(093) 673 94 83 
			<br>(066) 847 88 57
		</div>
		<div class='contacts'>
			<i class="fa fa-home fa-lg"></i> <b>Адрес:</b>
			<br>Киев, ул. Щербакова
			<br>пн-пт 9:00-18:00
		</div>		
		<a href='/'><div class='siteLogo'><b>Figli-Migli</b> <span>TOPSHOP</span></div></a>
		<br clear="all">
		
	</div>
	
	<div class="topMenu">
		<ul>
			<li><a href='/'>Новинки</a></li>
			<?= $tpl[menu] ?>
		</ul>
	</div>
	
	<?= $tpl[header_add] ?>
		
	<div class='mainContent'>
		

		<div class='content'>
			<? if ($tpl[sys_message]!='') {?>
				<br><br><?= strpos($tpl[sys_message],'error')!==false ? "<div class='sys_message error'>" : "<div class='sys_message'>" ?> <?= $tpl[sys_message] ?></div><p>
			<? } ?>
			<!--
			<div class='pagination'>
				<a href=''>1</a>
				<a href=''>2</a>
				<a href=''>3</a>
				...
				<a href=''>10</a>
			</div>
			-->
			
			<?= $tpl[content] ?> 
			
			
		</div>
			
		<?= $tpl[left_menu] ?>
		
		
	</div>
	
	<br clear="all">
	<div class="siteFooter">
		<div class='content'>
			<div class='copy'>Copyright &copy; <?= date('Y') ?> FIGLI-MIGLI TOPSHOP </div>
			<div class='social'>
				Мы в соц сетях
				<a class='fb' href='https://vk.com/figlimiglishop'><i class='fa fa-vk fa-2x'></i></a>
				<a class='fb'><i class='fa fa-facebook fa-2x'></i></a>
				<a class='fb'><i class='fa fa-twitter fa-2x'></i></a>
				<a class='fb' href='http://instagram.com/figli_migli_topshop'><i class='fa fa-instagram fa-2x'></i></a>
				<a class='fb'><i class='fa fa-google-plus fa-2x'></i></a>
			</div>
			<br clear="both"/>
		</div>
	</div>
	
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'T8il1xXiwy';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->

</body>
</html>