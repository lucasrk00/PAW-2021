
class Appointments {
	constructor(parent) {
		if (typeof parent === 'string') 
			parent = document.querySelector(parent);
		if (!parent) throw new Error('Invalid parent');
		this.actualAppointment = '0';

		this.appointment = PAW.createElement('h2', this.actualAppointment);
		const title = PAW.createElement('h1', 'Atentiendo a');

		this.soundEffect = PAW.createElement('audio', '', {
			src: '/assets/sounds/siguienteTurno.mp3',
			id: 'soundEffect',
		});

		const actualAppointmentSection = PAW.createElement('section', [title, this.appointment, this.soundEffect], {
			class: 'turno-actual'
		});

		this.appointmentsList = PAW.createElement('ul', '', { class: 'lista-turnos' });
		const pastAppointmentsSection = PAW.createElement('section', this.appointmentsList, {
			class: 'turnos-recientes'
		});

		parent.appendChild(actualAppointmentSection);
		parent.appendChild(pastAppointmentsSection);
		setInterval(() => { this.nextAppointment() }, 10000);
	}

	nextAppointment() {
		const recentAppointment = PAW.createElement('li', `A${this.actualAppointment}`);
		this.appointmentsList.appendChild(recentAppointment);
		this.actualAppointment = `${parseInt(this.actualAppointment) + 1}`;
		this.appointment.textContent = `A${this.actualAppointment}`;
		this.playSound();
	}

	playSound() {
		this.soundEffect.play();
	}
}