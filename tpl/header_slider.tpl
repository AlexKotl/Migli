	<div class='sliderBlock'>
		<div class='content'>
			<div class='slider'>
				<!-- <img src='/img/stuff/slider.jpg'> -->
				
				<div id="slides">
					<!-- <a><img src="/img/slider/serejki.jpg" alt=''></a> -->
					<a><img src="/img/slider/closed.jpg" alt=''></a>
					
					<a><img src="/img/slider/delivery.jpg" alt=''></a>
					<a><img src="/img/slider/nal.jpg" alt=''></a>
					<a href='/store/Odejda-6/Hand-made-43'><img src="/img/slider/3.jpg" alt=''></a>
				</div>
				
			</div>
			<div class='menuGallery'>
				<? foreach ($tpl[menu_list] as $menu) { ?>
					<?= "<a class='item' href='".format_url('category',$menu)."'>" ?>
						<div class=''><?= $menu[name] ?></div>
						<?= "<img src='/img/categories/$menu[id].jpg' alt=''/>" ?>
					</a>
				<? } ?>
				
			</div>
			<br class='clearBoth'>
		</div>
		
	</div>