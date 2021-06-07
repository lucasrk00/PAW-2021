class ClientAppointment {
	constructor(parent) {
		if (typeof parent === 'string') 
			parent = document.querySelector(parent);
		if (!parent) throw new Error('Invalid parent');

		this.soundEffect = PAW.createElement('audio', '', {
			src: '/assets/sounds/siguienteTurno.mp3',
			id: 'soundEffect',
		});

		const title = PAW.createElement('h1', 'Tu turno:' );
		this.clientAppointmentElement = PAW.createElement('h2', this.clientAppointment);

		this.attendingTitle = PAW.createElement('h3', 'Turnos siendo atendidos: ');
		this.appointmentSection = PAW.createElement('section', [title, this.clientAppointmentElement, this.soundEffect]);
		this.attendingAppointmentSection = PAW.createElement('section', attendingTitle);
		parent.appendChild(this.appointmentSection);
		parent.appendChild(this.attendingAppointmentSection);
	}

	setClientAppointment(appointment){
		this.clientAppointmentElement.textContent = appointment.id;
		this.clientAppointment = appointment;
	}

	updateAppointments(appointments) {
		this.attendingAppointments = appointments.filter(appointment => appointment.state === 'attending');
		// Actualiza y hace re render
		for (const appointment of this.attendingAppointments) {
			// Fijarse si el currentAppoitnment es distino al previo
			if (this.clientAppointment && this.clientAppointment.id === appointment.id) {
				this.playSound();
				this.phoneVibrate();
				break;
			};
		}
		this.createAttendingAppointmentsList();
	}

	playSound() {
		this.soundEffect.play();
	}
	phoneVibrate() {
		window.navigator.vibrate([300, 100, 300]);
	}

	// #########
	// Creators
	// ########
	createAttendingAppointmentsList() {
		this.attendingAppointmentSection.innerHTML = '';

		const attendingAppointmentsList = [];
		for (const attendingAppointment of this.attendingAppointments) {
			const attendingAppointmentElement = PAW.createElement('li', attendingAppointment.id);
			attendingAppointmentsList.push(attendingAppointmentElement);
		}

		const attendingAppointmentsListElement = PAW.createElement('ul', [...attendingAppointmentsList], {
			class: 'lista-turnos'
		});

		this.attendingAppointmentSection.appendChild(this.attendingTitle);
		this.attendingAppointmentSection.appendChild(attendingAppointmentsListElement);
	}
}