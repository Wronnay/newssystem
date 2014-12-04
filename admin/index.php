<?php
error_reporting(0);
ob_start();
include 'data.php';
include '../config.php';
$dbc = new PDO(''.$DBTYPE.':host='.$HOST.';dbname='.$DB.'', ''.$USER.'', ''.$PW.'');
$dbc->query("SET CHARACTER SET utf8");
include '../data.php';
include '../inc/showbbc.php';
include '../inc/bbc.php';
if($_COOKIE['username'] == $adminuser AND $_COOKIE['password'] == $adminpass)
   {
   $_SESSION["username"] = $adminuser;
   setcookie("username",$adminuser,time()+(3600*24*100));
   setcookie("password",$adminpass,time()+(3600*24*100));
   }
else
   {
header("Location: login.php");
   }
function nocss($nocss) {
  $nocss = strip_tags($nocss);
  $nocss = htmlspecialchars($nocss);
  return $nocss;
}
$admin = "1";
?>
<!DOCTYPE HTML>
<html>
 <head>
 <title>Admin-Bereich | NewsSystem Script</title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../design/admin.css">
 </head>
 <body>
  <div id="logo"><img src="../images/adminbereich.png" alt=""></div>
 <div class="navi"><div class="newsnav"><div class="navk">News:</div><a href="?admin=postnews">erstellen</a><a href="?admin=editnews">bearbeiten</a><a href="?admin=deletenews">löschen</a></div>
<div class="kommnav"><div class="navk">Kommentare:</div><a href="?admin=deletecomments">löschen</a></div></div>
 <div id="seite">
 <?php
switch($_GET["admin"]){
  case "":
?>
<div class="title">Willkommen, <?php echo $adminuser; ?>!</div>
Oben im Navi können Sie auswählen, was Sie machen wollen.<br>
<br>Letzte Kommentare:
<?php
    $sql555 = "SELECT
	                id,
	                autor,
                    news_id,
					comment,
					date
            FROM
                    wronnay_news_comments
            ORDER BY
                    date DESC
			LIMIT 
		            15
           ";
    $dbpre = $dbc->prepare($sql555);
    $dbpre->execute();
		if ($dbpre->rowCount() < 1) {
	    echo "Es gibt noch keine Kommentare!";
	}
    while ($row555 = $dbpre->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class=\"comment\"><b>Geschrieben von: ".nocss($row555['autor'])." am: ".nocss($row555['date'])."</b><br>".nocss($row555['comment'])."</div>\n";
    }
?>
<?php
  break;
  case "postnews":
  include 'postnews.php';
  break;
  case "editnews":
  include 'editnews.php';
  break;
  case "deletenews":
  include 'deletenews.php';
  break;
  case "deletecomments":
  include 'deletecomments.php';
  break;
  case "editcomments":
  include 'editcomments.php';
  break;
}
?>
 </div>
 <div id="footer">
<div class="text">&copy; <a href="http://scripts.wronnay.net">Scripts.Wronnay.net</a> | <a href="http://www.greensmilies.com/" target="_blank">Smilies by GreenSmilies.com</a><br><br>
 </div></div>
 </body>
</html>
<?php
ob_end_flush();
?>
