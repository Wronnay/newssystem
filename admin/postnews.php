<?php
if(isset($_GET['id'])){
	$abfrage = mysql_query("SELECT title, news, description, keywords FROM wronnay_news WHERE id='".mysql_real_escape_string($_GET['id'])."'");
	$row = mysql_fetch_object($abfrage);
}
  if(isset($_POST['submit']) AND $_POST['submit'] == "Eintragen") {
if(($_GET['action']) == 'edit'){
        if(empty($_REQUEST['title']) || empty($_REQUEST['description']) || empty($_REQUEST['keywords']) || empty($_REQUEST['news']))
      {
        echo"<div class=\"fehler\">Bitte f&uuml;llen Sie alle Felder aus!</div>";
      }
	  else {
mysql_query("UPDATE wronnay_news SET autor='$adminuser', title='".$_REQUEST['title']."', news='".$_REQUEST['news']."', description='".$_REQUEST['description']."', keywords='".$_REQUEST['keywords']."' WHERE id='".mysql_real_escape_string($_GET['id'])."' ");
	  echo "<div class=\"erfolg\">Sie haben die News eingetragen.</div>";
	  }
}
else {
        if(empty($_REQUEST['title']) || empty($_REQUEST['description']) || empty($_REQUEST['keywords']) || empty($_REQUEST['news']))
      {
        echo"<div class=\"fehler\">Bitte f&uuml;llen Sie alle Felder aus!</div>";
      }
	  else {
	  $bodynachricht = parse_bbcode(mysql_real_escape_string($_REQUEST['news']));
	  mysql_query("INSERT INTO wronnay_news (autor, title, news, date, description, keywords) VALUES ('".$adminuser."','".mysql_real_escape_string($_REQUEST['title'])."','".$bodynachricht."', now(),'".mysql_real_escape_string($_REQUEST['description'])."','".mysql_real_escape_string($_REQUEST['keywords'])."')");
	  echo "<div class=\"erfolg\">Sie haben die News eingetragen.</div>";
	  }
  }
  }
?>
<div class="title">News erstellen</div>
<form action="" method="post">
	  <table>
	  <tr><td>Titel: </td><td><input type="text" class="li" name="title" value="<?php echo $row->title; ?>" size="50"></td></tr>
	  <tr><td>Beschreibung: </td><td><input type="text" class="li" name="description" value="<?php echo $row->description; ?>" size="50"></td></tr>
	  <tr><td>Schlagwörter: </td><td><input type="text" class="li" name="keywords" value="<?php echo $row->keywords; ?>" size="50"> (mit Komma getrennt)</td></tr>
      <tr><td>Text: </td><td>
<?php
include '../inc/sbbcb.php';
?>
      <textarea id="nachricht" class="li" name="news" cols="55" rows="15"><?php echo $row->news; ?></textarea></td></tr>
	  </table>
      <input class="lb" name="submit" type="submit" value="Eintragen">
      </form>