<!DOCTYPE html>
<html lang="es">

<head>
	<?php
	require 'parts/head.view.php'
	?>
	<link rel="stylesheet" type="text/css" href="/assets/css/profesionales.css" />
</head>

<body>
	<!-- Header del sitio -->
	<?php
	require 'parts/header.view.php'
	?>

	<!-- Sección acerca de los profesionales de la institución -->
	<main>
		<section class="profesionales">
			<!-- Título -->
			<h2>Profesionales</h2>
			<!-- Input de búsqueda -->
			<form action="/profesionales" method="get">
				<input type="text" class="search" name="search" id="search" placeholder="Ingresar nombre/apellido/especialidad" value="<?= $query ?>"/>
				<!-- Botón de búsqueda -->
				<input class="secondary" type="submit" value="Buscar">
			</form>

			<!-- x3 información de los profesionales -->
			<ul class="lista-profesionales">
				<li class="profesional">
					<!-- Imagen de perfil del profesional -->
					<img src="assets/images/profesional1.png" alt="Profesional">
					<!-- Nombre del profesional -->
					<p class="profesional-nombre">Dr. Ali Vefa</p>
					<!-- Especialidades -->
					<p class="profesional-especialidad">Especialidades: Neurocirujano</p>
					<!-- Estudios -->
					<p class="profesional-estudio">Estudios: Universidad Austral</p>
					<!-- Botón para solicitar turno con ese profesional -->
					<a class="button secondary" href="/solicitarTurno?profesional=1">Solicitar Turno</a>
				</li>
				<li class="profesional">
					<!-- Imagen de perfil del profesional -->
					<img src="assets/images/profesional2.jpg" alt="Profesional">
					<!-- Nombre del profesional -->
					<p class="profesional-nombre">Dr. Rivero Lucas</p>
					<!-- Especialidades -->
					<p class="profesional-especialidad">Especialidades: Kinesiologo / Anestesista</p>
					<!-- Estudios -->
					<p class="profesional-estudio">Estudios: Universidad de Buenos Aires</p>
					<!-- Botón para solicitar turno con ese profesional -->
					<a class="button secondary" href="/solicitarTurno?profesional=2">Solicitar Turno</a>
				</li>
				<li class="profesional">
					<!-- Imagen de perfil del profesional -->
					<img src="assets/images/profesional3.jpg" alt="Profesional">
					<!-- Nombre del profesional -->
					<p class="profesional-nombre">Dr. Gregory House</p>
					<!-- Especialidades -->
					<p class="profesional-especialidad">Especialidades: Nefrólogo / Infectólogo / Jefe de departamento de diagnósticos</p>
					<!-- Estudios -->
					<p class="profesional-estudio">Estudios: Universidad John Hopkins</p>
					<!-- Botón para solicitar turno con ese profesional -->
					<a class="button secondary" href="/solicitarTurno?profesional=3">Solicitar Turno</a>
				</li>
			</ul>

			<!-- Paginado -->
			<?php require 'parts/pagination.view.php' ?>
		</section>
	</main>

	<!-- Footer del sitio -->
	<?php
	require 'parts/footer.view.php'
	?>
</body>

</html>