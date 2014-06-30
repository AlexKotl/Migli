<?
session_start();

error_reporting(E_ALL && ~E_NOTICE);
ini_set('display_errors',1);

include "../classes/class_mysql.php";
include "../admin/functions.php";
DEFINE('AJAX_MODE',true);
$db = new CMysql();

$module = $_GET[module];
if (isset($module)) {
	$module = preg_replace("/([^a-z_])/","",$module);
	if (!file_exists("$module.php")) echo "No such module $module";
	else include "$module.php";
}

echo $sys_content;
echo $page_content;

?>