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
<!-- save_user.php - ��� ����� �����������. �� ����, ����� ������� �� ������ "������������������", ������ �� ����� ���������� �� ��������� save_user.php ������� "post" -->
  <p>
    <label>Login *:<br></label>
    <input name="login" type="text" size="15" maxlength="15" placeholder="Only letters and/or numbers, without spaces">
  </p>
<!-- � ��������� ���� (name="login" type="text") ������������ ������ ���� ����� -->  
  <p>
    <label>Password *:<br></label>
    <input name="password" type="password" size="15" maxlength="15">
  </p>
<!-- � ���� ��� ������� (name="password" type="password") ������������ ������ ���� ������ -->  
  <p>
    <label>E-mail *:<br></label>
    <input name="email" type="text" size="15" maxlength="100">
  </p>
<!-- ������ �-���� -->  
  
<!--  <p>
    <label>Choose an avatar. The image format must be jpg, gif or png:<br></label>
    <input type="FILE" name="fupload">
  </p> 
� ���������� fupload ���������� �����������, ������� ������ ������������. --> 
<p>Enter the code from the image *:<br>

<p><img src="code/my_codegen.php"></p>
<p><input type="text" name="code"></p>
<!-- � code/my_codegen.php ������������ ��� � �������� ����������� --> 

<p>
<input type="submit" name="submit" value="Submit">
<!-- �������� (type="submit") ���������� ������ �� ��������� save_user.php  -->  
</p></form>
All fields required.
</div>
</center>
</body>
</html>
