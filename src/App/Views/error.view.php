<!DOCTYPE html>
<html lang="es">

<head>
	<?php
	require 'parts/head.view.php'
	?>
	<style>
		main > section > p, main > section > a {
			margin: 1rem;
		}
	</style>
</head>

<body>
	<!-- Header del sitio -->
	<?php
	require 'parts/header.view.php'
	?>

	<main>
		<section>
			<!-- Título -->
			<h2>Error: <?=$errorCode ?? '500' ?></h2>
			<!-- Registrarse -->
			<p><?= $errorMessage ?? '¡Lo sentimos! Ha ocurrido un error insperado' ?></p>
			<a href="/">Volver al inicio</a>
		</section>
	</main>
	<!-- Footer del sitio -->
	<?php
	require 'parts/footer.view.php'
	?>
</body>

</html>