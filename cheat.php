<?php
$baseurl = "http://www.sample.com/refblolck";

$generatehtml = $_GET['generatehtml'];
$refererblock = $_GET['refererblock'];
$u = $_GET['u'];
$bookmarklet = $_GET['bookmarklet'];

// bookmarklet response
if($bookmarklet == "true") {
    // match image extensions
    $imageext = "|.gif|.png|.jpg|jpeg|.bmp|";
    $ext = substr($u, -4);

    // hacky!
    if(!stristr($imageext, "|$ext|")) {
        $refererblock = "link";
    } else {
        $refererblock = "image";
    }

    header("Content-type: text/plain");
}

$answer = urlencode($u);
$answer = "$baseurl/refer.php?url=$answer&type=$refererblock";

if($generatehtml == "true") {
    if($bookmarklet == "true") {
        if($refererblock == "link") {
            $answer = "<a href=\"$answer\">";
        } else {
            $answer = "<img src=\"$answer\">";
        }
    } else {
        if($refererblock == "link") {
            $answer = "&lt;a href=&quot;".$answer."&quot;&gt;";
        } else {
            $answer = "&lt;img src=&quot;".$answer."&quot;&gt;";
        }
    }
}

if($bookmarklet == "true") {
    header("Content-type: text/plain");
    echo $answer;
    exit;
}

// if not a bookmarklet:

?>
<html>
<head>
<title>Referer Block</title>
<style>
body, td {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 12px;
}

body {
    background: #FFF;
}

p.answer {
    margin-left: 25px;
    margin-right: 25px;

    margin-top: 5px;
    margin-bottom: 5px;

    border-top: 2px solid #999;
    border-bottom: 2px solid #999;

    padding: 8px;

    font-size: 10px;
}
</style>
</head>

<body>

<h2>Referer Block Generator</h2>

<?
if($u != "") {
    echo "<p class=\"answer\"><b>The string you requested is:</b><br />";
    echo $answer."</p>";
}
?>

<p>Enter a string you want to URL encode below.  If it's a URL for an
image or link you need to referer-block, choose the appropriate option,
and the full URL you need will be generated.  There is also an option
to generate the HTML you need to generate a link or image tag.</p>

<form action=cheat.php>
<input name=u size=50>
<input type=submit value="Encode!"><br />
<b>Referer Blocking</b><br />
<input type=radio name=refererblock value="none" checked> None<br />
<input type=radio name=refererblock value="image"> Image<br />
<input type=radio name=refererblock value="link"> Link<br />
<br />
<input type=checkbox name=generatehtml value="true"> Generate HTML tag
</form>

<hr noshade>

<p><b>Bookmarklets!</b></p>

<p>Drag the link you want to your toolbar:<ul>
<li><a href="javascript:location.href='<?php echo $baseurl; ?>/cheat.php?u='+encodeURIComponent(location.href)+'&bookmarklet=true&generatehtml=true'">Cheat (HTML)</a></li>
<li><a href="javascript:location.href='<?php echo $baseurl; ?>/cheat.php?u='+encodeURIComponent(location.href)+'&bookmarklet=true'">Cheat (URL only)</a></li>
</ul>
</p>

</body>
</html>
