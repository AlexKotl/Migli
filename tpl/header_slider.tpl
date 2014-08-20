	<div class='sliderBlock'>
		<div class='content'>
			<div class='slider'>
				<!-- <img src='/img/stuff/slider.jpg'> -->
				
				<div id="slides">
					<img src="/img/slider/1.jpg" alt=''>
					<img src="/img/slider/2.jpg" alt=''>
					<img src="/img/slider/3.jpg" alt=''>
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