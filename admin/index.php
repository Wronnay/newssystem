<?php
error_reporting(0);
ob_start();
include 'data.php';
include '../config.php';
mysql_connect($HOST,$USER,$PW)or die(mysql_error());
mysql_select_db($DB)or die(mysql_error());
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
$admin = "1";
?>
<!DOCTYPE HTML>
<html>
 <head>
 <title>Admin-Bereich | NewsSystem Script</title>
<meta charset="ISO-8859-1">
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
    $result555 = mysql_query($sql555) OR die("<pre>\n".$sql555."</pre>\n".mysql_error());
		if (mysql_num_rows($result555) == 0) {
	    echo "Es gibt noch keine Kommentare!";
	}
    while ($row555 = mysql_fetch_assoc($result555)) {
        echo "<div class=\"comment\"><b>Geschrieben von: ".$row555['autor']." am: ".$row555['date']."</b><br>".$row555['comment']."</div>\n";
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