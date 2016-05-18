<?php

require_once 'config.php';

//つぶやく内容・帰り道があるかどうかチェック
if (($_SESSION['postImage'] == null) || (($_SESSION['postText'] == null)&&($_SESSION['setpf'] != "true")) || ($_SESSION['returnURL'] == null)) {
    //TODO:エラー系はどこかにまとめる
    echo "<meta charset='UTF-8'>";
    echo 'サーバーエラー<br>ファイルが存在しないか、つぶやく内容が空です';
    echo $_SESSION['postFilePath'];
    echo $_SESSION['postText'];
    unset($_SESSION);
    exit;
}

// セットした oauth_token と一致するかチェック
if ($_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
    //TODO:エラー系はどこかにまとめる
    echo "<meta charset='UTF-8'>";
    echo 'サーバーエラー<br>oauth tokenが一致しません';
    unset($_SESSION);
    exit;
}
// user access token 取得
$tw = new TwitterOAuth(TW_CONSUMER_KEY, TW_CONSUMER_SECRET,
    $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

//ユーザー情報取得
$access_token = $tw->getAccessToken($_REQUEST['oauth_verifier']);
$tw_user_id = $access_token['user_id'];
$tw_screen_name = $access_token['screen_name'];
$user_token = $access_token['oauth_token'];
$user_token_secret = $access_token['oauth_token_secret'];

//TODO:サービスにする際:tokenを保存？

$tw = new tmhOAuth(
    array(
        'consumer_key' => TW_CONSUMER_KEY,
        'consumer_secret' => TW_CONSUMER_SECRET,
        'token' => $user_token,
        'secret' => $user_token_secret,
        'curl_ssl_verifypeer' => false,
    )
);

$canvas = preg_replace('/data:[^,]+,/i', '', $_SESSION['postImage']);
$image = base64_decode($canvas);

//画像タイプ判定
$extension = mb_substr($_SESSION['postImage'], 11, mb_strpos($_SESSION['postImage'], ';') - 11);

if($_SESSION['setpf'] == "true"){
    $req = $tw->request('POST', $tw->url('1.1/account/update_profile_image'),
        array(
        'image' => $image.';type=image/'.$extension.';filename=templa.'.$extension,
        ), true, true);
};

if($_SESSION['postText']){
    $req = $tw->request('POST', $tw->url('1.1/statuses/update_with_media'),
        array(
        'status' => $_SESSION['postText'],
        'media[]' => $image.';type=image/'.$extension.';filename=templa.'.$extension,
        ), true, true);
};

header('Location:'.$_SESSION['returnURL'].$_SESSION['parameters']);

//セッションも削除
unset($_SESSION);
exit;
