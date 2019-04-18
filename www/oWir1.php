<?php
header("Content-Type: text/html; charset=utf-8");

require_once 'key/viewNomy3.php';
// session_start();
display_head("Узнаём О нас");
?>
    <h2>"Что такое Увлажнитель воздуха?" </h2>
<div class="oplat"> 
	<ul>
		<li>
	    <p>Наша история тянется ещё с военных сборов, когда весь день шел дождь.</p>
		</li>
		<li>
	    <p>..и совсем, кажется, недавно we началi собирать свой ээ.. "Увлажнитель воздуха".</p></br>
		</li>
		<p>Сегодня она стал такой.	
			<img src="image/scrin/1-410-2.jpg" class="history_pic" />
		</p>
		<div class="video">
			<li>
			<p>Наш любимый мультик.</p><br\>
			<video width="400" height="300" controls="controls" poster="image/ok.png">
			<source src="image/tovar/Nu.Pogodi.mp4" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
			Тег video не поддерживается вашим браузером. 
			<a href="image/tovar/Nu.Pogodi.mp4">Скачайте видео</a>
			</video>
			</li>
		</div>
	</ul>
</div>

<?php
   include('key/footer.php');
?>