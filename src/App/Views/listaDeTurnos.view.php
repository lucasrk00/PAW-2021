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
			<h2>Turnos de <?= $_SESSION["nombreApellido"] ?></h2>
			<!-- Lista de filtros -->
			<?php if(isset($turnos) && count($turnos)) : ?>
				<p>Mostrando turnos filtrados por:</p>
				<ul>
					<li>Fecha del Turno: 17/04/2021 al 30/04/2021</li>
				</ul>
	
				<!-- Botón que muestra los filtros -->
				<button>Filtros</button>
				<?php
				require 'parts/statusResultMessage.view.php'
				?>
				<table>
					<tr>
						<th>Fecha</th>
						<th>Hora</th>
						<th>Profesional</th>
						<th>Especialidad</th>
						<th>Estado</th>
						<th></th>
					</tr>
					<?php foreach ($turnos as $turno) : ?>
						<!-- Primer Turno -->
						<tr>
							<td><?= date('Y-m-d', strtotime($turno->fechaHora)) ?></td>
							<td><?= date('H:m', strtotime($turno->fechaHora)) ?></td>
							<td><?= $turno->profesional->nombre ?></td>
							<td><?= $turno->especialidad->nombre ?></td>
							<?php if ($turno->cancelado) : ?>
								<td>Cancelado</td>
							<?php else : ?>
								<td><?= ($turno->fechaHora < date("Y-m-d H:m")) ? "Finalizado" : "Pendiente" ?></td>
							<?php endif; ?>
							<td>
								<?php if ($turno->cancelado || $turno->fechaHora < date("Y-m-d H:m")) : ?>
									<button disabled>Cancelar</button>
								<?php else : ?>
									<form action="/cancelarTurno?turno=<?= $turno->id ?>" method="post">
										<button class="danger">Cancelar</button>
									</form>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
			<?php else: ?>
				<section class="sin-turnos">
					<p>No tienes ningún turno</p>
					<a class="button secondary" href="/solicitarTurno">Solicitar turno</a>
				</section>
			<?php endif ?>
		</section>
	</main>
	<!-- Footer del sitio -->
	<?php
	require 'parts/footer.view.php'
	?>
</body>

</html>