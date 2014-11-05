<h2>Добавить отзыв</h2>

			<form class='contactForm commonForm' action='' method='post' style='clear:both' enctype="multipart/form-data">
			<input type='hidden' name='item_id' value='-1'>
			<table>
				<tr>
					<td>Ваше имя:</td><td> <div class='formHint name'>Введите ваше имя</div> <input type='text' name='name' title='Введите ваше имя'/> </td>
				</tr>
				<tr>
					<td>Email:</td><td> 
						<div class='formHint email'>Введите ваш email</div> 
						<input type='text' name='email' title='Введите ваш email'/>  
						<input type='text' name='email_confirm' class='email_confirm'/>
					</td>
				</tr>
				<tr>
					<td class='message'>Отзыв:</td><td> <div class='formHint comment'>Введите ваше сообщение</div> <textarea name='comment' title='Введите ваше сообщение'></textarea> </td>
				</tr>
				<tr>
					<td class='message'>Фото:</td><td> <input type='file' name='UFile'> </td>
				</tr>
				<tr>
					<td></td><td style='text-align:right'> 
	                    <input type='submit' class='button' name='submit_but' value='Отправить'>
					</td>
				</tr>
			</table>
			</form>