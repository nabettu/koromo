# koromo
templaの機能切り出し版です。

PHPのマルチバイト文字列 関数の利用可能な環境でconfig4git.phpの中身を記載してconfig.phpにrenameして利用して下さい。


# config.phpに記載する内容
define('ROOTURL', '置いておくサーバーのURL ex) http://koromo.dev/');
define('TW_CONSUMER_KEY', 'TwitterAPIconsumerKey ex) abcdefghijklmeop');
define('TW_CONSUMER_SECRET', 'TwitterAPIconsumerSecret ex)  abcdefghijklmeopabcdefghijklmeopabcdefghijklmeop');

define('APP_URL', 'データを送ってくるサイトURL REFFEREに入るURL ex) http://makeImage.com/');
define('APP_RETURN_URL', 'Tweet後に戻るURL（空の場合はAPP_URL） ex) http://makeImage.com/return/');
define('APP_PARAMETERS', 'Tweet後に戻る際に添付するパラメータ ex) ?state=tweeted');
