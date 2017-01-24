<?php
  // Устанавливает лимит времени исполнения для этого файла (связано с тайм-аутом)
  
  
	set_time_limit (500);
  // Адреса отправителя
	$mail1="EMECS'11 SeaCoasts XXVI <foxy@rshu.ru>";
 	$mail2="EMECS'11 SeaCoasts XXVI <ggg@rshu.ru>";
	$mail3="EMECS'11 SeaCoasts XXVI <amberx19@gmail.com>"; 

  // Обрабатываем адреса для отображения в форме
	$tmail1=htmlspecialchars($mail1);
 	$tmail2=htmlspecialchars($mail2);
	$tmail3=htmlspecialchars($mail3); 
	
  // Далее идёт сам скрипт
  // Если массив POST не пустой, отправка состоялась
	if (!empty($_POST) && !isset($sent)) {
  
// Определяем переменные
	$emailer_subj = $_POST['emailer_subj'];
	$emailer_mails = $_POST['emailer_mails'];
	$emailer_text = $_POST['emailer_text'];
	$emailer_yourmail = $_POST['emailer_yourmail'];

    // Теперь проверяем заполнение всех полей
	if (empty($emailer_subj) || $emailer_subj=="Тема письма") {
    // Если тема пустая...
    $mail_msg='<b>Вы не ввели тему письма</b>';
  } elseif (empty($emailer_mails) || $emailer_mails=="Почтовые адрсе") {
    // Если адресов нет...
    $mail_msg='<b>Не указаны адреса получателей</b>';
  } elseif (empty($emailer_text) || $emailer_text=="Текст письма") {
    // Если сообщение пустое...
    $mail_msg='<b>Вы не ввели текст письма</b>';
  } else { // Если все поля заполнены верно...
    // Готовим сообщение об успешной отправке... Вдруг у вас какой-то необычный браузер
    $mail_msg='Ваше сообщение отправлено.<br>Нажмите <a href="'.$_SERVER['REQUEST_URI'].'">здесь</a>, если ваш браузер не поддерживает перенаправление.';
    // Готовим заголовки письма... Будем отправлять письма в формате HTML и кодировке UTF-8
    $headers="MIME-Version: 1.0\r\n";
    $headers.="Content-type: text/html; charset=utf-8\r\n";
    $headers.="From: $emailer_yourmail";
	
	// Обработка письма. Нужно удалить лишние пробелы и проставить переносы.
	$emailer_text=preg_replace("/ +/"," ",$emailer_text); // множественные пробелы заменяются на одинарные
	$emailer_text=preg_replace("/(\r\n){3,}/","\r\n\r\n",$emailer_text); // убираем лишние переносы (больше 1 строки)
	$emailer_text=str_replace("\r\n","<br>",$emailer_text); // ставим переносы
	
	// Получаем массив адресов. В качестве разделителя у нас используется запятая.
	$emails=explode(",", $emailer_mails);
	$count_emails = count($emails); // Подсчёт количества адресов
	// Запускаем цикл отправки сообщений
    for ($i=0; $i<=$count_emails-1; $i++) // Отчёт начинается в массиве с нуля, поэтому уменьшаем сумму на единицу
    {
    // Подставляем адреса получаетелей и обрезаем пробелы с обоих сторон, если таковые имеются
    $email=trim($emails[$i]);
    // Отправляем письмо и готовим отчёт по отправке
	if($emails[$i]!="") { // Проверка на случай попадения в массив пустого значения
    if(mail($email,$emailer_subj,$emailer_text,$headers)) $report.="<li><span style=\"color:green;\">Отправлено: ".$emails[$i]."</span></li>"; else $report.="<li><span style=\"color:red;\">Не отправлено: ".$emails[$i]."<span></li>";
	sleep(5); // Делаем тайм-аут в 5 секунд
	}
    }
	
	// Запись отчёта в файл. Файл будет сгенерирован в той же папке, под названием log.txt. Проверьте настройку прав папки.
	$log=fopen("log.txt","w");
	fwrite($log,$report);
	fclose($log);
    // Переменная $sent – признак успешной отправки
    $sent=1;
  }
} else { // Если в массиве POST пусто, форма еще не передавалась
  // Готовим приглашение
  $mail_msg='Все поля обязательны для заполнения.';
  // Поля темы, адресов получаетелей и получателей, и текста в этом случае должны быть пустыми
  $emailer_text=$emailer_subj=$emailer_mails=$emailer_yourmail='';
}

  // Если $sent не существует, выводим форму или отчёт
	if (!isset($sent)) {
  // Если сообщение уже отправлено - выводим отчёт
    if(isset($_GET['messent']))
	{echo $text.="<b style=\"text-align:center;margin-top:200px;display:block;\">Всё окей. Сообщение отправлено. <a href=\"mail.php\">Ещё?</a><br><br><u>Отчёт:</u></b> <ol style=\"display:block;width:300px;margin:10px auto;\">";
	readfile("log.txt");
	echo"</ol>";}
	else {
  // Или выводим форму, если сообщение ещё не отправлено
    echo $text.=<<<post
    <script type="text/javascript">
    function form_validator(form) {
    if (form.emailer_subj.value=='' || form.emailer_subj.value=='Тема письма') { alert('Укажите тему письма.'); form.emailer_subj.focus(); return false; }
    if (form.emailer_mails.value=='' || form.emailer_mails.value=='Почтовые адреса') { alert('Укажите адреса получаталей.'); form.emailer_mails.focus(); return false; }
    if (form.emailer_text.value=='' || form.emailer_text.value=='Текст письма') { alert('Вы не заполнили поле сообщения.'); form.emailer_text.focus(); return false; }
    return true;
    }
    </script>
	<style type="text/css">
	form {display:block;margin:20px auto;width:500px;}
	textarea, input, select {width:100%; margin:5px 0;}
	textarea {height:200px;}
	.red {color:#a00;}
	</style>
    <form method="post" onsubmit="return form_validator(this);">
	<p class="red">$mail_msg</p>
	<input type="text" name="emailer_subj" id="emailer_subj" value="Тема письма" title="По какому поводу пишем?" onfocus="if (this.value=='Тема письма') this.value='';" onblur="if (this.value=='') this.value='Тема письма';">
	<textarea name="emailer_mails" id="emailer_mails" title="Кто получатели?" onfocus="if (this.value=='Почтовые адреса') this.value='';" onblur="if (this.value=='') this.value='Почтовые адреса';">Почтовые адреса</textarea>
	<textarea name="emailer_text" id="emailer_text" title="Что пишем?" onfocus="if (this.value=='Текст письма') this.value='';" onblur="if (this.value=='') this.value='Текст письма';">Текст письма</textarea>
	<select name="emailer_yourmail">
	<option value="$mail1">$tmail1</option>
	<option value="$mail2">$tmail2</option>
	<option value="$mail3">$tmail3</option>
	</select>
	<input type="submit" value="Отправить" title="Отправить мыл">
	</form>
post;
}
}
else { // А если существует...
  // Посылаем в заголовке редирект (303 Refresh) на этот же адрес с дополнительным параметром messent
  $ret_uri=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  header("Refresh: 0; URL=http://".$ret_uri."?messent");
  exit;
}


?>