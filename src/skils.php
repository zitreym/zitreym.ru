<section class="skils">
    <h3 class="section_title">Навыки</h3>
    <div class="skils_wrp">
    <h4 class="skils_title">Использую сейчас:</h4>
<?
$mysqli = new mysqli("localhost", "zitreym_zitreym", "Despxamv123", "zitreym_db");
$result = $mysqli->query("SELECT * FROM skils WHERE type = 1");
$result = $result->fetch_all();
foreach ($result as $row) {
?>
<div class="skils_box">
<img src="/static/img/skils/<? echo $row[2]; ?>" alt="<? echo $row[1]; ?>" class="skils_img">
<p class="skils_txt"><? echo $row[1]; ?></p>
</div>
<?
}
?>
    <h4 class="skils_title">Изучаю:</h4>
<?
$result = $mysqli->query("SELECT * FROM skils WHERE type = 2");
$result = $result->fetch_all();
foreach ($result as $row) {
?>
<div class="skils_box">
<img src="/static/img/skils/<? echo $row[2]; ?>" alt="<? echo $row[1]; ?>" class="skils_img">
<p class="skils_txt"><? echo $row[1]; ?></p>
</div>
<?
}
?>
    <h4 class="skils_title">Прочие навыки:</h4>
<?
$result = $mysqli->query("SELECT * FROM skils WHERE type = 3");
$result = $result->fetch_all();
foreach ($result as $row) {
?>
<div class="skils_box">
<img src="/static/img/skils/<? echo $row[2]; ?>" alt="<? echo $row[1]; ?>" class="skils_img">
<p class="skils_txt"><? echo $row[1]; ?></p>
</div>
<?
}
?>
    </div>
</section>