<!DOCTYPE html>
<html lang="es">

<head>
	<?php
	require 'parts/head.view.php'
	?>
	<link rel="stylesheet" type="text/css" href="/assets/css/home.css" />
</head>

<body>
	<!-- Header del sitio -->
	<?php
	require 'parts/header.view.php'
	?>
	<!-- Contenido del sitio -->
	<main class="home">
		<!-- Sección de solicitar turno -->
		<section class="solicitar-turno">
			<div>
				<h2>Solicitar turno</h2>
				<form action="/solicitarTurno" method="get">
					<!-- Especialidad del Turno -->
					<label for="especialidad">Especialidad:</label>
					<select name="especialidad" id="especialidad" required>
						<option value="">Seleccione una especialidad</option>
						<?php foreach ($especialidades as $el) : ?>
							<option <?php if (isset($especialidad) && $el->id == $especialidad) {
										echo "selected";
									} ?> value="<?= $el->id ?>"><?= $el->nombre ?></option>
						<?php endforeach; ?>
					</select>
					<!-- Fecha del turno -->
					<label for="fecha">Fecha:</label>
					<input type="date" name="fecha" id="fecha" required />
					<!--Horario del turno-->
					<label for="hora">Hora:</label>
					<input type="time" name="hora" id="hora" required />
					<input type="submit" value="Continuar" />
				</form>
			</div>
		</section>
		<!-- Sección de noticias del sitio -->
		<section class="novedades">
			<h2>Novedades</h2>
			<?php
			foreach ($noticias as $noticia) :
			?>
				<article class="novedad">
					<!-- Imágen del artículo -->
					<img src="<?= $noticia->imagenUrl ?>" alt="<?= $noticia->nombre ?>" />
					<!-- Título del artículo -->
					<h3><?= $noticia->nombre ?></h3>
					<!-- Fecha del artículo -->
					<p class="fecha"><?= $noticia->createdAt ?></p>
					<!--Contenido de la novedad-->
					<p><?= substr($noticia->texto, 0, 50) ?>...</p>
					<!-- Botón "Ver Mas" del artículo -->
					<a class="button" href="/noticia?id=<?= $noticia->id ?>">Ver Más</a>
				</article>
			<?php endforeach; ?>
		</section>
	</main>
	<!-- Footer del sitio -->
	<?php
	require 'parts/footer.view.php'
	?>
	<script> </script>
</body>

</html>