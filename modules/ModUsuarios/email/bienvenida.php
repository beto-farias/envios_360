<?php 
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type"
	content="text/html; charset=<?= Yii::$app->charset ?>" />
<title>Bienvenida</title>
</head>
<body>
	<header> </header>
	<section>
		<h1>Bienvenido</h1>

        <p>Hola <?=$user?> te damos la bienvenida</p>
        <p>Usuario: <?=$email?></p>
        <p>Contraseña: <?=$password?></p>
		<p>
			Para ingresar al sitio automaticamente hazlo desde el siguiente <a
				href='<?=$url?>'>link</a>
		</p>
		<p>-Equipo 2 Geeks one Monkey</p>
	</section>
	<footer> </footer>


</body>
</html>
