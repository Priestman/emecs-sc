<?php
// несколько получателей
$to  = 'alexandr.ermolov@gmail.com' . ', ';
$to .= 'baranovwlad@mail.ru' . ', '; // обратите внимание на запятую
$to .= 'kuklev@ecologpro.ru';

// тема письма
$subject = 'Personal account';

// текст письма
$message = '
<html>
<head>
  <title>Персональная информация</title>
</head>
<body>
  <p>Уважаемые участники конференции!</p>
  <p>Информируем Вас о том, что информацию в личном кабинете необходимо заполнять <b>только</b> на английском языке<br>
   В связи с этим просим Вас отредактировать свои данные. <br><br>
   
   С уважением и наилучшими пожеланиями,<br>
   Техническая поддержка конференции.
  </p>
</body>
</html>
';

// Для отправки HTML-письма должен быть установлен заголовок Content-type
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Дополнительные заголовки
/* $headers .= 'To: Nick <nnpopow@gmail>, Alyssa <example@example.com>' . "\r\n"; */
$headers .= 'From: EMECS11 SeaCoasts XXVI <foxy@rshu.ru>' . "\r\n";
/* $headers .= 'Cc: nnpopow@gmail.com' . "\r\n"; */
$headers .= 'Bcc: liiss.ru@gmail.com' . "\r\n";

// Отправляем
if (mail($to, $subject, $message, $headers)) { 
    echo "messege acepted for delivery"; 
} else { 
    echo "some error happen"; 
} 
?>