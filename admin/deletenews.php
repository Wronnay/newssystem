<div class="title">News löschen</div>
<?php
if(isset($_GET['id'])){
      mysql_query("DELETE FROM wronnay_news WHERE id='".mysql_real_escape_string($_GET['id'])."'");
      mysql_query("DELETE FROM wronnay_news_comments WHERE news_id='".mysql_real_escape_string($_GET['id'])."'");
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
    $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		if (mysql_num_rows($result) == 0) {
	    echo "Es gibt noch keine News!";
	}
    while ($row = mysql_fetch_assoc($result)) {
        echo "<div class=\"comment\"><b>".$row['title']."</b> <a href=\"index.php?admin=deletenews&id=".$row['id']."\">Löschen</a><br>Autor: ".$row['autor']." | Datum: ".$row['date']."</div>\n";
    }
?>