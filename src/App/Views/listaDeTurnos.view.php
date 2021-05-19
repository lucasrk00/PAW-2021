<!DOCTYPE html>
<html lang="es">
<head>
	<?php
		require 'parts/head.view.php'
	?>
	<link rel="stylesheet" type="text/css" href="/assets/css/listaDeTurnos.css" />
</head>
<body>
	<!-- Header del sitio -->
	<?php
		require 'parts/header.view.php'
	?>
	<main>
		<section>
			<h2>Turnos de Nombre</h2>
			<p>Mostrando turnos filtrados por:</p>
			<!-- Lista de filtros -->
			<ul>
				<li>Fecha del Turno: 17/04/2021 al 30/04/2021</li>
			</ul>
	
			<!-- Botón que muestra los filtros -->
			<button>Filtros</button> 
			<table>
				<tr>
					<th>Fecha</th>
					<th>Hora</th>
					<th>Profesional</th>
					<th>Especialidad</th>
					<th>Estado</th>
					<th></th>
				</tr>
				<!-- Primer Turno -->
				<tr>
					<td>17/04/2021</td>
					<td>18:00</td>
					<td>Juan Perez</td>
					<td>Dentista</td>
					<td>Pendiente</td>
					<td>
						<a class="button danger" href="cancelar">Cancelar</a>
					</td>
				</tr>
				<!-- ... -->
				<tr>
					<td>15/04/2021</td>
					<td>18:00</td>
					<td>Juan Perez</td>
					<td>Dentista</td>
					<td>Finalizado</td>
					<td>
						<a class="button danger disabled" href="cancelar">Cancelar</a>
					</td>
				</tr>
			</table>
		</section>
	</main>
	<!-- Footer del sitio -->
	<?php
		require 'parts/footer.view.php'
	?>
</body>
</html>