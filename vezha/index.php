<html>
<head>
	<title>"Паркова Вежа" история постройки</title>
	<link href="style.css" rel="stylesheet">
	<script src="js/jquery-2.1.0.min.js"></script>
	<script src="js/common.js"></script>
</head>
<body>

	<div class='film'>
	<?
		$period = $_GET[period];
		if ($period=='') $period = 24;
		$show_days = $_GET[show_days];
		if ($show_days=='') $show_days = 30;
		$start_hour = $_GET[srart_hour];
		if ($start_hour=='') $start_hour = 12;
		
		$n = 0;
		for ($hour=1; $hour<=$show_days * 24; $hour++) {
			$filename = "upload/".date('Y-m-d G',time() - $hour*60*60).'.jpg';
			if (file_exists($filename)) {
				$n++;
				echo "<div data-num='$n' style='display:none'><img src='$filename' onload=\"loaded_count++;\"></div>";
			}
		}
	?>
	</div>
	<div class='controls'>
		<a class='start'>Play</a>
		<!--
Интервал: <select id='interval' name='interval'>
			<option value='1'>Каждый час</option>
			<option value='3'>Каждые 3 часа</option>
			<option value='24'>Каждый день</option>
		</select>
		Период: <select id='period' name='period'>
			<option value='30'>Последний месяц</option>
		</select>
-->
		Кадр: <span id='frame'>1</span> / <?= $n ?>
	</div>

</body>
</html>