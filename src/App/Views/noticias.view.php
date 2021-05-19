<!DOCTYPE html>
<html lang="es">
<head>
	<?php
		require 'parts/head.view.php'
	?>
	<link rel="stylesheet" type="text/css" href="/assets/css/noticias.css" />
</head>
<body>
	<!-- Header del sitio -->
	<?php
		require 'parts/header.view.php'
	?>

	<!-- Sección de noticias del sitio -->
	<main>
		<section class="novedades">
			<h2>Noticias</h2>
			<?php
				foreach ($noticias as $noticia) :
			?>
			<article class="novedad">
				<!-- Imágen del artículo -->
				<img src="<?= $noticia["imageUrl"] ?>" alt="<?= $noticia['title'] ?>"/>
				<!-- Título del artículo -->
				<h3><?= $noticia['title'] ?></h3> 
				<!-- Fecha del artículo --> 
				<p class="fecha"><?= $noticia['date'] ?></p>
				<!--Contenido de la novedad-->
				<p><?= $noticia['description'] ?></p>
				<!-- Botón "Ver Mas" del artículo -->
				<a class="button" href="<?= $noticia['url']?>">Ver Más</a>
			</article>
			<?php endforeach ; ?>
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