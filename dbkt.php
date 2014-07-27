<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8" />
        <title>私のデブ活</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- ローカルのJQM -->
        <script type="text/javascript" src="js/jquery-2.0.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.mobile-1.3.1.min.css" />
        <script type="text/javascript" src="js/jquery.mobile-1.3.1.min.js"></script>
        <!--アイコンの指定 -->
        <link rel="apple-touch-icon" href="icon.jpg">
        <!-- ファビコン -->
        <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="favicon.ico" />
        <!-- アイコンアドオン -->
        <link rel="stylesheet" type="text/css" href="css/jquery.mobile-1.3.1.min.css" />
        <!-- ブックマークバブルの設置 -->
        <script src="js/bookmark_bubble.js"></script>
        <script src="js/example.js"></script>



        <style>
            .full{
                margin: -15px -15px 0;
            }
        </style>




        <!--ログイン画面-->
    <div data-role="page" id="login" >


        <div data-role="header" data-position="fixed">

            <h2>私のデブ活</h2>
        </div>

        <div data-role="content">


            <div id="img" class="full">
                <img src="/dbkt/dbkt_top.jpg" width="100%" height="100%">
            </div> 

            <!--<a href="./tw_connect_php/login.php" data-role="button" data-inline="true" data-theme="b">ログイン</a>-->
            <a href="http://okn-ryo.lolipop.jp/dbkt/tw_connect_php/login.php" data-role="button" data-inline="true" data-theme="b">ログイン</a>
           
           
            
  　    <a href="#timeline" data-role="button" data-inline="true">今すぐ利用</a>


        </div>

    </div>





    <!--タイムラインのページ-->

    <div data-role="page" id="timeline" >



        <div data-role="header" data-position="fixed">

            <a></a>

            <h1>みんなのデブ活</h1>

            <a href="#submit" data-rel="dialog" data-transition="slidedown" data-icon="edit" data-iconpos="left" data-theme="b">投稿する</a>

        </div>

        <div data-role="content" data-theme="a"> 


            <!-- tweetボタン -->
            <a href="https://twitter.com/intent/tweet?button_hashtag=でぶ活&text=でぶ活についてつぶやこう" class="twitter-hashtag-button" data-lang="en" data-related="jasoncosta">Tweet #debukatsu</a>
            <script>!function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "https://platform.twitter.com/widgets.js";
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, "script", "twitter-wjs");
            </script>

            
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


            $result = mysql_query('SELECT * FROM timeline ORDER BY no DESC LIMIT 15', $con);
            while ($data = mysql_fetch_array($result)) {
                echo "<p>\n";

      
                echo '<strong>[' . $data['no'] . '] ' . htmlspecialchars($data['name'], ENT_QUOTES) . "</strong>\n";
                echo "<a>" . $data['created'] . "</a>";
                echo "<br />\n";
                echo "<br />\n";
                echo '<strong>デブ活指数：<font color="yellow">';
                echo nl2br(htmlspecialchars($data['debudo'], ENT_QUOTES));
                echo '</font></strong><br>';
                echo '<strong>デブ活P：';
                echo '<a id="counter">0</a>';
                echo '</strong>ポイント';
                echo "<br />\n";
                echo '<img src="images/' . $data['photo'] . '"height="50%" width="50%" >';
                echo '<a href="regist_fav.php" data-role="button" data-inline="true" data-theme="a" data-icon="star">おデブね♪</a>';
                echo "<br />\n";
                echo nl2br(htmlspecialchars($data['message'], ENT_QUOTES));
                echo "<br />\n";
                echo "</p>\n";
                echo '<hr color="gray">';
            }

            $con = mysql_close($con);
            if (!$con) {
                exit('データベースとの接続を閉じられませんでした。');
            }
            ?>

        </div> <!-- content -->

        <div data-role="footer" data-position="fixed"> 
            <div data-role="navbar" data-iconpos="left">
                <ul>
                    <li><a href="" data-icon="check" data-theme="b">HOME</a></li>
                    <li><a href="#twitter" data-transition="slide" data-icon="star">Twitter</a></li>
                    <li><a href="#pop" data-transition="slide" data-icon="grid">アルバム</a></li>
                </ul>
            </div>
        </div>
    </div> <!-- timeline -->



    <!--投稿ページ-->

    <div data-role="page" id="submit">

        <div data-role="header" data-position="fixed">
            <a href="" data-rel="back">キャンセル</a>


            <h2>投稿！でぶ活</h2>
        </div>


        <div data-role="content">

            <form action="regist.php" enctype="multipart/form-data" method="post" data-ajax="false" data-role="fieldcontain">

                <input type="file" name="photo" value="" accept="image/*; capture=camera">
 
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup" data-mini=“true” data-type="horizontal">
                        <legend>ジャンル</legend>
                        <input type="radio" name="genre" value="外食" id="out" checked="checked" />
                        <label for="out">外食</label>
                        <input type="radio" name="genre" value="家" id="in" />
                        <label for="in">家</label>
                    </fieldset>
                </div>


                <div data-role="fieldcontain"> 

                    <label for="debudo">デブ度</label>
                    <select name="debudo" id="debudo" data-native-menu="false">
                        <option value="">自己評価する</option><!-- プレースホルダー -->
                        <option name="debudo" value="★★★★★">★★★★★ MAXデブ</option>
                        <option value="★★★★">★★★★  でぶデブ</option>
                        <option value="★★★">★★★   デブ</option>
                        <option value="★★">★★    ぷちデブ</option>
                        <option value="★">★     ダイエット?</option>
                    </select>
                    </select>
                </div>


                <div data-role="fieldcontain">

                    名前：<input type="text" name="name" value=""/></br>
                    <br>
                    <label for="message">デブ活の説明：</label>
                    <textarea name="message"></textarea>
                </div>
                <input type="submit" value="投稿" data-theme="b" data-icon="check" data-inline="true">


            </form>

        </div>


    </div>  


    <!--でぶ活イッターを見る-->


    <div data-role="page" id="twitter" data-theme="a" >

        <div data-role="header" data-position="fixed">
            <a href="" data-rel="back">戻る</a>
            <h1>でぶ活イッター</h1>
            <a href="#submit" data-transition="slidedown" data-icon="edit" data-iconpos="left" data-theme="b">投稿する</a>
        </div>

        <div data-role="navbar">
            <ul>
                <li><a href="" class="ui-btn-active">公式ツイート</a></li>
                <li><a href="#twitter_search">デブ活検索</a></li>
            </ul>
        </div><!-- /navbar -->

        <div data-role="content" data-theme="a">

            <!-- フォローボタン設置 -->
            <a href="https://twitter.com/55dbkt" class="twitter-follow-button" data-show-count="false" data-lang="en" data-size="large">Follow @55dbkt</a>
            <script>!function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//platform.twitter.com/widgets.js";
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, "script", "twitter-wjs");
            </script>


<?php
//1.でダウンロードしたtwitteroauth.phpをinclude
require_once('./twitteroauth.php');

//2.3.で取得した各キーを入力
$consumer_key = 'BWhTnNlAm8aVOGniFeT11g';
$consumer_secret = 'UsugxghaQTc9j5IeQmqltx2ZSatPEk42y6bMjYivA';
$access_token = '1529476261-AtRxVKMRalD9sfgxnQVo3VIiLF6De6d2xLBnsu4';
$access_token_secret = '91ImURWvXVdXh1tual1vX3WCJ8SttchddFuk3TjmQ';

// OAuthオブジェクト生成
$to = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);

// user_timelineの取得。TwitterからXML形式が返ってくる
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/user_timeline.json", "GET", array("q" => "dari_zakki", "count" => "30"));

// Twitterから返されたJSONをデコードする
$results = json_decode($req);


echo '<ul>';
foreach ($results as $value) {
    echo '<li>';
    echo date("m-d H:i", strtotime($value->created_at));
    echo '<strong>' . $value->user->name . '</strong>';
    echo '<br>';
    echo '<img src="' . $value->user->profile_image_url . '" /><br />';
    echo $my_text = $value->text . '<br />';

    $my_url = strstr($my_text, 'http://');
    if (!empty($my_url)) {

        //写真をリンクで表示
        echo '<a href="' . $bit_url . '">画像を見る</a>';
    }
    echo '<hr>';
    echo '</li>';
}
echo '</ul>';
?>



        </div>


        <div data-role="footer" data-position="fixed"> 
            <div data-role="navbar" data-iconpos="left">
                <ul>
                    <li><a href="#timeline" data-transition="slide" data-direction="reverse" data-icon="home">HOME</a></li>
                    <li><a href="" data-icon="check" data-theme="b">Twitter</a></li>
                    <li><a href="#pop" data-transition="slide" data-icon="grid">あるばむ</a></li>
                </ul>
            </div>
        </div>
    </div>



    <!--でぶ活イッター(キーワード検索)を見る-->


    <div data-role="page" id="twitter_search" data-theme="a" >

        <div data-role="header" data-position="fixed">
            <a href="" data-rel="back">戻る</a>
            <h1>でぶ活イッター</h1>
            <a href="#submit" data-transition="slidedown" data-icon="edit" data-iconpos="left" data-theme="b">投稿する</a>
        </div>

        <div data-role="navbar">
            <ul>
                <li><a href="#twitter">公式ツイート</a></li>
                <li><a href="" class="ui-btn-active" >デブ活検索</a></li>
            </ul>
        </div><!-- /navbar -->

        <div data-role="content">
            <a href="https://twitter.com/intent/tweet?button_hashtag=でぶ活&text=でぶ活についてつぶやこう" class="twitter-hashtag-button" data-lang="en" data-related="jasoncosta">Tweet #debukatsu</a>
            <script>!function(d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (!d.getElementById(id)) {
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "https://platform.twitter.com/widgets.js";
                        fjs.parentNode.insertBefore(js, fjs);
                    }
                }(document, "script", "twitter-wjs");
            </script>


            <!-- 検索結果表示 -->
<?php
//GitHubからダウンロード
require_once('./twitteroauth.php');

//Twitterで検索するワード
$key = "デブ活 OR でぶ活 AND http://";
//オプション設定
$options = array('q' => $key, 'count' => '30', 'lang' => 'ja');

//twitterAppsで取得
$consumerKey = 'BWhTnNlAm8aVOGniFeT11g';
$consumerSecret = 'UsugxghaQTc9j5IeQmqltx2ZSatPEk42y6bMjYivA';
$accessToken = '1529476261-AtRxVKMRalD9sfgxnQVo3VIiLF6De6d2xLBnsu4';
$accessTokenSecret = '91ImURWvXVdXh1tual1vX3WCJ8SttchddFuk3TjmQ';

$twObj = new TwitterOAuth(
        $consumerKey, $consumerSecret, $accessToken, $accessTokenSecret
);
$json = $twObj->OAuthRequest(
        'https://api.twitter.com/1.1/search/tweets.json', 'GET', $options
);
$jset = json_decode($json, true);

//エラーが出ないように
$tmpHtml = "";
echo '<ul>';

foreach ($jset['statuses'] as $result) {
    echo '<li>';

    $result['id'];

    //ユーザーネーム（一件しか取得されない）
    echo $name = $result['in_reply_to_screen_name'] . '<br>';

    //プロフィール画像表示
    $link = $result['user']['profile_image_url'];
    echo '<img src="' . $link . '"height="10%" width="10%" >';

    $updated = $result['created_at'];
    $jptime = strtotime($updated);
    $timestamp = $jptime + 9 * 60 * 60;

    echo date("m-d H:i", $timestamp) . '<br>';
    echo $text = $result['text'];
    echo '<br>';

    // URL検出

    $bit_url = strstr($text, 'http://');
    if (!empty($bit_url)) {

        //写真をリンクで表示
        echo '<a href="' . $bit_url . '">画像を見る</a>';


    }

    echo "<hr>";
    echo '</li>';
}
echo "</ul>";
?>


        </div>


        <div data-role="footer" data-position="fixed"> 
            <div data-role="navbar" data-iconpos="left">
                <ul>

                    <li><a href="#timeline" data-transition="slide" data-direction="reverse" data-icon="home">HOME</a></li>
                    <li><a href="" data-icon="check" data-theme="b">Twitter</a></li>
                    <li><a href="#pop" data-transition="slide" data-icon="grid">あるばむ</a></li>
                </ul>
            </div>
        </div>
    </div>



    <!--アルバム１-->


    <div data-role="page" id="pop" data-theme="a">


        <div data-role="header" data-position="fixed">
            <a href="" data-rel="back">戻る</a>
            <h1>Gallery</h1>
            <a href="#submit" data-transition="slidedown" data-icon="edit" data-iconpos="left" data-theme="b">投稿する</a>

            <div data-role="navbar">
                <ul>
                    <li><a href="#pop" class="ui-btn-active">人気</a></li>
                    <li><a href="#new">新着</a></li>
                    <li><a href="#rand">ランダム</a></li>
                </ul>
            </div><!-- /navbar -->
        </div>



        <div data-role="content">

<?php
$dir = 'images/';

//ディレクトリ内のファイルを新しい順に取り出す
$filelist = scandir($dir, 1);

//表示する
$cnt = 0;

foreach ($filelist as $file) {
    if (!is_dir($file)) {
        echo '<li><img src="' . $dir . $file . '" alt="' . $file . '" title="' . $file . '"width="100%" height="100%"></li>';

        $cnt++;
    }
    if ($cnt >= 10) {
        break;
    }
}
?>

        </div><!-- content -->


        <div data-role="footer" data-position="fixed"> 
            <div data-role="navbar" data-iconpos="left">
                <ul>
                    <li><a href="#timeline" data-transition="slide" data-direction="reverse" data-icon="home" >HOME</a></li>
                    <li><a href="#twitter" data-transition="slide" data-direction="reverse" data-icon="star">Twitter</a></li>
                    <li><a href="" data-icon="check" data-transition="slide" data-theme="b">album</a></li>
                </ul>
            </div>
        </div>
    </div><!-- page -->



    <!-- アルバム２ -->

    <div data-role="page" id="new" data-theme="a">


        <div data-role="header" data-position="fixed">
            <a href="" data-rel="back">戻る</a>
            <h1>Gallery</h1>
            <a href="#submit" data-transition="slidedown" data-icon="edit" data-iconpos="left" data-theme="b">投稿する</a>

            <div data-role="navbar">
                <ul>
                    <li><a href="#pop">人気</a></li>
                    <li><a href="#new" class="ui-btn-active">新着</a></li>
                    <li><a href="#rand">ランダム</a></li>
                </ul>
            </div><!-- /navbar -->
        </div>



        <div data-role="content">

        </div><!-- content -->


        <div data-role="footer" data-position="fixed"> 
            <div data-role="navbar" data-iconpos="left">
                <ul>
                    <li><a href="#timeline" data-transition="slide" data-direction="reverse" data-icon="home" >HOME</a></li>
                    <li><a href="#twitter" data-transition="slide" data-direction="reverse" data-icon="star">Twitter</a></li>
                    <li><a href="" data-icon="check" data-transition="slide" data-theme="b">album</a></li>
                </ul>
            </div>
        </div>
    </div><!-- page -->


    <!-- アルバム３ -->
    <div data-role="page" id="rand" data-theme="a">


        <div data-role="header" data-position="fixed">
            <a href="" data-rel="back">戻る</a>
            <h1>Gallery</h1>
            <a href="#submit" data-transition="slidedown" data-icon="edit" data-iconpos="left" data-theme="b">投稿する</a>

            <div data-role="navbar">
                <ul>
                    <li><a href="#pop" >人気</a></li>
                    <li><a href="#new">新着</a></li>
                    <li><a href="#rand" class="ui-btn-active">ランダム</a></li>
                </ul>
            </div><!-- /navbar -->
        </div>



        <div data-role="content">

        </div><!-- content -->


        <div data-role="footer" data-position="fixed"> 
            <div data-role="navbar" data-iconpos="left">
                <ul>
                    <li><a href="#timeline" data-transition="slide" data-direction="reverse" data-icon="home" >HOME</a></li>
                    <li><a href="#twitter" data-transition="slide" data-direction="reverse" data-icon="star">Twitter</a></li>
                    <li><a href="" data-icon="check" data-transition="slide" data-theme="b">album</a></li>
                </ul>
            </div>
        </div>
    </div><!-- page -->



</head>

<body>


</body>

</html>