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
			<ul class="paginacion">
				<?php
					foreach( range($pagination["pageStart"], $pagination["pageEnd"]) as $page):
				?>
					<li class="<?php if ($page == $pagination["currentPage"]){ echo "active"; }?>">
						<a href="?page=<?=$page?>"><?=$page?></a>
					</li>
				<?php endforeach; ?>
				<li>...</li>
				<li class="<?php if ($pagination["lastPage"] == $pagination["currentPage"]){ echo "active"; }?>">
					<a href="?page=<?=$pagination["lastPage"]?>"><?=$pagination["lastPage"]?></a>
				</li>
			</ul>
		</section>
	</main>

	<!-- Footer del sitio -->
	<?php
		require 'parts/footer.view.php'
	?>
</body>
</html>