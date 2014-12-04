<div class="title">Kommentare löschen</div>
<?php
if(isset($_GET['id'])){
      $dbpre = $dbc->prepare("DELETE FROM wronnay_news_comments WHERE id='".$_GET['id']."'");
      $dbpre->execute();
	  echo "<div class=\"erfolg\">Der Kommentar wurde gelöscht!</div>";
}
    $sql = "SELECT
	                id,
	                autor,
                    news_id,
					comment,
					date
            FROM
                    wronnay_news_comments
            ORDER BY
                    date DESC
           ";
    $dbpre = $dbc->prepare($sql);
    $dbpre->execute();
		if ($dbpre->rowCount() < 1) {
	    echo "Es gibt noch keine Kommentare!";
	}
    while ($row = $dbpre->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class=\"comment\"><b>Geschrieben von: ".nocss($row['autor'])." am: ".nocss($row['date'])."</b> <a href=\"index.php?admin=deletecomments&id=".nocss($row['id'])."\">Löschen</a><br>".nocss($row['comment'])."</div>\n";
    }
?>
