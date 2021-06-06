class ClientAppointment {
	constructor(parent) {
		if (typeof parent === 'string') 
			parent = document.querySelector(parent);
		if (!parent) throw new Error('Invalid parent');

		this.clientAppointment = 'A3';
		this.actualAppointment = '0';

		this.soundEffect = PAW.createElement('audio', '', {
			src: '/assets/sounds/siguienteTurno.mp3',
			id: 'soundEffect',
		});

		const clientAppointment = PAW.createElement('h1', this.clientAppointment);
		this.actualAppointmentElement = PAW.createElement('h2', this.actualAppointment);

		const section = PAW.createElement('section', [clientAppointment, this.actualAppointmentElement, this.soundEffect]);
		parent.appendChild(section);
		setInterval(() => { if (this.clientAppointment >= `A${this.actualAppointment}`) this.nextAppointment() }, 10000);
	}

	nextAppointment() {
		this.actualAppointment = `${parseInt(this.actualAppointment) + 1}`;
		this.actualAppointmentElement.textContent = `A${this.actualAppointment}`;
		this.playSound();
		if (this.clientAppointment === `A${this.actualAppointment}`) {
			this.phoneVibrate();
		}
	}

	playSound() {
		this.soundEffect.play();
	}

	phoneVibrate() {
		window.navigator.vibrate([300, 100, 300]);
	}
}