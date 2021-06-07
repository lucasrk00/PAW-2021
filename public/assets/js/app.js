document.addEventListener('DOMContentLoaded', async () => {
	await Promise.all([
		PAW.loadScript('/assets/js/components/HamburgerMenu.js', 'hamburger-menu'),
		PAW.loadScript('/assets/js/components/DragAndDrop.js', 'drag-and-drop'),
		PAW.loadScript('/assets/js/components/Calendar.js', 'calendar'),
		PAW.loadScript('/assets/js/components/ImageCarousel.js', 'image-carousel'),
		PAW.loadScript('/assets/js/components/Appointments.js', 'appointments'),
		PAW.loadScript('/assets/js/components/ClientAppointment.js', 'client-appointment'),
		PAW.loadScript('/assets/js/components/ProfessionalAppointments.js', 'professional-appointment'),
	])

	handleHamburguerMenu();

	handleMultilevelMenu();

	switch (window.location.pathname) {
		case '/solicitarTurno':
			RutaSolicitarTurno()
			break;
		case '/institucion':
			RutaInstitucion()
			break;
		case '/turnero':
			RutaTurnero();
			break;
		case '/turneroCliente':
			RutaTurneroCliente();
			break;
		case '/turneroProfesional':
			RutaTurneroProfesional();
			break;
	}
});

// ######
// Menu
// #####
function handleHamburguerMenu() {
	const header = document.querySelector('header');
	const headerNav = document.querySelector('header nav');

	if (header && headerNav) {
		const hmbMenu = new HamburgerMenu(header, headerNav);
	}
}

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

// #######
// Utils
// #######
function updateData() {
	setTimeout(async () => {
		const turnos = await service.fetchAppointments();
		for (const professionalId in turnos) {
			const attended = turnos[professionalId]
				.appointments.filter(appointment => appointment.state === 'attending');

			const next = turnos[professionalId].appointments.find(appointment => appointment.state === 'pending');
			if (next) service.updateAppointment(next.id, { state: 'attending' });

			for (const appointment of attended) {
				service.updateAppointment(appointment.id, { state: 'attended' });
			}
		}
	}, 15 * 1000);
}

// #######
// Rutas
// #######
async function RutaTurnero() {
	let turnos = await service.fetchAppointments();

	const appointments = new Appointments('main');
	appointments.updateAppointments(turnos);

	updateData();
	setInterval(async () => {
		// Fetchear turnos
		turnos = await service.fetchAppointments();
		appointments.updateAppointments(turnos);
	}, 10 * 1000);
}

async function RutaTurneroCliente() {
	let turnos = await service.fetchAppointments();
	let turnoCliente = await service.fetchClientAppointment();

	const clientAppointment = new ClientAppointment('main');
	clientAppointment.setClientAppointment(turnoCliente);
	clientAppointment.updateAppointments(turnos);

	updateData();
	setInterval(async () => {
		// Fetchear turnos
		turnos = await service.fetchAppointments();
		turnoCliente = await service.fetchClientAppointment();
		clientAppointment.setClientAppointment(turnoCliente);
		clientAppointment.updateAppointments(turnos);
	}, 10 * 1000);
}

async function RutaTurneroProfesional() {
	let turnos = await service.fetchProfessionalAppointments({ id: 3 });

	const professionalAppointments = new ProfessionalAppointments('main');
	professionalAppointments.setAppointments(turnos);

	professionalAppointments.addEventListener('changeAppointment', async appointment => {
		service.updateAppointment(professionalAppointments.currentAppointment.id, { state: 'attended' });
		service.updateAppointment(appointment.id, { state: 'attending' })

		let turnos = await service.fetchProfessionalAppointments({ id: 3 });
		professionalAppointments.setAppointments(turnos);
	});
}

async function RutaSolicitarTurno() {
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

async function RutaInstitucion() {
		const imageCarousel = new ImageCarousel('main', [
			'/assets/images/hospital1.jpg',
			'/assets/images/hospital2.jpg',
			'/assets/images/hospital3.jpg',
		]);
}