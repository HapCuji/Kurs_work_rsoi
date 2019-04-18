<?php
 session_start();
  require 'config.php';
 header("Content-Type: text/html; charset=utf-8");


  if (isset($_SESSION['error_message'])) {
    $error_message = preg_replace("/\\\\/", '', $_SESSION['error_message']);
  } else {
    $error_message = "something went wrong, and that's how you ended up here.";
  }

  if (isset($_SESSION['system_error_message'])) {
    $system_error_message = preg_replace("/\\\\/", '', $_SESSION['system_error_message']);
  } else {
    $system_error_message = "Сообщения о системных ошибках отсутствуют.";
  }
?>

<html>
 <head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link href="../css/phpMM.css" rel="stylesheet" type="text/css" />
  
 </head>

 <body>
 

 
 <div id="content">
<h1> Нам очень жаль...</h1>
<p><img src="../image/error2.jpg" class="error" />
<?php echo $error_message; ?>
(<?php echo $system_error_message; ?>)
<span></p>
<p> Не волнуйтесь, мы в курсе происходящего и предпримем все необходимые
меры. Если же вы хотите связаться с нами и узнать подробности произошедшего
или вас что-нибудь беспокоит в сложившейся ситуации, пришлите нам
<a href="mailto:m-o-n-c-t-e-p-c@mail.ru">сообщение</a>, и мы непременно
откликнемся.</p>
<p> А сейчас, если вы желаете вернуться на страницу, ставшую причиной
проблемы, то можете <a href="javascript:history.go(-1);">щелкнуть здесь</a> или вернитесь на <a href="../title2.php">главную страницу.</a>
Если возникнет такая же проблема, то вы можете вернуться на страницу чуть
позже. Уверены, что к тому времени, как вы дочитаете до конца - мы во всем разберемся. Еще раз спасибо...
надеемся на ваше скорое возвращение. И еще раз извините за причиненные
неудобства.</p>

</div>
<div id="footer"></div>
</body>
</html>

