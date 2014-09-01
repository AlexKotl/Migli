<?
	header('Content-type: text/xml;');
	ini_set('display_errors',1);
	error_reporting(E_ALL && ~E_NOTICE);
	include "classes/class_mysql.php";
	include "admin/config.php";
	include "admin/functions.php";
	$db = new CMysql();

	$urls = array('/');
	$site_url = "http://figli-migli.net";
	
	$res = $db->query("select *, (select name from categories where cc.parent_id=id) as parent_name from categories as cc where flag=1");
	while ($row=$db->fetch($res)) {
		$urls[] = format_url('category', $row);
	}
	
	$res = $db->query("select * from items where flag=1");
	while ($row=$db->fetch($res)) {
		$urls[] = format_url('item', $row);
		$urls[] = format_url('images', $row);
	}	
	
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<? 
	foreach ($urls as $url) {
?>
	
	 <url>
      <loc><?= "{$site_url}{$url}"; ?></loc>
   </url>

<? } ?>

</urlset>
<!-- Total links: <?= count($urls) ?> -->