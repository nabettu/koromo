<?php
//すべてのPHPファイルでこのファイルを読み込んで下さい
require_once 'lib/tmhOAuth.php';
require_once 'lib/twitteroauth.php';
require_once 'lib/GifManipulator.php';

//local
define('ROOTURL', 'http://hoge.dev');

define('TW_CONSUMER_KEY', '');
define('TW_CONSUMER_SECRET', '');
define('TW_CALLBACK_URL', ROOTURL.'/cb.php');

define('APP_URL', 'http://fuga/');
define('APP_RETURN_URL', '');
define('APP_PARAMETERS', '?state=tweeted');

//　PHPでnotice以外のエラーコードは全部出力します
error_reporting(E_ALL & ~E_NOTICE);

//　セッションを取っておくパス
session_set_cookie_params(0, "/");
session_start();
?>
