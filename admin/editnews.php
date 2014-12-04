<div class="title">News bearbeiten</div>
<?php
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
        echo "<div class=\"comment\"><b>".nocss($row['title'])."</b> <a href=\"index.php?admin=postnews&id=".nocss($row['id'])."&action=edit\">Bearbeiten</a><br>Autor: ".nocss($row['autor'])." | Datum: ".nocss($row['date'])."</div>\n";
    }
?>
