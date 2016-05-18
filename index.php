<?php

require_once 'config.php';

$AppURL = APP_URL;
$AppReturnURL = APP_RETURN_URL;
$_SESSION['parameters'] = APP_PARAMETERS;

if (mb_substr($_SERVER['HTTP_REFERER'], 0, strlen($AppURL)) != $AppURL) {
    //TODO:エラー系はどこかにまとめる
    echo "<meta charset='UTF-8'>";
    echo $_SERVER['HTTP_REFERER'];
    echo '<br>登録されていないURLからのPOSTです';
    exit;
}

if ($AppReturnURL == '') {
    $_SESSION['returnURL'] = $AppURL;
} else {
    $_SESSION['returnURL'] = $AppReturnURL;
}

if (($_POST['image'] == null) || (($_POST['text'] == null )&&($_GET["setpf"] != "true"))) {
    //TODO:エラー系はどこかにまとめる
    echo "<meta charset='UTF-8'>";
    echo '必要な情報がPOSTされていません';
    exit;
}

//SESSIONに画像と文言を保存
$_SESSION['setpf'] = $_GET['setpf'];
$_SESSION['postText'] = $_POST['text'];
$_SESSION['postImage'] = $_POST['image'];

//OAuthに必要な情報をセット
$tw = new TwitterOAuth(TW_CONSUMER_KEY, TW_CONSUMER_SECRET);
$token = $tw->getRequestToken(TW_CALLBACK_URL);
if (!isset($token['oauth_token'])) {
    echo "error: getRequestToken\n";
    exit;
}
$_SESSION['oauth_token'] = $token['oauth_token'];
$_SESSION['oauth_token_secret'] = $token['oauth_token_secret'];

// Twitterの認証画面に遷移
$authURL = $tw->getAuthorizeURL($_SESSION['oauth_token']);
header('Location: '.$authURL);
exit;
