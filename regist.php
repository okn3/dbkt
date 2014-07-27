<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>投稿完了</title>

    </head>
    <body> 
        <?php
        if ($_REQUEST['name'] == '' or $_POST['message'] == '' or $_POST['genre'] == '' or $_POST['debudo'] == '') {
            exit('error');
        }

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



//画像アップロード用パスワード
        $pass = "pass";
//画像保存場所（属性を書き込み可にしておくこと）
        $dir = "images/";
        //アップロードファイル読み込み
        $data = $_FILES["photo"];
        //画像ファイルに名前を付ける
        $image_name = date('Y-m-d-His') . '.jpg';
        //画像ファイルの保存場所
        $image_path = $dir . $image_name;
        //ファイルアップロードとエラーチェック
        if (move_uploaded_file($data["tmp_name"], $image_path) === TRUE) {
;
            //画像縮小チェック
            if ($_POST['resize'] > 0) {
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
                ImageCopyResampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                //JPEG形式で保存
                ImageJPEG($new_image, $image_path, 95);
                //メモリ解放
                imagedestroy($image);
                imagedestroy($new_image);
            }

            $name = $_REQUEST['name'];
            $message = $_REQUEST['message'];
            $genre = $_REQUEST['genre'];
            $created = date('Y-m-d H:i:s');
            $tmp = $_FILES['photo'];
            $files = $tmp["name"];
            $debudo = $_REQUEST['debudo'];



//var_dump($files);

            $result = mysql_query("INSERT INTO timeline(name, message, created, genre, photo, debudo) 
                                                VALUES('$name', '$message', '$created' ,'$genre','$image_name','$debudo')", $con);
            if (!$result) {
                exit('データを登録できませんでした。');
            }

            $con = mysql_close($con);
            if (!$con) {
                exit('データベースとの接続を閉じられませんでした。');
            }
            ?>

            <!-- 画像投稿 -->
            <?php
//アップロードファイル確認


            echo "投稿完了！<br>";
            echo "<a href='" . $image_path . "' alt=''>" . $image_name . "</a><br>";
            echo '<a href="dbkt.php#timeline"><input type="button" value="戻る"></a>';
        } else {
            echo "アップロードエラー。<br>ファイル保存場所やディレクトリ書き込み属性等を確認してみてください。";
        }
        exit;
        ?>


    </body>
</html> 