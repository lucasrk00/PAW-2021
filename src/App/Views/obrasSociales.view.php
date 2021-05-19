<!DOCTYPE html>
<html lang="es">
<head>
	<?php
		require 'parts/head.view.php'
	?>
	<link rel="stylesheet" type="text/css" href="/assets/css/obrasSociales.css" />
</head>
<body>
	<!-- Header del sitio -->
	<?php
		require 'parts/header.view.php'
	?>
	<main>
		<section class="obras-sociales">
			<!-- Título de la sección -->
			<h2>Obras Sociales</h2>
			<!-- Sidebar de filtros -->
			<aside>
				<h3>Filtros:</h3>
				<form action="./obrasSociales.html" method="post">
					<input type="text" class="search" placeholder="Buscar" />
					<label for="idOpcion1">
						<input type="checkbox" name="idOpcion1" id="idOpcion1" />
						Coberturas con convenio integral
					</label>
					<label for="idOpcion2">
						<input type="checkbox" name="idOpcion2" id="idOpcion2" />
						Coberturas con convenios de alta complejidad
					</label>
					<label for="idOpcion3">
						<input type="checkbox" name="idOpcion3" id="idOpcion3" />
						Coberturas internacionales (con derivación)
					</label>
					<label for="idOpcion4">
						<input type="checkbox" name="idOpcion4" id="idOpcion4" />
						Coberturas en consultorios externos
					</label>
					<label for="idOpcion5">
						<input type="checkbox" name="idOpcion5" id="idOpcion5" />
						Fundaciones, ART y Seguros de Asistencia
					</label>
					<!-- .... -->
					<fieldset>
						<button class="danger">Limpiar</button>
						<input class="secondary" type="submit" value="Buscar" />
					</fieldset>
				</form>
			</aside>
			<!-- Lista de obras sociales -->
			<ul>
				<li>ASUNT</li>
				<li>BOREAL</li>
				<li>OSDE</li>
				<li>OSPAGA</li>
			</ul>
		</section>
	</main>
	<!-- Footer del sitio -->
	<?php
		require 'parts/footer.view.php'
	?>
</body>
</html>