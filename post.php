<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="viewport" content="width=480, user-scalable=yes">
<title>iPhone対応画像アップローダー</title>
</head>
<body>
<h1><a href="./">iPhone対応画像アップローダー</a></h1>
<?php

//画像アップロード用パスワード
$pass = "pass";
//画像保存場所（属性を書き込み可にしておくこと）
$dir = "images/";

//アップロードファイル確認

      //アップロードファイル読み込み
      $data = $_FILES["photo"];
      //画像ファイルに名前を付ける
      $image_name = date('Y-m-d-His').'.jpg';
      //画像ファイルの保存場所
      $image_path = $dir.$image_name;
      //ファイルアップロードとエラーチェック
      if( move_uploaded_file( $data["tmp_name"], $image_path ) === TRUE){;
        //画像縮小チェック
        if($_POST['resize']>0){
          //画像読み込み（JPEG,PNG,GIFなどに対応）
          $image = imagecreatefromstring(file_get_contents($image_path));
          //画像サイズ取得
          $width = ImageSX($image);
          $height = ImageSY($image);
          //出力する縮小画像のサイズ
          $new_width = $_POST['resize'];
          $new_height = $new_width / $width * $height;
          //空の画像を作成
          $new_image = ImageCreateTrueColor($new_width, $new_height);
          //リサンプリングして画像を生成
          ImageCopyResampled($new_image,$image,0,0,0,0,$new_width,$new_height,$width,$height);
          //JPEG形式で保存
          ImageJPEG($new_image, $image_path, 95);
          //メモリ解放
          imagedestroy($image);
          imagedestroy($new_image);
        }
        echo "ファイルアップロード完了！<br>";
        echo "<a href='".$image_path."' alt=''>".$image_name."</a>";
      }else{
        echo "アップロードエラー。<br>ファイル保存場所やディレクトリ書き込み属性等を確認してみてください。";
      }
 
?>
<ul><li><a href="view.php">アップロードした画像リストはこちら</a></li>
<li><a href="./">トップページに戻る</a></li></ul>
<hr>
&copy; <a href="http://zapanet.info/">ZAPAnet総合情報局</a>
</body>
</html>