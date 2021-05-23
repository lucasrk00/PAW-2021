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
			<?php
			require 'parts/statusResultMessage.view.php'
			?>
			<form action="/registrarse" method="post">
				<label for="email">Correo Electrónico:</label>
				<input type="email" name="email" id="email" placeholder="juan@ejemplo.com" value="<?=$fields['email']?? '' ?>" required />

				<label for="password">Contraseña:</label>
				<input type="password" name="password" id="password" required />

				<label for="repassword">Repetir contraseña:</label>
				<input type="password" name="repassword" id="repassword" required />

				<label for="nombreApellido">Nombre y Apellido:</label>
				<input type="text" name="nombreApellido" id="funombreApellidollname" value="<?=$fields['nombreApellido'] ?? '' ?>" placeholder="Juan Perez" required />

				<label for="telefono">Teléfono Celular:</label>
				<input type="tel" name="telefono" id="telefono" required value="<?=$fields['telefono'] ?? '' ?>" placeholder="111111111" />

				<label for="fechaNacimiento">Fecha de nacimiento:</label>
				<input type="date" name="fechaNacimiento" id="fechaNacimiento" value="<?=$fields['fechaNacimiento'] ?? '' ?>" required />

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