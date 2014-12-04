<?php
function parse_bbcode($str)
{
  $str = htmlspecialchars($str);
		$smiliesql = "SELECT id, title, url, color FROM wronnay_forum_smilies WHERE color='green'";
 $dbpre = $dbc->prepare($smiliesql);
 $dbpre->execute();
    while ($smilieu = $dbpre->fetch(PDO::FETCH_ASSOC)) {
$str = str_replace($smilieu['title'], '<img src="images/system/smilies/'.$smilieu['color'].'/'.$smilieu['url'].'" />', $str);
	}

  $str = preg_replace('#\[b\](.*)\[/b\]#isU', "<b>$1</b>", $str);
  $str = preg_replace('#\[i\](.*)\[/i\]#isU', "<i>$1</i>", $str);
  $str = preg_replace('#\[u\](.*)\[/u\]#isU', "<u>$1</u>", $str);
  $str = preg_replace('#\[color=(.*)\](.*)\[/color\]#isU', "<span style=\"color: $1\">$2</span>", $str);
  $str = preg_replace('#\[size=(8|10|12)\](.*)\[/size\]#isU', "<span style=\"font-size: $1 pt\">$2</span>", $str);
  $str = preg_replace('#\[url\](.*)\[/url\]#isU', "<a target=\"_blank\" href=\"$1\">$1</a>", $str);
  $str = preg_replace('#\[url=(.*)\](.*)\[/url\]#isU', "<a target=\"_blank\" href=\"$1\">$2</a>", $str);
  $str = preg_replace('#\[img\](.*)\[/img\]#isU', "<img src=\"$1\" alt=\"$1\" />", $str);
  $str = preg_replace('#\[quote\](.*)\[/quote\]#isU', "<div class=\"zitat\">$1</div>", $str);
  $str = preg_replace('#\[code\](.*)\[/code\]#isU', "<div class=\"code\">$1</div>", $str);
  $str = preg_replace('#\[list\](.*)\[/list\]#isU', "<ul>$1</ul>", $str);
  $str = preg_replace('#\[list=(1|a)\](.*)\[/list\]#isU', "<ol type=\"$1\">$2</ol>", $str);
  $str = preg_replace("#\[*\](.*)\\r\\n#U", "<li>$1</li>", $str);
  return $str;
}
?>
