<?php
if(isset($_GET['id'])){
	$dbpre = $dbc->prepare("SELECT title, news, description, keywords FROM wronnay_news WHERE id='".$_GET['id']."'");
	$dbpre->execute();
	$row = $dbpre->fetch(PDO::FETCH_OBJ);
}
  if(isset($_POST['submit']) AND $_POST['submit'] == "Eintragen") {
if(($_GET['action']) == 'edit'){
        if(empty($_REQUEST['title']) || empty($_REQUEST['description']) || empty($_REQUEST['keywords']) || empty($_REQUEST['news']))
      {
        echo"<div class=\"fehler\">Bitte f&uuml;llen Sie alle Felder aus!</div>";
      }
	  else {
$dbpre = $dbc->prepare("UPDATE wronnay_news SET autor='$adminuser', title='".$_REQUEST['title']."', news='".$_REQUEST['news']."', description='".$_REQUEST['description']."', keywords='".$_REQUEST['keywords']."' WHERE id='".$_GET['id']."' ");
	 $dbpre->execute(); 
	  echo "<div class=\"erfolg\">Sie haben die News eingetragen.</div>";
	  }
}
else {
        if(empty($_REQUEST['title']) || empty($_REQUEST['description']) || empty($_REQUEST['keywords']) || empty($_REQUEST['news']))
      {
        echo"<div class=\"fehler\">Bitte f&uuml;llen Sie alle Felder aus!</div>";
      }
	  else {
	  $bodynachricht = $_REQUEST['news'];
	  $dbpre = $dbc->prepare("INSERT INTO wronnay_news (autor, title, news, date, description, keywords) VALUES ('".$adminuser."','".$_REQUEST['title']."','".$bodynachricht."', now(),'".$_REQUEST['description']."','".$_REQUEST['keywords']."')");
	  $dbpre->execute();
	  echo "<div class=\"erfolg\">Sie haben die News eingetragen.</div>";
	  }
  }
  }
?>
<div class="title">News erstellen</div>
<form action="" method="post">
	  <table>
	  <tr><td>Titel: </td><td><input type="text" class="li" name="title" value="<?php echo nocss($row->title); ?>" size="50"></td></tr>
	  <tr><td>Beschreibung: </td><td><input type="text" class="li" name="description" value="<?php echo nocss($row->description); ?>" size="50"></td></tr>
	  <tr><td>Schlagwörter: </td><td><input type="text" class="li" name="keywords" value="<?php echo nocss($row->keywords); ?>" size="50"> (mit Komma getrennt)</td></tr>
      <tr><td>Text: </td><td>
      <textarea id="nachricht" class="li" name="news" cols="55" rows="15"><?php echo nocss($row->news); ?></textarea></td></tr>
	  </table>
      <input class="lb" name="submit" type="submit" value="Eintragen">
      </form>
