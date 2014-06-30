<?
	$source = "http://parkova-vezha.com.ua/stream3.php";
	$filename = "upload/".date('Y-m-d G').'.jpg';
	if (!file_exists($filename)) file_put_contents($filename, file_get_contents($source));
	else echo "File already exists. ";
	echo "Done.";
?>