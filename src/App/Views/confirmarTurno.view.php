<!DOCTYPE html>
<html lang="es">

<head>
	<?php
	require 'parts/head.view.php'
	?>
	<link rel="stylesheet" type="text/css" href="/assets/css/confirmarTurno.css" />
</head>

<body>
	<!-- Header del sitio -->
	<?php
	require 'parts/header.view.php'
	?>

	<main>
		<section>
			<h2>Confirmar Turno</h2>
			<p>Especialidad <?= $turno->especialidad->nombre ?></p>
			<p>Profesional <?= $turno->profesional->nombre ?></p>
			<p>Fecha <?= $turno->fechaHora ?></p>

			<form action="/confirmarTurno?turno=<?=$turno->id?>" method="post">
				<button class="secondary">Confirmar</button>
			</form>
		</section>
	</main>
	<!-- Footer del sitio -->
	<?php
	require 'parts/footer.view.php'
	?>
</body>

</html>