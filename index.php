<?php
error_reporting(0);
include 'config.php';
if (!isset ($DB)) { header("Location: install/index.php"); }
include 'data.php';
function nocss($nocss) {
  $nocss = mysql_real_escape_string($nocss);
  $nocss = strip_tags($nocss);
  $nocss = htmlspecialchars($nocss);
  return $nocss;
}
include 'design/header.php';
mysql_connect($HOST,$USER,$PW)or die(mysql_error());
mysql_select_db($DB)or die(mysql_error());
    $sql = "SELECT
            id,
            autor,
            title,
            news,
            date,
			description,
			keywords
        FROM
            wronnay_news
        ORDER BY
            date DESC
		LIMIT 
		    15
		";
    $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
			if (mysql_num_rows($result) == 0) {
	    echo "Es gibt noch keine News!";
	}
    while ($row = mysql_fetch_assoc($result)) {
	$comments = mysql_num_rows(mysql_query("SELECT id FROM wronnay_news_comments WHERE news_id = '".$row['id']."'"));
include 'design/news.php';
    }
include 'design/footer.php';
?>
