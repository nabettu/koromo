<?php
require_once '../config.php';
header("Access-Control-Allow-Origin: *");

$AppURL = APP_URL;

if(mb_substr($_SERVER['HTTP_REFERER'], 0, strlen($AppURL)) != $AppURL){
//TODO:エラー系はどこかにまとめる
	echo "<meta charset='UTF-8'>";
    echo $_SERVER['HTTP_REFERER'];
    echo "<br>登録されていないURLからのPOSTです";
    exit;
}

$picurl = 'http://www.paper-glasses.com/api/twipi/'.$_GET['user'].'/original';
$base64data = base64_encode(file_get_contents($picurl));
$headerArray = get_headers($picurl);

for($i = 0; $i < count($headerArray) ;$i++){
  if(preg_match("/Content-Type: image/", $headerArray[$i])){
    $imgType = str_replace("Content-Type: image/", "", get_headers($picurl)[$i]);
  }
}
echo 'data:image/'.$imgType.';base64,'.$base64data;

exit();
?>
