<?php
error_reporting(0);
ob_start();
include "data.php";
?>
<!DOCTYPE HTML>
<html>
 <head>
 <title>Admin-Bereich | NewsSystem Script</title>
<meta charset="ISO-8859-1">
<link rel="stylesheet" type="text/css" href="../design/login.css">
 </head>
 <body>
 <br>
 <div id="seite">
<div class="title">Admin-Bereich</div>
<?php
switch($_GET["admin"]){
  case "":
?>
	  <form action="?admin=login" method="post">
	  <table>
	  <tr><td>Benutzername</td><td><input type="text" class="li" name="username"></td></tr>
	  <tr><td>Passwort</td><td><input type="password" class="li" name="password"></td></tr>
	  </table>
	  <input type="submit" class="lb" value="Login">
	  </form>
<?php
  break;
 case "login":
 if(trim($_POST['username']) !== $adminuser)
 echo "<div class=\"fehler\">Ihr Benutzername ist falsch!</div>\n";
 if(trim($_POST['password']) !== $adminpass)
 echo "<div class=\"fehler\">Ihr Passwort ist falsch!</div>\n";
 if(trim($_POST['password']) == $adminpass AND trim($_POST['username']) == $adminuser) {
 setcookie("username",$_POST['username'],time()+(3600*24));
 setcookie("password",$_POST['password'],time()+(3600*24));
 header("Location: index.php");
 echo "<div class=\"erfolg\">Ihre Daten passen.<br><a href=\"index.php\">> Weiter zum Admin-Bereich.</a></div>\n";
 }
?>
<?php
  break;
}
?>
 </div>
 <div id="footer">
<div class="text">&copy; <a href="http://scripts.wronnay.net">Scripts.Wronnay.net</a><br><br>
 </div></div>
 </body>
</html>
<?php
ob_end_flush();
?>