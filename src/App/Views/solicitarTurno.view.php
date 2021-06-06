<!DOCTYPE html>
<html lang="es">

<head>
	<?php
	require 'parts/head.view.php'
	?>
	<link rel="stylesheet" type="text/css" href="/assets/css/solicitarTurno.css" />
</head>

<body>
	<!-- Header del sitio -->
	<?php
	require 'parts/header.view.php'
	?>

	<main>
		<section>
			<h2>Solicitar Turno</h2>
			<?php
			require 'parts/statusResultMessage.view.php'
			?>
			<form action="/solicitarTurno" method="post" enctype="multipart/form-data">
				<fieldset>
					<legend>Datos del Turno:</legend> <!-- Se ve mal en chrome, si cambio el legend por el p-->
					<!-- Especialidad del Turno -->
					<label for="especialidad">Especialidad* :</label>
					<select name="especialidad" id="especialidad" required>
						<option value="">Seleccione una especialidad</option>
						<?php foreach ($especialidades as $el) : ?>
							<option <?php if (isset($especialidad) && $el->id == $especialidad) {
										echo "selected";
									} ?> value="<?= $el->id ?>"><?= $el->nombre ?></option>
						<?php endforeach; ?>
					</select>

					<!-- Lista de profesionales disponibles para la especialidad -->
					<label for="profesional">Profesional* :</label>
					<select name="profesional" id="profesional" required>
						<option value="">Seleccione un profesional</option>
						<?php foreach ($profesionales as $el) : ?>
							<option <?php if (isset($profesional) && $el->id == $profesional) {
										echo "selected";
									} ?> value="<?= $el->id ?>"><?= $el->nombre ?></option>
						<?php endforeach; ?>
					</select>

					<!-- Fecha del turno -->
					<!-- <label for="fecha">Fecha* :</label>
					<input type="date" name="fecha" id="fecha" value="<?= $fecha ?>" required min="<?= date("Y-m-d") ?>" /> -->

					<!--Horario del turno-->
					<!-- <label for="hora">Hora* :</label>
					<input type="time" name="hora" id="hora" value="<?= $hora ?>" required /> -->
				</fieldset>
				<fieldset>
					<!-- Boton que limpia los campos del formulario -->
					<button>Limpiar</button>
					<!-- Botón que envia el formulario -->
					<input type="submit" value="Solicitar Turno" />
				</fieldset>
			</form>
		</section>
	</main>
	<!-- Footer del sitio -->
	<?php
	require 'parts/footer.view.php'
	?>
</body>

</html>