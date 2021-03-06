<?php
header('content-type: text/html; charset=UTF-8');
error_reporting(0);
ob_start();
ini_set("session.gc_maxlifetime", 2000);
?>
<!DOCTYPE HTML>
<html>
 <head>
 <title>Installation | NewsSystem Script</title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../design/install.css">
 </head>
 <body>
 <div id="logo"><img src="../images/logo.png" alt=""></div>
 <div id="seite">
<div class="title">NewsSystem - Installation:</div>
<?php
switch($_GET["install"]){
  case "":
?>
<div class="title2">(Schritt 1/4)</div><br>
<b>MySQL-Daten angeben:</b><br>
	  <form action="?install=1-2" method="post">
	  <table>
	  <tr><td>Host (oft: "localhost")</td><td><input type="text" name="host" value="localhost"></td></tr>
	  <tr><td>Datenbank-Name</td><td><input type="text" name="database"></td></tr>
	  <tr><td>Benutzername</td><td><input type="text" name="user"></td></tr>
	  <tr><td>Passwort</td><td><input type="password" name="pass"></td></tr>
	  <tr><td>Passwort (Wiederholung)</td><td><input type="password" name="pass2"></td></tr>
	  </table>
	  <input type="submit" value="Weiter">
	  </form>
<?php
  break;
 case "1-2":
?>
<div class="title2">(Schritt 1/4)</div><br>
<?php
if($_POST["pass"] != $_POST["pass2"])
	  {
	    echo "Die Passwörter stimmen nicht überein.<br><br>
		<a href=\"?install=\">Zurück zu Schritt 1</a><br><br>";
	  }
else {
	  $fp = fopen("../config.php","w+");
      $HOST = '$HOST';
      $USER = '$USER';
      $PW = '$PW';
      $DB = '$DB';
      $DBTYPE = '$DBTYPE';
      $daten = "<?php
      $HOST = '$_POST[host]'; 
      $USER = '$_POST[user]'; 
      $PW = '$_POST[pass]'; 
      $DB = '$_POST[database]'; 
      $DBTYPE = 'mysql';
      ?>";
      fwrite($fp,$daten);
	  include("../config.php");
	  $dbc = new PDO('mysql:host='.$HOST.'', ''.$USER.'', ''.$PW.'');   
	  $dbc->query("SET CHARACTER SET utf8");	
	  $dbpre = $dbc->prepare("CREATE DATABASE IF NOT EXISTS ".$DB.";");
	  $dbpre->execute();
      $dbc = new PDO(''.$DBTYPE.':host='.$HOST.';dbname='.$DB.'', ''.$USER.'', ''.$PW.'');
      $dbc->query("SET CHARACTER SET utf8");
	  $dbpre = $dbc->prepare("CREATE TABLE IF NOT EXISTS wronnay_news (
      id INT(22) NOT NULL auto_increment,
      autor varchar(220) NOT NULL,
	  title varchar(220) NOT NULL,
	  news text NOT NULL,
	  date datetime NOT NULL,
	  description text NOT NULL,
	  keywords text NOT NULL,
      PRIMARY KEY (id) );
      ");
      $dbpre->execute();
	  $dbpre = $dbc->prepare("CREATE TABLE IF NOT EXISTS wronnay_news_comments (
      id INT(22) NOT NULL auto_increment,
	  news_id INT(22) NOT NULL,
      autor varchar(220) NOT NULL,
	  comment text NOT NULL,
	  date datetime NOT NULL,
      PRIMARY KEY (id) );
      ");
      $dbpre->execute();
	  $dbpre = $dbc->prepare("CREATE TABLE IF NOT EXISTS wronnay_forum_smilies (
      id INT(22) NOT NULL auto_increment,
      color varchar(220) NOT NULL,
	  title varchar(220) NOT NULL,
	  url varchar(220) NOT NULL,
      PRIMARY KEY (id) );
      ");
      $dbpre->execute();
   $import = file_get_contents("wronnay_forum_smilies.sql");
   $import = preg_replace ("%/\*(.*)\*/%Us", '', $import);
   $import = preg_replace ("%^--(.*)\n%mU", '', $import);
   $import = preg_replace ("%^$\n%mU", '', $import);
   $import = str_replace('$PREFIX', $PREFIX, $import);
   $import = explode (";", $import); 
   foreach ($import as $imp){
    if ($imp != '' && $imp != ' '){
     $dbpre = $dbc->prepare($imp);
     $dbpre->execute();
    }
   }  
header("Location: ?install=2");
}
  break;
 case "2":
?>
<div class="title2">(Schritt 2/4)</div><br>
<b>NewsSystem-Daten angeben:</b><br>
	  <form action="?install=2-1" method="post">
	  <table>
	  <tr><td>Titel</td><td><input onclick="if(this.value && this.value==this.defaultValue)this.value=''" type="text" name="titel" value="NewsSystem"></td></tr>
	  <tr><td>Untertitel</td><td><input onclick="if(this.value && this.value==this.defaultValue)this.value=''" type="text" name="untertitel" value="News aus aller Welt"></td></tr>
	  <tr><td>Beschreibung</td><td><input onclick="if(this.value && this.value==this.defaultValue)this.value=''" type="text" name="beschreibung" value="Neues aus Deutschland und der ganzen Welt."></td></tr>
	  <tr><td>Schlagwörter</td><td><input onclick="if(this.value && this.value==this.defaultValue)this.value=''" type="text" name="schlagwoerter" value="news, neues, deutschland, welt, netzkultur, internet"> (mit Komma getrennt)</td></tr>
	  <tr><td>Ihre Webseite</td><td><input onclick="if(this.value && this.value==this.defaultValue)this.value=''" type="text" name="webseite" value="http://IhreWebseite.de"> (mit "http://")</td></tr>
	  <tr><td>Ihr Impressum</td><td><input onclick="if(this.value && this.value==this.defaultValue)this.value=''" type="text" name="impressum" value="http://IhreWebseite.de/impressum.html"> (mit "http://")</td></tr>
	  </table>
	  <input type="submit" value="Weiter">
	  </form>
<?php
  break;
 case "2-1":
 	  $fp = fopen("../data.php","w+");
      $titel = '$titel';
      $untertitel = '$untertitel';
      $beschreibung = '$beschreibung';
      $schlagwoerter = '$schlagwoerter';
	  $webseite = '$webseite';
      $impressum = '$impressum';
      $daten = "<?php
      $titel = '$_POST[titel]'; 
      $untertitel = '$_POST[untertitel]'; 
      $beschreibung = '$_POST[beschreibung]'; 
      $schlagwoerter = '$_POST[schlagwoerter]'; 
	  $webseite = '$_POST[webseite]'; 
	  $impressum = '$_POST[impressum]'; 
      ?>";
      fwrite($fp,$daten);
header("Location: ?install=3");
  break;
 case "3":
?>
<div class="title2">(Schritt 3/4)</div><br>
<b>Admin-Daten angeben (Zum Schreiben von News):</b><br>
	  <form action="?install=3-1" method="post">
	  <table>
	  <tr><td>Benutzername</td><td><input type="text" name="adminuser"></td></tr>
	  <tr><td>Passwort</td><td><input type="password" name="adminpass"></td></tr>
	  <tr><td>Passwort (Wiederholung)</td><td><input type="password" name="adminpass2"></td></tr>
	  </table>
	  <input type="submit" value="Weiter">
	  </form>
<?php
  break;
 case "3-1":
if($_POST["adminpass"] != $_POST["adminpass2"])
	  {
	    echo "Die Passwörter stimmen nicht überein.<br><br>
		<a href=\"?install=3\">Zurück zu Schritt 3</a><br><br>";
	  }
else {
	  $fp = fopen("../admin/data.php","w+");
      $adminuser = '$adminuser';
      $adminpass = '$adminpass';
      $daten = "<?php
      $adminuser = '$_POST[adminuser]'; 
      $adminpass = '$_POST[adminpass]'; 
      ?>";
      fwrite($fp,$daten);
	  	  include("../config.php");
      $dbc = new PDO(''.$DBTYPE.':host='.$HOST.';dbname='.$DB.'', ''.$USER.'', ''.$PW.'');
      $dbc->query("SET CHARACTER SET utf8");
$dbpre = $dbc->prepare("INSERT INTO wronnay_news (autor, title, news, date, description, keywords) VALUES ('System', 'Die Installation ist fertig!', 'Diese News wurde am Ende der Installation erstellt. Sie können sie im Admin-Bereich löschen. Wenn Sie noch Fragen, Probleme oder Wünsche haben oder wenn Sie einen Fehler gefunden haben, dann können Sie mir unter: http://wronnay.net/kontakt eine Nachricht senden.', NOW(), 'Die Installation von dem Wronnay NewsSystem Script ist fertig.', 'installation, news, system, wronnay, script, fertig')");
$dbpre->execute();
header("Location: ?install=4");
}
  break;
 case "4":
?>
<div class="title2">(Schritt 4/4)</div><br>
<b>Die Installation ist fertig!:</b><br>
Wenn Sie noch Fragen, Probleme oder Wünsche haben oder wenn Sie einen Fehler gefunden haben, dann können Sie <a href="http://wronnayscripts.forenhosting.net/forum.php?id=2">hier</a> darüber diskutieren.
<br><br><a href="../index.php">> OK!</a><br><br>
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
