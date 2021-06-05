<header>
	<!-- Título  -->
	<h1 class="logo"><span>UNLuPAW</span> Medical Group</h1>
	<!-- Hamburger menú -->
	<button class="menu-icon"><span class="navicon"></span></button>
	<!-- Info del sitio -->
	<address class="info">
		<p><a href="tel:123456789">12345679</a></p>
		<p>Cochabamba 791, Buenos Aires</p>
	</address>
	<?php if ($request->isLoggedIn()) : ?>
		<!-- <a class="logout" href=" /logout">Logout</a></p> -->
	<?php endif; ?>
	<!-- Menú -->
	<nav>
		<h2>Menú</h2>
		<ul>
			<li class="active"><a href="/">Inicio</a></li>
			<li><a href="/institucion">Institución</a></li>
			<li><a href="/noticias">Noticias</a></li>
			<li><a href="/profesionales">Profesionales</a></li>
			<li><a href="/obrasSociales">Obras Sociales</a></li>
			<?php if ($request->isLoggedIn()) : ?>
				<li><a href="/listaDeTurnos">Mis Turnos</a></li>
				<li><a href="/solicitarTurno">Sacar Turno</a></li>
			<?php else : ?>
				<li><a href="/login">Iniciar Sesión</a></li>
				<li><a href="/registrarse">Registrarse</a></li>
			<?php endif; ?>
			<!-- En Caso de que esté logueado el usuario verá "Mis turnos" en lugar de "Iniciar Sesión" -->
		</ul>
	</nav>
</header>