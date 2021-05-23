<!DOCTYPE html>
<html lang="es">

<head>
	<?php
	require 'parts/head.view.php'
	?>
	<link rel="stylesheet" type="text/css" href="/assets/css/noticia.css" />
</head>

<body>
	<!-- Header del sitio -->
	<?php
	require 'parts/header.view.php'
	?>

	<!-- Sección de noticias del sitio -->
	<main>
		<section class="noticia">
			<!-- Título del artículo -->
			<h2><?= $noticia->nombre ?></h2>
			<!-- Fecha del artículo -->
			<p class="fecha"><?= $noticia->createdAt ?></p>
			<!-- Imágen del artículo -->
			<img src="<?= $noticia->imagenUrl ?>" alt="<?= $noticia->nombre ?>" />
			<!--Contenido de la novedad-->
			<p><?= $noticia->texto ?></p>
		</section>
	</main>

	<!-- Footer del sitio -->
	<?php
	require 'parts/footer.view.php'
	?>
</body>

</html>