<div class="news">
<div class="title">
<?php echo "".nocss($row['title'])."" ?>
</div>
<div class="text">
<?php echo "".nocss($row['news'])."" ?>
</div>
<div class="infos">
Autor: <?php echo "".nocss($row['autor'])."" ?> | Vom: <?php echo "".nocss($row['date'])."" ?>
</div>
<div class="comments">
<a href="news.php?id=<?php echo "".nocss($row['id'])."" ?>">(Kommentare: <?php echo "".nocss($comments)."" ?> | Zum Anschauen und Schreiben bitte klicken)</a>
</div>
</div>
