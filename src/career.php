<section class="career">
    <div class="career_title_wrp">
        <h3 class="section_title">Карьера</h3>
    </div>
    <div class="career_wrp">
<?php
$career = $mysqli->query("SELECT * FROM career ORDER BY id DESC");
$career = $career->fetch_all();
foreach ($career as $career_item) {
?>
        <div class="career_box">
            <a href="#" class="career_company_logo <? echo $career_item[5]; ?>"></a>
            <div class="career_text_wrp">
                <p class="career_text_title"><? echo $career_item[1]; ?></p>
                <p class="career_text_date"><? echo $career_item[2]; ?></p>
                <p class="career_text_town"><? echo $career_item[3]; ?></p>
                <p class="career_text"><? echo $career_item[4]; ?></p>
            </div>
        </div>
        <? } ?>
        <a class="career_box">Моя лента</a>
    </div>
</section>