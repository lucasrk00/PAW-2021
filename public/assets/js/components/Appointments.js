
class Appointments {
	constructor(parent) {
		if (typeof parent === 'string')
			parent = document.querySelector(parent);
		if (!parent) throw new Error('Invalid parent');
		this.currentAppointments = {};
		this.nextAppointments = {};
		this.cambiar = false;

		this.title = PAW.createElement('h1', 'TURNOS SIENDO ATENDIDOS');

		this.soundEffect = PAW.createElement('audio', '', {
			src: '/assets/sounds/siguienteTurno.mp3',
			id: 'soundEffect',
		});
		this.appointmentsList = PAW.createElement('ul', '');

		this.appointmentSection = PAW.createElement('section', [this.title, this.appointmentsList, this.soundEffect], {
			class: 'turnos-actuales'
		});

		parent.appendChild(this.appointmentSection);
		parent.appendChild(this.soundEffect);
	}

	updateAppointments(professionalsAppointments) {
		this.professionalsAppointments = professionalsAppointments;
		let hasNewCurrentAppointment = false;

		// Actualiza y hace re render
		let isNextAppointment = false;
		for (const professionalIndex in professionalsAppointments) {
			for (const appointment of professionalsAppointments[professionalIndex].appointments) {
				if (isNextAppointment) {
					this.nextAppointments[professionalIndex] = appointment;
					isNextAppointment = false;
				} else if ((!this.currentAppointments[professionalIndex] && appointment.state === 'attending' ) || (appointment.state === 'attending' && this.currentAppointments[professionalIndex].id !== appointment.id)) {
					this.currentAppointments[professionalIndex] = appointment;
					isNextAppointment = true;
					hasNewCurrentAppointment = true;
				}
			}
			if (isNextAppointment) {
				this.nextAppointments[professionalIndex] = '';
			}
			isNextAppointment = false;
		}
		if (hasNewCurrentAppointment) this.playSound();

		this.generateAppointmentsList();
	}

	playSound() {
		this.soundEffect.play();
	}

	// #########
	// Creators
	// ########
	generateAppointmentsList() {
		this.appointmentsList.innerHTML = '';
		const appointmentElementsList = [];

		for (const professionalIndex in this.professionalsAppointments) {
			/* Check if professional has appointments */
			if (!this.currentAppointments[professionalIndex] || !this.currentAppointments[professionalIndex].id) continue;

			/* Create all html elements on appointment */
			const professionalName = this.professionalsAppointments[professionalIndex].nombre;

			const professionalTitle = PAW.createElement('p', 'Profesional:');
			const professionalNameElement = PAW.createElement('p', `Dr. ${professionalName}`);
			const professionalContainer = PAW.createElement('section', [ professionalNameElement], { class: 'professional' })

			const currentAppointmentTitleElement = PAW.createElement('p', 'Turno actual:');
			const currentAppointmentElement = PAW.createElement('p', this.currentAppointments[professionalIndex].id, { class: 'id-turno' });
			const currentAppointmentContianer = PAW.createElement('section', [currentAppointmentTitleElement, currentAppointmentElement], { class: 'current-appointment' });

			let nextAppointmentTitleElement = PAW.createElement('p', '');
			let nextAppointmentElement = PAW.createElement('p', '', { class: 'id-turno' });
			const nextAppointmentContainer = PAW.createElement('section', [nextAppointmentTitleElement, nextAppointmentElement], { class: 'next-appointment' });

			/* Check if there's any pending appointment */
			if (this.nextAppointments[professionalIndex] && this.nextAppointments[professionalIndex].id) {
				nextAppointmentTitleElement.textContent = 'Turno siguiente: ';
				nextAppointmentElement.textContent = this.nextAppointments[professionalIndex].id;
			}
			const appointmentElement = PAW.createElement('li', [
				professionalContainer,
				currentAppointmentContianer,
				nextAppointmentContainer
			]);

			this.appointmentsList.appendChild(appointmentElement);
		}

	}
}