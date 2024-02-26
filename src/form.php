<section id="form" class="form">
    <h3 class="section_title">Связаться</h3>
    <p class="form_description">Через данную форму вы можете связаться со мной, оставить заявку на получение какой-либо услуги, а также поделиться обратной связью</p>
    <div class="span_section"></div>
    <form action="<?php
            $db_table = "form"; // Имя Таблицы БД
            $name_user = $_POST['name_user'];
            $email_user = $_POST['email_user'];
            $telephone_user = $_POST['telephone_user'];
            $message_user = $_POST['message_user'];
            $name_user = htmlspecialchars($name_user);
            $email_user = htmlspecialchars($email_user);
            $telephone_user = htmlspecialchars($telephone_user);
            $message_user = htmlspecialchars($message_user);
            $name_user = urldecode($name_user);
            $email_user = urldecode($email_user);
            $telephone_user = urldecode($telephone_user);
            $message_user = urldecode($message_user);
            $name_user = trim($name_user);
            $email_user = trim($email_user);
            $telephone_user = trim($telephone_user);
            $message_user = trim($message_user);
            if ($telephone_user > 1) {
             mail("desp_xamv@mail.ru", "Заявка с сайта", "Имя:".$name_user.". E-mail: ".$email_user.". Телефон: ".$telephone_user.". Сообщение: ".$message_user ,"From: desp_xamv@mail.ru \r\n");
             // Собираем данные для запроса
$data = array( 'name' => $name_user, 'text' => $message_user, 'phone' => $telephone_user, 'mail' => $email_user ); 
// Подготавливаем SQL-запрос
$query = $db->prepare("INSERT INTO $db_table (name, text, phone, mail) values (:name, :text, :phone, :mail)");
// Выполняем запрос с данными
$query->execute($data);
            }
             ?>" method="post">
        <input type="text" class="form_input" placeholder="ВАШЕ ИМЯ*">
        <input type="text" class="form_input" placeholder="ВАША ПОЧТА*">
        <input type="text" class="form_input" placeholder="НОМЕР ТЕЛЕФОНА">
        <textarea class="form_input form_message" placeholder="ВАШЕ СООБЩЕНИЕ*"></textarea>
        <input type="submit" value="ОТПРАВИТЬ" class="form_button">
    </form>
    <?php
        if ($telephone_user > 1) {
        echo "<script>alert('Спасибо за обратную связь!')</script>";
        }
        ?>
</section>