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
				<form action="/obrasSociales" method="get">
					<input type="text" name="nombre" value="<?=$nombreQuery?>" id="nombre" class="search" placeholder="Buscar" />
					<label for="convenioIntegral">
						<input type="checkbox" name="convenioIntegral" <?php if($request->getQueryField('convenioIntegral') == 'on') echo "checked" ?> id="convenioIntegral" />
						Coberturas con convenio integral
					</label>
					<label for="convenioAltaComplejidad">
						<input type="checkbox"  <?php if($request->getQueryField('convenioAltaComplejidad') == 'on') echo "checked" ?> name="convenioAltaComplejidad" id="convenioAltaComplejidad" />
						Coberturas con convenios de alta complejidad
					</label>
					<label for="internacional">
						<input type="checkbox" <?php if($request->getQueryField('internacional') == 'on') echo "checked" ?> name="internacional" id="internacional" />
						Coberturas internacionales (con derivación)
					</label>
					<label for="consultoriosExternos">
						<input type="checkbox"  <?php if($request->getQueryField('consultoriosExternos') == 'on') echo "checked" ?> name="consultoriosExternos" id="consultoriosExternos" />
						Coberturas en consultorios externos
					</label>
					<!-- .... -->
					<fieldset>
						<button class="danger">Limpiar</button>
						<input class="secondary" type="submit" value="Buscar" />
					</fieldset>
				</form>
			</aside>
			<!-- Lista de obras sociales -->
			<?php if(count($obrasSociales) <= 0): ?>
				<p>No se han encontrado resultados. <p>
			<?php else: ?>
			<ul>
				<?php foreach ($obrasSociales as $obraSocial): ?>
				<li><?=$obraSocial->nombre?></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
		</section>
	</main>
	<!-- Footer del sitio -->
	<?php
		require 'parts/footer.view.php'
	?>
</body>
</html>