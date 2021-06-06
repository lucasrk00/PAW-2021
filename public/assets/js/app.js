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

	if (window.location.pathname === '/solicitarTurno') {
		const professionals = await service.fetchProfessionals();
		const professionalInput = document.querySelector('main form select#profesional');
		const dragAndDrop = new DragAndDrop('main section form', 'fieldset:last-child');
		const calendar = new Calendar('main section form', dragAndDrop.element);

		function updateProfessional() {
			const professional = professionals.find( prof => String(prof.id)  == professionalInput.value);

			calendar.setProfessional(professional);
		}
		updateProfessional();
		professionalInput.addEventListener('input', updateProfessional);
	}

	if (window.location.pathname === '/') {
		const imageCarousel = new ImageCarousel('main', [
			'/assets/images/hospital1.jpg',
			'/assets/images/hospital2.jpg',
			'/assets/images/hospital3.jpg',
		]);
	}

	if (window.location.pathname === '/turnero') {
		const appointments = new Appointments('main');
	}

	if (window.location.pathname === '/turneroCliente') {
		const clientAppointment = new ClientAppointment('main');
	}
});