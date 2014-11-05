<?
	extract($_REQUEST);
	
	if (isset($_REQUEST[submit_but])) {
		if ($email_confirm!='') {
			$tpl[content] .= "<div class='sys_message red'>Your message sent</div>";
			mail('support@figli-migli.net','Figli-Migli: spam block', "Spam blocked. Message:\n$comment");
		}
		elseif ($comment=='') {
			$tpl[content] .= "<div class='sys_message error'>Заполните поле отзыва.</div>";
		}
		else {
			CComments::submit();
			$id = $db->last_insert_id('comments'); 
			//print_r($_FILES); die;
			if ($_FILES[UFile][name]!="") {
				copy($_FILES[UFile][tmp_name],"upload/feedback/$id.jpg") or die("Error during copying file");
			}
			//mail("support@filgi-migli.net,info@figli-migli.net","Figli-Migli new feedback",$comment);
			header("location: /feedback?done");
		}		
	}
	
	if (isset($_REQUEST[done])) {
			$tpl[content] .= "<div class='sys_message'>Спасибо. Ваш отзыв был добавлен.</div>";
	}
	
	if ($_GET[action]=='add') {
		
		$tpl[content] .= get_tpl('feedback_add.tpl');
	}
	
	else {
		$tpl[content] .= "<h2>Отзывы о нас</h2> 
			<a class='button' href='/feedback/add'>Написать отзыв</a> <br class='clearBoth'><br><br>
			<div class='commentsBlock'>";
		$res_comment = $db->query("select *, (select comment from comments where cc.id=parent_id limit 1) as reply_text from comments cc where parent_id=0 and item_id='-1' and flag=1 order by id desc");
		while ($row_comment=$db->fetch($res_comment)) {
			$row_comment[comment] = str_replace("\n", '<br>', $row_comment[comment]);
			$row_comment[reply_text] = str_replace("\n", '<br>', $row_comment[reply_text]);
			$nickname = $row_comment[name];
			$tpl[content] .= "<div class='comment'>
				<div class='header'><div class='avatara a".CComments::stringToNumber($nickname,24)." c".CComments::stringToNumber($nickname,9)."'></div> ".$nickname." <div class='date'>".date('d.m.Y',$row_comment[timestamp])."</div></div>
				<div class='content' style='width:97%'>$row_comment[comment]</div>
				</div>";
			if ($row_comment[reply_text]!='') $tpl[content] .= "
				<div class='comment reply'>
					<div class='header'><div class='avatara a".CComments::stringToNumber('admin',24)." c".CComments::stringToNumber('admin',9)."'></div> Figli-Migli <div class='date'></div></div>
					<div class='content' style='width:97%'>$row_comment[reply_text]</div>
				</div>";
		}
		$tpl[content] .= "</div>";
	}
?>