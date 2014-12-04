<?php
error_reporting(0);
include 'config.php';
if (!isset ($DB)) { header("Location: install/index.php"); }
include 'data.php';
function nocss($nocss) {
  $nocss = strip_tags($nocss);
  $nocss = htmlspecialchars($nocss);
  return $nocss;
}
include 'design/header.php';
$dbc = new PDO(''.$DBTYPE.':host='.$HOST.';dbname='.$DB.'', ''.$USER.'', ''.$PW.'');
$dbc->query("SET CHARACTER SET utf8");
    $sql = "SELECT
            id,
            autor,
            title,
            news,
            date,
			description,
			keywords
        FROM
            wronnay_news
        ORDER BY
            date DESC
		LIMIT 
		    15
		";
    $dbpre = $dbc->prepare($sql);
    $dbpre->execute();
			if ($dbpre->rowCount() < 1) {
	    echo "Es gibt noch keine News!";
	}
    while ($row = $dbpre->fetch(PDO::FETCH_ASSOC)) {
	$dbpre1 = $dbc->prepare("SELECT id FROM wronnay_news_comments WHERE news_id = '".$row['id']."'");
	$dbpre1->execute();
	$comments = $dbpre1->rowCount();
include 'design/news.php';
    }
include 'design/footer.php';
?>
