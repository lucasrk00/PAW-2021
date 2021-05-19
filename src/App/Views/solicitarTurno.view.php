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
			<form action="/solicitarTurno" method="post">
				<fieldset>
					<legend>Datos del Turno:</legend> <!-- Se ve mal en chrome, si cambio el legend por el p-->
					<!-- Especialidad del Turno -->
					<label for="especialidad">Especialidad* :</label>
					<select name="especialidad" id="especialidad" required>
						<option value="">Seleccione una especialidad</option>
						<option value="dentista">Dentista</option>
						<!-- Otras opciones -->
						<option value="...">....</option>
					</select>
		
					<!-- Lista de profesionales disponibles para la especialidad -->
					<label for="profesional">Profesional :</label>
					<select name="profesional" id="profesional">
						<option value="">Seleccione un profesional</option>
						<option value="idProfesional">Dr. Ali Vefa</option>
						<option value="idProfesional">Dr. Rivero Lucas</option>
						<option value="idProfesional">Dr. Gregory Hose</option>
					</select>
		
					<!-- Fecha del turno -->
					<label for="fecha">Fecha* :</label>
					<input type="date" name="fecha" id="fecha" required/>
		
					<!--Horario del turno-->
					<label for="hora">Hora* :</label>
					<input type="time" name="hora" id="hora" required/>
				</fieldset>
	
				<fieldset>
					<legend>Datos del Paciente: </legend> <!-- Se ve mal en chrome, si cambio el legend por el p-->
		
					<!-- Nombre y apellido del paciente -->
					<label for="nombreape">Nombre y Apellido* :</label>
					<input type="text" name="nombreape" id="nombreape" required placeholder="ej. Juan Pérez"/>
		
					<!-- Correo electrónico del paciente -->
					<label for="email">Correo Electrónico* :</label>
					<input type="email" name="email" id="email" required placeholder="ej. juan@ejemplo.com"/>
		
					<!-- Teléfono celular del paciente -->
					<label for="phone">Teléfono Celular* :</label>
					<input type="tel" name="phone" id="phone" required placeholder="ej. 111111111"/>
		
					<!-- Fecha de nacimiento del paciente -->
					<label for="nacimiento">Fecha de Nacimiento* :</label>
					<input type="date" name="nacimiento" id="nacimiento" required />
				</fieldset>
				<fieldset>
					<!-- Boton que limpia los campos del formulario -->
					<button>Limpiar</button>
					<!-- Botón que envia el formulario -->
					<input type="submit" value="Solicitar Turno"/>
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