<?php
error_reporting(0);
include 'data.php';
include 'config.php';
function nocss($nocss) {
  $nocss = mysql_real_escape_string($nocss);
  $nocss = strip_tags($nocss);
  $nocss = htmlspecialchars($nocss);
  return $nocss;
}
mysql_connect($HOST,$USER,$PW)or die(mysql_error());
mysql_select_db($DB)or die(mysql_error());
$sql = "SELECT id, autor, title, news, date, description, keywords FROM wronnay_news WHERE id  = '".mysql_real_escape_string($_GET['id'])."' ORDER BY date DESC";
    $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
    while ($row = mysql_fetch_assoc($result)) {
	$comments = mysql_num_rows(mysql_query("SELECT id FROM wronnay_news_comments WHERE news_id = '".$row['id']."'"));
?>
<!DOCTYPE HTML>
<!--
NewsSystem-Script and Design by Christoph Miksche
Websites: http://celzekr.tk and http://scripts.wronnay.net
License: Attribution-NonCommercial-ShareAlike 3.0 Unported (CC BY-NC-SA 3.0)

Dieses Werk bzw. Inhalt steht unter einer Creative Commons Namensnennung-Nicht-kommerziell-
Weitergabe unter gleichen Bedingungen 3.0 Unported Lizenz.

Sie duerfen die Links zu Celzekr.tk und Scripts.Wronnay.net nicht entfernen!

(http://creativecommons.org/licenses/by-nc-sa/3.0/)
-->
<html><head><title><?php echo "".nocss($row['title'])."" ?> | <?php echo $titel; ?></title><meta name="description" content="<?php echo "".nocss($row['description'])."" ?>"><meta name="keywords" content="<?php echo "".nocss($row['keywords'])."" ?>"><meta charset="ISO-8859-1"><link rel="shortcut icon" href="images/fav.ico"><link rel="stylesheet" type="text/css" href="design/grau.css">
<?php 
include 'inc/showbbc.php'; 
include 'inc/bbc.php'; 
?>
</head><body>
<div id="head"><?php echo $titel; ?><div class="untertitel"><?php echo $untertitel; ?></div></div>
<div id="inhalt">
<div class="news">
<div class="title">
<?php echo "".nocss($row['title'])."" ?>
</div>
<div class="text">
<?php echo "".nocss($row['news'])."" ?>
</div>
<div class="infos">
Autor: <?php echo "".nocss($row['autor'])."" ?> | Vom: <?php echo "".nocss($row['date'])."" ?>
</div>
<div class="comments">
<b>Kommentare:</b>
<?php
    $sql555 = "SELECT
	                id,
	                autor,
                    news_id,
					comment,
					date
            FROM
                    wronnay_news_comments
            WHERE
			        news_id = '".$row['id']."'
            ORDER BY
                    date DESC
           ";
    $result555 = mysql_query($sql555) OR die("<pre>\n".$sql555."</pre>\n".mysql_error());

    while ($row555 = mysql_fetch_assoc($result555)) {
        echo "<div class=\"comment\"><b>Geschrieben von: ".nocss($row555['autor'])." am: ".nocss($row555['date'])."</b><br>".nocss($row555['comment'])."</div>\n";
    }
?>
<?php
  if(isset($_POST['submit']) AND $_POST['submit'] == "Kommentieren") {
        if(empty($_REQUEST['comment']) || empty($_REQUEST['name']))
      {
        echo"<div class=\"fehler\">Bitte geben Sie Ihren Kommentar und Ihren Namen ein!</div>";
      }
	  elseif(isset($_POST['email']) && $_POST['email']) {
	  echo"<div class=\"fehler\">You are an SPAM-Bot!</div>";
	  }
	  else {
	  $bodynachricht = parse_bbcode(mysql_real_escape_string($_REQUEST['comment']));
	  mysql_query("INSERT INTO wronnay_news_comments (autor, news_id, comment, date) VALUES ('".mysql_real_escape_string($_REQUEST['name'])."','".$row['id']."','".$bodynachricht."',now())");
	  echo "<div class=\"erfolg\">Sie haben den Kommentar eingetragen.</div>";
	  }
  }
?>
<br><form action="<?php echo "news.php?id=".$row['id']."" ?>" method="post">
<p class="hallo">
  <input id="email" name="email" size="60" value="" />
</p>
          Kommentar schreiben: <br>
<?php
include 'inc/sbbcb.php';
?>
          <textarea id="nachricht" class="li" name="comment" cols="40" rows="5"></textarea>
          <br>
		  Ihr Name: <input class="li" type="text" name="name"><br>
          <input class="lb" name="submit" type="submit" value="Kommentieren">
      </form>
</div>
</div>
<?php
    }
include 'design/footer.php';
?>
