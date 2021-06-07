class ClientAppointment {
	constructor(parent) {
		if (typeof parent === 'string') 
			parent = document.querySelector(parent);
		if (!parent) throw new Error('Invalid parent');
		this.changeAppointments = false;

		this.soundEffect = PAW.createElement('audio', '', {
			src: '/assets/sounds/siguienteTurno.mp3',
			id: 'soundEffect',
		});

		const title = PAW.createElement('h2', 'Tu turno:' );
		this.clientAppointmentElement = PAW.createElement('h3', this.clientAppointment);

		this.attendingTitle = PAW.createElement('h2', 'Turnos siendo atendidos: ');
		this.appointmentSection = PAW.createElement('section', [title, this.clientAppointmentElement, this.soundEffect]);
		this.attendingAppointmentSection = PAW.createElement('section', this.attendingTitle);
		parent.appendChild(this.appointmentSection);
		parent.appendChild(this.attendingAppointmentSection);
	}

	setClientAppointment(appointment){
		this.clientAppointmentElement.textContent = appointment.id;
		this.clientAppointment = appointment;
	}

	updateAppointments(professionalsAppointments) {
		this.professionalsAppointments = professionalsAppointments;
		const attendingAppointments = [];
		if (this.changeAppointments) {
			this.professionalsAppointments[3].appointments[1].state = 'attended';
			this.professionalsAppointments[3].appointments[2].state = 'attending';
		}
		this.changeAppointments = true;

		for (const professionalIndex in this.professionalsAppointments) {
			for (const appointment of this.professionalsAppointments[professionalIndex].appointments) {
				if (appointment.state !== 'attending') continue;
				attendingAppointments.push(appointment);
				if (this.clientAppointment && appointment.id === this.clientAppointment.id) {
					this.playSound();
					this.phoneVibrate();
					this.clientAppointment = '';
				}
			}
		}
		this.attendingAppointments = attendingAppointments;
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
			const attendingAppointmentElement = PAW.createElement('li', PAW.createElement('h3', attendingAppointment.id));
			attendingAppointmentsList.push(attendingAppointmentElement);
		}

		const attendingAppointmentsListElement = PAW.createElement('ul', [...attendingAppointmentsList], {
			class: 'lista-turnos'
		});

		this.attendingAppointmentSection.appendChild(this.attendingTitle);
		this.attendingAppointmentSection.appendChild(attendingAppointmentsListElement);
	}
}