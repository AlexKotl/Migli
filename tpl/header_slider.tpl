	<div class='sliderBlock'>
		<div class='content'>
			<div class='slider'>
				<!-- <img src='/img/stuff/slider.jpg'> -->
				
				<div id="slides">
					<img src="/img/slider/1.jpg">
					<img src="/img/slider/2.jpg">
					<img src="/img/slider/3.jpg">
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
		</div>
		<br clear="all">
	</div>