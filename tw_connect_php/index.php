<?php
 
require_once('config.php');
require_once('codebird.php');
 
session_start();
 
if (empty($_SESSION['me'])) {
    header('Location:login.php');
    exit;
}

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}
 
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ホーム画面</title>
</head>
<body>
<h1>ホーム画面</h1>
<p><?php echo h($_SESSION['me']['tw_screen_name']); ?>のTwitterアカウントでログインしています。</p>
<p><a href="logout.php">[ログアウト]</a></p> 
<ul>
<li></li>
</ul>
 
</body>
</html>