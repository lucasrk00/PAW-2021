
class Appointments {
	constructor(parent) {
		if (typeof parent === 'string') 
			parent = document.querySelector(parent);
		if (!parent) throw new Error('Invalid parent');
		this.currentAppointment;
		this.attendedAppointments = [];

		this.appointmentElement = PAW.createElement('h2', '');
		const title = PAW.createElement('h1', 'Atentiendo a');

		this.soundEffect = PAW.createElement('audio', '', {
			src: '/assets/sounds/siguienteTurno.mp3',
			id: 'soundEffect',
		});

		this.currentAppointmentSection = PAW.createElement('section', [title, this.appointmentElement, this.soundEffect], {
			class: 'turno-actual'
		});

		this.attendedAppointmentsSection = PAW.createElement('section', this.attendedAppointmentsList, {
			class: 'turnos-recientes'
		});

		parent.appendChild(this.currentAppointmentSection);
		parent.appendChild(this.attendedAppointmentsSection);
	}

	isCurrentAppointment(appointment) {

	}
	updateAppointments(appointments) {
		// Actualiza y hace re render
		for (const  appointment of appointments) {
			// Fijarse si el currentAppoitnment es distino al previo
			if (appointment.state === 'attending') {
				if (!this.currentAppointment || this.currentAppointment.id !== appointment.id) {
					this.updateCurrentAppointment(appointment);
					this.updateAttendedAppointments(appointments);
					this.generateAppointmentsList();
					break;
				};
			}
		}
	}

	updateCurrentAppointment(appointment) {
		this.currentAppointment = appointment;
		this.playSound();
	}

	updateAttendedAppointments(appointments) {
		const attendedAppointments = appointments.filter(appointment => appointment.state === 'attended');
		const newAttendedAppointments = this.attendedAppointments;
		for (const attendedAppointment of attendedAppointments) {
			if (!newAttendedAppointments || newAttendedAppointments.indexOf(attendedAppointment) === -1) {
				newAttendedAppointments.push(attendedAppointment);
			}
		}
		this.attendedAppointments = newAttendedAppointments;
	}

	playSound() {
		this.soundEffect.play();
	}

	// #########
	// Creators
	// ########
	generateAppointmentsList() {
		this.appointmentElement.textContent = this.currentAppointment.id;

		this.attendedAppointmentsSection.innerHTML = '';

		const attendedAppointmentsList = [];
		for (const attendedAppointment of this.attendedAppointments) {
			const attendedAppointmentElement = PAW.createElement('li', attendedAppointment.id);
			attendedAppointmentsList.push(attendedAppointmentElement);
		}

		const attendedAppointmentsListElement = PAW.createElement('ul', [...attendedAppointmentsList], {
			class: 'lista-turnos'
		});
		this.attendedAppointmentsSection.appendChild(attendedAppointmentsListElement);
	}
}