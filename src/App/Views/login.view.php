<!DOCTYPE html>
<html lang="es">

<head>
	<?php
	require 'parts/head.view.php'
	?>
	<link rel="stylesheet" type="text/css" href="/assets/css/login.css" />
</head>

<body>
	<!-- Header del sitio -->
	<?php
	require 'parts/header.view.php'
	?>

	<main>
		<section>
			<!-- Título -->
			<h2>Iniciar Sesión</h2>
			<?php
			require 'parts/statusResultMessage.view.php'
			?>
			<!-- Form inicio de sesión -->
			<form method="post" action="/login">
				<label for="email">Email:</label>
				<input type="email" name="email" id="email" placeholder="test@test.com" required />
				<label for="password">Contraseña:</label>
				<input type="password" name="password" id="password" required />
				<input type="submit" value="Iniciar sesión" />
			</form>
			<!-- Registrarse -->
			<p>¿No tenés cuenta? <a href="/registrarse">Registrarse</a></p>
		</section>
	</main>
	<!-- Footer del sitio -->
	<?php
	require 'parts/footer.view.php'
	?>
</body>

</html>