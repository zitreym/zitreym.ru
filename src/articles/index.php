<?php
require("../header.php");
?>
<section class="articles_page">


<?
$result = $mysqli->query("SELECT * FROM articles");
$result = $result->fetch_all();
foreach ($result as $row) {
?>
<div class="articles_box" style="background-image: url('/static/img/articles/<? echo $row[4]; ?>');">
    <h2 class="articles_header"><? echo $row[1]; ?></h2>
    <a href="#" class="articles_button"></a>
</div>
<?
}
?>
</section>
<?php
require("../footer.php");
?>