<?php
$url = $_GET['url'];
$type = $_GET['type'];

$header = <<<HEAD
<!DOCTYPE html>
<html>
<head>
<title>refer</title>

HEAD;

$footer = <<<FOOT
</head>
</html>

FOOT;

if ($url == "") {
    // no url argument. output an empty document.
    echo $header;
    echo $footer;
} else {
    if ($type == "image") {
        // an image. pull it down from the other server and output it.
        $r = curl_init($url);
        curl_setopt($r, CURLOPT_HEADER, 1);
        curl_setopt($r, CURLOPT_NOBODY, 1);
        curl_setopt($r, CURLOPT_REFERER, $url);
        curl_setopt($r, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);

        ob_start();
        curl_exec($r);
        curl_close($r);
        $headercontent = ob_get_contents();
        ob_end_clean();

        preg_match("/Content-type: (.+)\n/i", $headercontent, $matches);
        $h = $matches[1];

        header("Content-type: $h");

        $r = curl_init($url);
        curl_setopt($r, CURLOPT_REFERER, $url);
        curl_setopt($r, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        curl_setopt($r, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($r, CURLOPT_BINARYTRANSFER, 1);

        $imagecontent = curl_exec($r);
        curl_close($r);

        print($imagecontent);
    } else {
        // url argument, but not an image. output a document with a <meta> refresh.
        $meta = <<<META
<meta http-equiv="refresh" content="0; url=$url">

META;
        echo $header;
        echo $meta;
        echo $footer;
    }
}
