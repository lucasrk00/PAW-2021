document.addEventListener('DOMContentLoaded', async () => {
	await Promise.all([
		PAW.loadScript('/assets/js/components/HamburgerMenu.js', 'hamburger-menu'),
		PAW.loadScript('/assets/js/components/DragAndDrop.js', 'drag-and-drop'),
		PAW.loadScript('/assets/js/components/Calendar.js', 'calendar'),
		PAW.loadScript('/assets/js/components/ImageCarousel.js', 'image-carousel'),
		PAW.loadScript('/assets/js/components/Appointments.js', 'appointments'),
		PAW.loadScript('/assets/js/components/ClientAppointment.js', 'client-appointment'),
	])
	const header = document.querySelector('header');
	const headerNav = document.querySelector('header nav');
	if (header && headerNav) {
		const hmbMenu = new HamburgerMenu(header, headerNav);
	}
	handleMultilevelMenu();
	if (window.location.pathname === '/solicitarTurno') {
		const professionals = await service.fetchProfessionals();
		const professionalInput = document.querySelector('main form select#profesional');
		const dragAndDrop = new DragAndDrop('main section form fieldset:nth-last-child(2)');
		const calendar = new Calendar('main section fieldset:first-child');

		function updateProfessional() {
			const professional = professionals.find( prof => String(prof.id)  == professionalInput.value);

			calendar.setProfessional(professional);
		}
		updateProfessional();
		professionalInput.addEventListener('input', updateProfessional);

		document.querySelector('main form fieldset button.clear' ).addEventListener('click', e => {
			e.preventDefault();
			const toReset = document.querySelectorAll('main form fieldset *:is(input, select)');
			calendar.setProfessional(null);
			dragAndDrop.removeFile();
			for (const el of toReset) {
				el.value = '';
			}
		});
	}

	if (window.location.pathname === '/institucion') {
		const imageCarousel = new ImageCarousel('main', [
			'/assets/images/hospital1.jpg',
			'/assets/images/hospital2.jpg',
			'/assets/images/hospital3.jpg',
		]);
	}

	if (window.location.pathname === '/turnero') {
		const turnos = await service.fetchAppointments();

		const appointments = new Appointments('main');
		setInterval(() => {
			// Fetchear turnos
			appointments.updateAppointments(turnos);
		}, 2 * 1000);
	}

	if (window.location.pathname === '/turneroCliente') {
		const turnos = await service.fetchAppointments();
		const turnoCliente = await service.fetchClientAppointment();

		const clientAppointment = new ClientAppointment('main');
		clientAppointment.setClientAppointment(turnoCliente);
		setInterval(() => {
			// Fetchear turnos
			clientAppointment.updateAppointments(turnos);
		}, 2 * 1000);
	}
});



function handleSingleMultilevelMenu(e, parent) {
	const { target } = e;
	if (parent.querySelector('ul').contains(target)) return;

	e.preventDefault();
	e.stopPropagation(); // Previene el eventListener del click que lo cerraría

	if (!parent.classList.contains('active'))
		parent.classList.add('active')
	else parent.classList.remove('active');
}
function handleMultilevelMenu() {
	const subnavs = document.querySelectorAll('header nav ul li.subnav');
	document.addEventListener('click', e => {
		const { target } = e;
		const activeSubnavs = document.querySelectorAll('header nav ul li.subnav.active > ul');
		for (activeSubnav of activeSubnavs) {
			if (!activeSubnav.contains(target)) {
				activeSubnav.parentElement.classList.remove('active');
			}
		}
	});
	for (const subnav of subnavs) {
		subnav.addEventListener('click', e => handleSingleMultilevelMenu(e, subnav));
	}
}