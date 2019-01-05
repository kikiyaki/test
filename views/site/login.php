<head>

  <style>

    .width {
      width:250px;
    }

  </style>

</head>

<h3>
  Вход
</h3>

<h4 style="color:red;">

<?php
if (isset($message))
  echo $message;
?>

<h4>

<form method="post" action="log">
Логин</br>
<input type="text" class="form-control width" name="login" value="

<?php
if (isset($login))
  echo $login;
?>
" >
</br>
Пароль</br>
<input type="password" class="form-control width" name="pass" >
</br>
<input type="submit" class="btn" value="Войти">

</form>
