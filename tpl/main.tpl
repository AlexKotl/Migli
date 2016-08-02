<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?= $tpl[site_title] ?></title>	
	<meta name='description' content="<?= $tpl[site_description] ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link href="/css/style.less" rel="stylesheet/less">
	<link href="/css/jquery.fancybox.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	
	<script src="/js/less-1.3.3.min.js" type="text/javascript"></script>
	<script src="/js/jquery-2.1.0.min.js" type="text/javascript"></script>
	<script src="/js/jquery.fancybox.pack.js" type="text/javascript"></script>
	<script src="/js/jquery.slides.min.js" type="text/javascript"></script>
	<script src="/js/jquery.cookie.js" type="text/javascript"></script>
	<script src="/js/scrollToTop.js" type="text/javascript"></script>
	<script src="/js/common.js" type="text/javascript"></script>
	
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600&amp;subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
	
</head>
<body>
	<div class='siteHead'>
		<a href='/'><div class='siteLogo'><b>Figli-Migli</b> <span>TOPSHOP</span></div></a>
		<div class='basket'><a href='/cart'>
			<i class="fa fa-shopping-cart fa-lg"></i> <b>Корзина</b>
			<br><?= $tpl[basket_content] ?></a>
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
			<br><br>
			<a href='/delivery'>Доставка</a> | 
			<a href='/payment'>Оплата</a> | 
			<a href='/contacts'>Контакты</a> 
		</div>
		<div class='contacts'>
			<i class="fa fa-phone fa-lg"></i> <b>Телефоны:</b>
			<br> <?= $tpl[contact_phones] ?>
			<br><a href='/callback' style='color:red; text-decoration:underline'>Обратный звонок</a>

		</div>
		<div class='contacts'>
			<i class="fa fa-home fa-lg"></i> <b>Адрес:</b>
			<br><a href='/contacts' >Шоу-рум "11. Silver Space" 
				<br><small>(м. Майдан Независимости, ул. Малая Житомирская, 9Б)</small>
			</a>
			<br>пн-вс 11:00-20:00
			<!-- <br>сб - по договоренности -->
		</div>		
		
		<br class='clearBoth'>
		
	</div>
	
	<div class="topMenu">
		<ul>
			<!-- <li><a href='/'>Новинки</a></li> -->
			<?= $tpl[menu] ?> </ul>
		</ul>
	</div>
	
	<?= $tpl[header_add] ?>
		
	<div class='mainContent'>
		

		<div class='content'>
			<? if ($tpl[sys_message]!='') {?>
				<br><br><?= strpos($tpl[sys_message],'error')!==false ? "<div class='sys_message error'>" : "<div class='sys_message'>" ?> <?= $tpl[sys_message] ?></div><p>
			<? } ?>
			
			<?= $tpl[content] ?> 
			
			
		</div>
			
		<?= $tpl[left_menu] ?>
		
		
	</div>
	
	<br class='clearBoth'>
	<div class="siteFooter">
		<div class='content'>
			<div class='copy'>Copyright &copy; <?= date('Y') ?> FIGLI-MIGLI TOPSHOP </div>
			<div class='menu'>
				<a href='/delivery'>Доставка</a> | 
				<a href='/payment'>Оплата</a> | 
				<a href='/contacts'>Контакты</a> 
			</div>
			<div class='social'>
				Мы в соц сетях
				<a class='fb' href='https://vk.com/figlimiglishop'><i class='fa fa-vk fa-2x'></i></a>
				<a class='fb' href='https://www.facebook.com/FigliMigliTopShop'><i class='fa fa-facebook fa-2x'></i></a>
				<a class='fb'><i class='fa fa-twitter fa-2x'></i></a>
				<a class='fb' href='http://instagram.com/figli_migli_topshop'><i class='fa fa-instagram fa-2x'></i></a>
				<a class='fb' href='https://plus.google.com/103126288156380874977/posts'><i class='fa fa-google-plus fa-2x'></i></a>
			</div>
			<br class='clearBoth'/>
		</div>
	</div>
	
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'T8il1xXiwy';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-9891041-8', 'auto');
  ga('send', 'pageview');
</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter25973542 = new Ya.Metrika({id:25973542,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/25973542" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<a id="back_to_top"><img src="/img/button_scroll_to_top.png" width="55" height="55" alt="Scroll to Top" /></a>

</body>
</html>