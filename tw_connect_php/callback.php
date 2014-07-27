<?php

require_once('config.php');
require_once('codebird.php');

session_start();

// \Codebird\Codebird::setConsumerKey(CONSUMER_KEY, CONSUMER_SECRET);
// $cb = \Codebird\Codebird::getInstance();

\Codebird\Codebird::setConsumerKey(CONSUMER_KEY, CONSUMER_SECRET); 
$cb = \Codebird\Codebird::getInstance();

if (! isset($_GET['oauth_verifier'])) {
    // gets a request token
    $reply = $cb->oauth_requestToken(array(
//        'oauth_callback' => 'http://' . $_SERVER['HTTP_HOST'] .'/dbkt/dbkt.php#timeline'
        'oauth_callback' => 'http://okn-ryo.lolipop.jp/dbkt/dbkt.php#timeline'
    ));


    // stores it
    $cb->setToken($reply->oauth_token, $reply->oauth_token_secret);
    $_SESSION['oauth_token'] = $reply->oauth_token;
    $_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;

    // gets the authorize screen URL
    $auth_url = $cb->oauth_authorize();
    header('Location: ' . $auth_url);
    die();

} else {
    // gets the access token
    $cb->setToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
    $reply = $cb->oauth_accessToken(array(
        'oauth_verifier' => $_GET['oauth_verifier']
    ));
    // $_SESSION['oauth_token'] = $reply->oauth_token;
    // $_SESSION['oauth_token_secret'] = $reply->oauth_token_secret;
    $cb->setToken($reply->oauth_token, $reply->oauth_token_secret);
    
    $me = $cb->account_verifyCredentials();
    
    // var_dump($me);
    // exit;
    
    // データベースに格納
       try {
        $dbh = new PDO(DSN, DB_USER, DB_PASSWORD);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    
    $sql = "select * from users where tw_user_id = :id limit 1";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(":id" => $me->id_str));
    $user = $stmt->fetch();
    
    error_log('ユーザー検出');


    if (!$user) {
                error_log('SQLの実行');
        $params = array(
            ":tw_user_id" => $me->id_str,
            ":tw_screen_name" => $m->screen_name,
            ":tw_access_token" => $reply->oauth_token,
            ":tw_access_token_secret" => $reply->oauth_token_secret
        );
        $sql = "insert into users 
                (tw_user_id, tw_screen_name, tw_access_token, tw_access_token_secret, created, modified) 
                values 
                (:tw_user_id, :tw_screen_name, :tw_access_token, :tw_access_token_secret, now(), now())";
                        $stmt = $dbh->prepare($sql);

        $stmt->execute($params);
        
        $myId = $dbh->lastInsertId();
        $sql = "select * from users where id = :id limit 1";
        $stmt = $dbh->prepare($sql);
            $stmt->execute(array(":id" => $myId));
            $user = $stmt->fetch();
    }
    
        
    
    // ログイン処理
    if (!empty($user)) {
        // セッションハイジャック対策
        session_regenerate_id(true);
        $_SESSION['me'] = $user;
    }
    
    // ホームに飛ばす
    header('Location: '.SITE_URL);
   
    
    
}