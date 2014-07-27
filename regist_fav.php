<?php


 $con = mysql_connect('mysql001.phy.lolipop.lan', 'LAA0382103', '55dbkt');
 if (!$con) {
   exit('データベースに接続できませんでした。');
 }

$result = mysql_select_db('LAA0382103-dbkt', $con);
if (!$result) {
  exit('データベースを選択できませんでした。');
}

$result = mysql_query('SET NAMES utf8', $con);
if (!$result) {
  exit('文字コードを指定できませんでした。');
}

$no = $_REQUEST['no'];

$tmp_count = $_REQUEST['count'];
$count = $tmp_count +1;



var_dump($no);
var_dump($count);



$result = mysql_query("UPDATE timeline(count) SET VALUES('$count') WHERE no = $no", $con);



if (!$result) {
  exit('データを登録できませんでした。');
}

$con = mysql_close($con);
if (!$con) {
  exit('データベースとの接続を閉じられませんでした。');
}

?>
<?php
header("Location: http://okn-ryo.lolipop.jp/dbkt/dbkt.php#timeline");

exit;
?>