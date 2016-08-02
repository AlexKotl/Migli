<div id="map-canvas" style='height:300px; width:470px; float:right; margin-right: 48px; margin-left:15px; margin-bottom:50px; border-radius:10px; margin-top:20px'></div>

<h2>Контакты</h2>



<div style='font-size:1.2em'>
<p><a href='mailto:info@figli-migli.net'>info@figli-migli.net</a>
<p>
<?= $tpl[contact_phones] ?>
<!-- <br>(093) 673 94 83 - <span style="color:#b245bd; font-weight:bolder; font-size:0.8em">Viber</span> -->
</div>
<p><b>Адрес:</b> 

<p>Киев, Шоу-рум "11. Silver Space" 
<br>м. Майдан Независимости, ул. Малая Житомирская, 9Б)</p>

<p>Киев, ул. Артема 84, оф. 22 (пн-пт, с 9:00 - 20:00)
	<br>(095) 566 48 59
	<br>(066) 255 8266
</p>

<form class='contactForm commonForm' action='/contacts' method='post' style='clear:both'>
			<table>
				<tr>
					<td>Имя:</td><td> <div class='formHint name'>Введите ваше имя</div> <input type='text' name='name' title='Введите ваше имя'/> </td>
				</tr>
				<tr>
					<td>Ваш Email:</td><td> 
						<div class='formHint email'>Введите ваш email</div> 
						<input type='text' name='email' title='Введите ваш email'/>  
						<input type='text' name='email_confirm' class='email_confirm'/>
					</td>
				</tr>
				<tr>
					<td>Тема сообщения:</td><td> <input type='text' name='subject'/> </td>
				</tr>
				<tr>
					<td class='message'>Сообщение:</td><td> <div class='formHint message'>Введите ваше сообщение</div> <textarea name='message' title='Введите ваше сообщение'></textarea> </td>
				</tr>
				<tr>
					<td></td><td style='text-align:right'> 
	                    <input type='submit' class='button' name='submit_but' value='Отправить'>
					</td>
				</tr>
			</table>
			</form>
			
<!--
<br><a href='/img/schema.jpg' class='gallery'><img src="/img/schema.jpg" alt='' style='margin:30px 0 0 0px; width:600px;'></a>
<br/><img src="/img/building.jpg" alt='' style='margin:30px 0 0 92px; width:460px;'>
-->


    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>
function initialize() {
  var myLatlng = new google.maps.LatLng(50.4586018,30.4868455);
  var centerLat = new google.maps.LatLng(50.4586018,30.4868455);
  var mapOptions = {
    zoom: 15,
    center: centerLat
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Figli-Migli TopShop'
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
