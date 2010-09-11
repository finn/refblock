<?php
$url = $_GET['url'];
$type = $_GET['type'];

if ($url != "") {
    if ($type == "image") {
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

        //$h = "text/plain";
        header("Content-type: $h");

        $r = curl_init($url);
        curl_setopt($r, CURLOPT_REFERER, $url);
        curl_setopt($r, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        curl_setopt($r, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($r, CURLOPT_BINARYTRANSFER, 1);

        $imagecontent = curl_exec($r);
        curl_close($r);

        //readfile($url);

        print($imagecontent);
    } else { ?>
<html>
<head>
<meta http-equiv="refresh" content="0;url=<?php echo $url; ?>">
</head>
</html>
    <?php }
}
?>
