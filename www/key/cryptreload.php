<?php
header("Content-Type: text/html; charset=utf-8");
$password = trim($_POST['password']);
$username = trim($_POST['username']);
if(empty($username) || empty($password)) {
echo <<<EOD
<html>
  <div id="content">
    <h1> Узнать пароль жертвы!? </h1>
    <form id="signin_form" 
          action="cryptreload.php" 
          method="POST">
      <fieldset>
        <label for="username">name:</label>
        <input type="text"  name="username" id="username" size="20" 
                />
        <br />
        <label for="password">Password:</label>
        <input type="password"  name="password" id="password" size="20" />
      </fieldset>
      <br />
      <fieldset class="center">
        <input type="submit" value="Sign In" />
      </fieldset>
    </form>
  </div>
  <div id="footer"></div>
 </body>
</html>
EOD;
} else { 
$x = crypt($password,$username);
echo <<<EOD
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/phpMM.css">
  <a href="../title2.php"> <title>Увлажнитель воздуха</title> </a>
 </head>
  <div id="content">
    <h1> A вот и он! </h1>
   <p>Для - $username его(её) пароль - $password</p></br>
    <p class="lol"> тадамЖ: $x .</p>
  </div>
  <div id="footer">JIexa 2015!!!</div>
 </body>
</html>
EOD;

}
?>