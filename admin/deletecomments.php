<div class="title">Kommentare l�schen</div>
<?php
if(isset($_GET['id'])){
      mysql_query("DELETE FROM wronnay_news_comments WHERE id='".mysql_real_escape_string($_GET['id'])."'");
	  echo "<div class=\"erfolg\">Der Kommentar wurde gel�scht!</div>";
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
    $result = mysql_query($sql) OR die("<pre>\n".$sql."</pre>\n".mysql_error());
		if (mysql_num_rows($result) == 0) {
	    echo "Es gibt noch keine Kommentare!";
	}
    while ($row = mysql_fetch_assoc($result)) {
        echo "<div class=\"comment\"><b>Geschrieben von: ".$row['autor']." am: ".$row['date']."</b> <a href=\"index.php?admin=deletecomments&id=".$row['id']."\">L�schen</a><br>".$row['comment']."</div>\n";
    }
?>