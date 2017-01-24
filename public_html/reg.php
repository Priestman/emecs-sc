<html>
<head>
<center>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css" />
<title>Registration</title>
</head>
<body>
<div class="box">
<h2>Registration</h2>
<form action="save_user.php" method="post" enctype="multipart/form-data">
<!-- save_user.php - это адрес обработчика. То есть, после нажатия на кнопку "Зарегистрироваться", данные из полей отправятся на страничку save_user.php методом "post" -->
  <p>
    <label>Login *:<br></label>
    <input name="login" type="text" size="15" maxlength="15" placeholder="Only letters and/or numbers, without spaces">
  </p>
<!-- В текстовое поле (name="login" type="text") пользователь вводит свой логин -->  
  <p>
    <label>Password *:<br></label>
    <input name="password" type="password" size="15" maxlength="15">
  </p>
<!-- В поле для паролей (name="password" type="password") пользователь вводит свой пароль -->  
  <p>
    <label>E-mail *:<br></label>
    <input name="email" type="text" size="15" maxlength="100">
  </p>
<!-- Вводим е-майл -->  
  
<!--  <p>
    <label>Choose an avatar. The image format must be jpg, gif or png:<br></label>
    <input type="FILE" name="fupload">
  </p> 
В переменную fupload отправится изображение, которое выбрал пользователь. --> 
<p>Enter the code from the image *:<br>

<p><img src="code/my_codegen.php"></p>
<p><input type="text" name="code"></p>
<!-- В code/my_codegen.php генерируется код и рисуется изображение --> 

<p>
<input type="submit" name="submit" value="Submit">
<!-- Кнопочка (type="submit") отправляет данные на страничку save_user.php  -->  
</p></form>
All fields required.
</div>
</center>
</body>
</html>
