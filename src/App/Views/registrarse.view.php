<!DOCTYPE html>
<html lang="es">
<head>
	<?php
		require 'parts/head.view.php'
	?>
	<link rel="stylesheet" type="text/css" href="/assets/css/registrarse.css" />
</head>
<body>
	<!-- Header del sitio -->
	<?php
		require 'parts/header.view.php'
	?>
	<main>
		<section>
			<h2>Registrarse</h2>
			<form action="./registrarse.html" method="post">
				<label for="email">Correo Electrónico:</label>
				<input type="email" name="email" id="email" placeholder="juan@ejemplo.com" required />

				<label for="password">Contraseña:</label>
				<input type="password" name="password" id="password" required />

				<label for="repassword">Repetir contraseña:</label>
				<input type="password" name="repassword" id="repassword" required />

				<label for="fullname">Nombre y Apellido:</label>
				<input type="text" name="fullname" id="fullname" placeholder="Juan Perez" required />

				<label for="phone">Teléfono Celular:</label>
				<input type="tel" name="phone" id="phone" required placeholder="111111111"/>

				<label for="birthdate">Fecha de nacimiento:</label>
				<input type="date" name="birthdate" id="birthdate" required />

				<input type="submit" value="Registrarse">
			</form>
		</section>
	</main>
	<!-- Footer del sitio -->
	<?php
		require 'parts/footer.view.php'
	?>
</body>
</html>