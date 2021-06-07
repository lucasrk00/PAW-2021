
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
	}

	updateAppointments(professionalsAppointments) {
		this.professionalsAppointments = professionalsAppointments;
		let hasNewCurrentAppointment = false;
		// Después de la primera iteración cambia el valor de un turno para probar que se actualizan los elementos
		if (this.cambiar) {
			professionalsAppointments[1].appointments[0].state = 'attending';
			professionalsAppointments[3].appointments[1].state = 'attended';
			professionalsAppointments[3].appointments[2].state = 'attending';
		}
		this.cambiar = true;

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
			const professionalName = this.professionalsAppointments[professionalIndex].nombre + ' ' + this.professionalsAppointments[professionalIndex].apellido;
			const professionalNameElement = PAW.createElement('p', `Profesional: ${professionalName}`);
			const currentAppointmentTitleElement = PAW.createElement('p', 'Turno actual:');
			const currentAppointmentElement = PAW.createElement('p', this.currentAppointments[professionalIndex].id, { class: 'id-turno' });
			let nextAppointmentTitleElement = PAW.createElement('p', '');
			let nextAppointmentElement = PAW.createElement('p', '', { class: 'id-turno' });
			/* Check if there's any pending appointment */
			if (this.nextAppointments[professionalIndex] && this.nextAppointments[professionalIndex].id) {
				nextAppointmentTitleElement.textContent = 'Turno siguiente: ';
				nextAppointmentElement.textContent = this.nextAppointments[professionalIndex].id;
			}
			const appointmentElement = PAW.createElement('li', [
				professionalNameElement,
				currentAppointmentTitleElement,
				currentAppointmentElement,
				nextAppointmentTitleElement,
				nextAppointmentElement,
			]);
			this.appointmentsList.appendChild(appointmentElement);
		}

	}
}