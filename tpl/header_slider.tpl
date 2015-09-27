	<div class='sliderBlock'>
		<div class='content'>
			<div class='slider'>
				<!-- <img src='/img/stuff/slider.jpg'> -->
				
				<div id="slides">
					<a href='/store/Odejda-6/Parnaya-odejda-59'><img src="/img/slider/para.jpg" alt=''></a>
					<a><img src="/img/slider/delivery.jpg" alt=''></a>
					<a><img src="/img/slider/nal.jpg" alt=''></a>
					<a href='/store/Odejda-6/Hand-made-43'><img src="/img/slider/3.jpg" alt=''></a>
				</div>
				
			</div>
			<div class='menuGallery'>
				<? foreach ($tpl[menu_list] as $menu) if ($menu[id]!=50) { 
					$i++;
					if ($i>9) continue;
				?>
					<?= "<a class='item' href='".($menu[id]==8 ? '/store/Ochki-8/Solntsezaschitnye-ochki-38' : format_url('category',$menu))."'>" ?>
						<div class=''><?= $menu[name] ?></div>
						<?= "<img src='/img/categories/$menu[id].jpg' alt=''/>" ?>
					</a>
				<? } ?>
				
			</div>
			<br class='clearBoth'>
		</div>
		
	</div>