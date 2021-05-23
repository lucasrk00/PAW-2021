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
				<?php foreach($profesionales as $profesional): ?>
				<li class="profesional">
					<!-- Imagen de perfil del profesional -->
					<img src="<?=$profesional->imagenUrl ?>" alt="Profesional">
					<!-- Nombre del profesional -->
					<p class="profesional-nombre"><?=$profesional->nombre?></p>
					<!-- Especialidades -->
					<p class="profesional-especialidad">Especialidades:
						<?php
						$especialidadesStr ="";
						foreach($profesional->especialidades as $especialidad) {
							$especialidadesStr .= $especialidad->nombre . ", ";
						}
						echo substr($especialidadesStr, 0, -2);
						?>
					</p>
					<!-- Estudios -->
					<p class="profesional-estudio">Estudios: <?=$profesional->estudios?></p>
					<!-- Botón para solicitar turno con ese profesional -->
					<a class="button secondary" href="/solicitarTurno?profesional=<?=$profesional->id?>">Solicitar Turno</a>
				</li>
				<?php endforeach; ?>
			</ul>
			<?php if(count($profesionales) <= 0): ?>
			<p>No se han encontrado resultados</p>
			<?php endif; ?>

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