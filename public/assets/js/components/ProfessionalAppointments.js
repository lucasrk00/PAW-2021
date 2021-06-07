class ProfessionalAppointments {
	constructor(parent) {
		if (typeof parent === 'string')
			parent = document.querySelector(parent);
		if (!parent) throw new Error('Invalid parent');

		this.appointmentsContainer = PAW.createElement('div', '', { class: 'appointments-container' });
		this.selectedAppointmentButton = PAW.createElement('button', 'Atender turno seleccionado');
		this.nextAppointmentButton = PAW.createElement('button', 'Atender siguiente', { class: 'secondary' });

		this.actionButtonsContainer = PAW.createElement('div', [this.selectedAppointmentButton, this.nextAppointmentButton], { class: 'buttons-container' });
		this.selectedAppointmentButton.addEventListener('click', e => {
			e.preventDefault();
			this.changeCurrentAppointment(this.selectedAppointment);
		});
		this.nextAppointmentButton.addEventListener('click', e => {
			e.preventDefault();
			this.nextAppointment();
		})
		const title = PAW.createElement('h2', 'Turnos:');

		this.element = PAW.createElement('section', [title, this.appointmentsContainer, this.actionButtonsContainer]);

		parent.appendChild(this.element);
	}

	setAppointments(appointments) {
		this.appointments = appointments;
		this.generateAppointmentsTable();
	}

	nextAppointment() {
		const pendingAppointments = this.appointments.filter(appointment => appointment.state === 'pending');
		if (pendingAppointments && pendingAppointments.length > 0) this.changeCurrentAppointment(pendingAppointments[0]);
	}

	changeCurrentAppointment(appointment) {
		// Disparar llamado
		if (this.currentAppointment) this.appointments[this.appointments.indexOf(this.currentAppointment)].state = 'attended';

		this.appointments[this.appointments.indexOf(appointment)].state = 'attending';
		this.currentAppointment = appointment;
		this.generateAppointmentsTable();
	}

	// #########
	// Creators
	// ########
	generateAppointmentsTable() {
		this.appointmentsContainer.innerHTML = '';
		for (const [appointmentIndex, appointment] of this.appointments.entries()) {
			const appointmentElement = PAW.createElement('button', this.formatAppointmentData(appointment), { class: appointment.state });

			if (appointment.state === 'pending') {
				appointmentElement.addEventListener('click', e => {
					e.preventDefault();
					const appointmentActiveElement = this.appointmentsContainer.querySelector('.pending.active');
					if (appointmentActiveElement) appointmentActiveElement.classList.remove('active');

					appointmentElement.classList.add('active');
					this.selectedAppointment = appointment;
				});
			} else if (appointment.state === 'attending') {
				this.currentAppointment = appointment;
			}

			this.appointmentsContainer.appendChild(appointmentElement);
		}
	}

	// #########
	// Utils
	// ########
	formatAppointmentData(appointment) {
		return `${appointment.id} - ${this.userFriendlyDate(appointment.timestamp)} - ${appointment.timestamp.toLocaleTimeString()}`;
	}

	userFriendlyDate(date) {
		const day = PAW.DOTWNAME[date.getDay()];
		const month = PAW.MONTH[date.getMonth()];
		return `${day} ${date.getDate()} de ${month}. del ${date.getFullYear()}`;
	}
}