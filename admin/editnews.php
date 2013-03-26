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
    $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		if (mysql_num_rows($result) == 0) {
	    echo "Es gibt noch keine News!";
	}
    while ($row = mysql_fetch_assoc($result)) {
        echo "<div class=\"comment\"><b>".$row['title']."</b> <a href=\"index.php?admin=postnews&id=".$row['id']."&action=edit\">Bearbeiten</a><br>Autor: ".$row['autor']." | Datum: ".$row['date']."</div>\n";
    }
?>