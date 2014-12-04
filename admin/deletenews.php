<div class="title">News löschen</div>
<?php
if(isset($_GET['id'])){
      $dbpre = $dbc->prepare("DELETE FROM wronnay_news WHERE id='".$_GET['id']."'");
      $dbpre->execute();
      $dbpre = $dbc->prepare("DELETE FROM wronnay_news_comments WHERE news_id='".$_GET['id']."'");
      $dbpre->execute();
	  echo "<div class=\"erfolg\">Die News und die Kommentare zur News wurden gelöscht!</div>";
}
    $sql = "SELECT
	                id,
	                autor,
					title,
					date
            FROM
                    wronnay_news
            ORDER BY
                    date DESC
           ";
    $dbpre = $dbc->prepare($sql);
    $dbpre->execute();
		if ($dbpre->rowCount() < 1) {
	    echo "Es gibt noch keine News!";
	}
    while ($row = $dbpre->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class=\"comment\"><b>".nocss($row['title'])."</b> <a href=\"index.php?admin=deletenews&id=".nocss($row['id'])."\">Löschen</a><br>Autor: ".nocss($row['autor'])." | Datum: ".nocss($row['date'])."</div>\n";
    }
?>
