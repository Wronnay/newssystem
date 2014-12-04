<?php
error_reporting(0);
include 'data.php';
include 'config.php';
function nocss($nocss) {
  $nocss = strip_tags($nocss);
  $nocss = htmlspecialchars($nocss);
  return $nocss;
}
$dbc = new PDO(''.$DBTYPE.':host='.$HOST.';dbname='.$DB.'', ''.$USER.'', ''.$PW.'');
$dbc->query("SET CHARACTER SET utf8");
$sql = "SELECT id, autor, title, news, date, description, keywords FROM wronnay_news WHERE id  = '".$_GET['id']."' ORDER BY date DESC";
    $dbpre = $dbc->prepare($sql);
    $dbpre->execute();
    while ($row = $dbpre->fetch(PDO::FETCH_ASSOC)) {
	$dbpre1 = $dbc->prepare("SELECT id FROM wronnay_news_comments WHERE news_id = '".$row['id']."'");	
	$comments = $dbpre1->rowCount();
?>
<!DOCTYPE HTML>
<!--
NewsSystem-Script and Design by Christoph Miksche
Websites: http://celzekr.webpage4.me and http://scripts.wronnay.net
License: Attribution-NonCommercial-ShareAlike 3.0 Unported (CC BY-NC-SA 3.0)

Dieses Werk bzw. Inhalt steht unter einer Creative Commons Namensnennung-Nicht-kommerziell-
Weitergabe unter gleichen Bedingungen 3.0 Unported Lizenz.

Sie duerfen die Links zu celzekr.webpage4.me und Scripts.Wronnay.net nicht entfernen!

(http://creativecommons.org/licenses/by-nc-sa/3.0/)
-->
<html><head><title><?php echo "".nocss($row['title'])."" ?> | <?php echo nocss($titel); ?></title><meta name="description" content="<?php echo "".nocss($row['description'])."" ?>"><meta name="keywords" content="<?php echo "".nocss($row['keywords'])."" ?>"><meta charset="UTF-8"><link rel="shortcut icon" href="images/fav.ico"><link rel="stylesheet" type="text/css" href="design/grau.css">
<?php 
include 'inc/showbbc.php'; 
include 'inc/bbc.php'; 
?>
</head><body>
<div id="head"><?php echo nocss($titel); ?><div class="untertitel"><?php echo nocss($untertitel); ?></div></div>
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
    $dbpre2 = $dbc->prepare($sql555);
	$dbpre2->execute();
    while ($row555 = $dbpre2->fetch(PDO::FETCH_ASSOC)) {
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
	  $bodynachricht = $_REQUEST['comment'];
	  $dbpre3 = $dbc->prepare("INSERT INTO wronnay_news_comments (autor, news_id, comment, date) VALUES ('".$_REQUEST['name']."','".$row['id']."','".$bodynachricht."',now())");
	  $dbpre3->execute();
	  echo "<div class=\"erfolg\">Sie haben den Kommentar eingetragen.</div>";
	  }
  }
?>
<br><form action="news.php?id=<?php echo nocss($_GET['id']); ?>" method="post">
<p class="hallo">
  <input id="email" name="email" size="60" value="" />
</p>
          Kommentar schreiben: <br>
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
