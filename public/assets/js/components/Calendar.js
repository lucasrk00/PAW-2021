class Calendar {
	constructor(parent, insertBefore) {
		if (typeof parent === 'string') 
			parent = document.querySelector(parent);
		if (!parent) throw new Error('Invalid parent');

		this.selectedDate = null;
		this.selectedHour = null;

		this.dateInput = PAW.createElement('input', null, {
			type: 'date',
			min: this.formatDate(this.startTimestamp),
			max: this.formatDate(this.endTimestamp),
			name: 'fecha',
			required: true
		});

		this.timeInput = PAW.createElement('input', null, {
			type: 'time',
			name: 'hora',
			required: true
		});

		this.datesContainer = PAW.createElement('div', null, { class: 'dates-container' });
		this.hoursContainer = PAW.createElement('div', null, { class: 'hours-container' });

		const title = PAW.createElement('p', 'Horario del turno', { class: 'title' });
		const dateTitle = PAW.createElement('p', 'Fecha');
		const hoursTitle = PAW.createElement('p', 'Hora');
		const unselectedProfessional = PAW.createElement('p', 'Seleccione un profesional', { class: 'unselected-professional' });

		this.element = PAW.createElement('div', [title, dateTitle, hoursTitle, unselectedProfessional, this.datesContainer, this.hoursContainer, this.dateInput, this.timeInput], { class: 'calendar' });

		this.generateCalendar();

		if (insertBefore) {
			if (typeof insertBefore === 'string') 
				insertBefore = parent.querySelector(insertBefore);
			parent.insertBefore(this.element, insertBefore);
		} else {
			parent.appendChild(this.element);
		}
	}
	get startTimestamp() {
		let startDay = new Date();
		startDay.setHours(0);
		startDay.setMinutes(0);
		startDay.setSeconds(0);
		startDay.setDate(startDay.getDate() + 1);
		startDay = startDay.getTime();
		return startDay;
	}

	get endTimestamp() {
		return this.startTimestamp + (7 * 24 * 60 * 60 * 1000);
	}


	// ######
	// Utils
	// #####
	userFriendlyDate(date) {
		const day = PAW.DOTWNAME[date.getDay()];
		const month = PAW.MONTH[date.getMonth()];
		return `${day} ${date.getDate()} de ${month}. del ${date.getFullYear()}`;
	}
	formatDate(date) {
		if (!(date instanceof Date))
			date = new Date(date);
		
		const parts = date.toISOString().split('T');
		return parts[0];
	}
	isSameDate(a, b) {
		if (!(a instanceof Date) || !(b instanceof Date)) return false;
		return a.getFullYear() === b.getFullYear()
			&& a.getMonth() === b.getMonth()
			&& a.getDate() === b.getDate();
	}

	isDayAvailable(date) {
		if (typeof date === 'number')
			date = new Date(date);
		const dayName = PAW.DOTWNAME[date.getDay()];
		if (!this.professional.availableDays.includes(dayName)) return false;

		return true;
	}

	isHourAvailable(time) {
		const minStart = this.professional.start.hour * 60 + this.professional.start.minute;
		const minEnd = this.professional.end.hour * 60 + this.professional.end.minute;
		if (time < minStart || time > minEnd) return false;

		for (const appointment of this.professional.appointments) {
			const { timestamp } = appointment;
			if (!this.isSameDate(timestamp, this.selectedDate)) continue;

			const appointmentMins = timestamp.getHours() * 60 + timestamp.getMinutes();
			if (appointmentMins === time) return;
		}

		return true;
	}




	// #######
	// Setter
	// ######
	setProfessional(professional) {
		this.professional = professional;
		this.generateCalendar();
	}

	// #########
	// Creators
	// ########
	generateCalendar() {
		if (!this.professional) {
			this.element.classList.add('unselected-professional');
			return;
		}
		this.element.classList.remove('unselected-professional');
		this.generateDays(this.startTimestamp, this.endTimestamp);
		if (this.selectedDate)
			this.generateHours(this.professional.start, this.professional.end, this.professional.duration);
		else
			this.hoursContainer.innerHTML = '';
	}

	generateDays(startTimestamp, endTimestamp) {
		this.datesContainer.innerHTML = '';

		for (let day = startTimestamp; day < endTimestamp; day += (24 * 60 * 60 * 1000)) {
			const date = new Date(day);
			if (!this.isDayAvailable(date)) continue;

			const stringDate = this.userFriendlyDate(date);

			const element = PAW.createElement('button', stringDate, { class: 'day' } )
			element.addEventListener('click', e => {
				e.preventDefault();
				this.dateInput.value = this.formatDate(date);
				this.selectedDate = date;


				// Elimina la fecha seleccionada
				const prevDay = this.datesContainer.querySelector('.day.active');
				if (prevDay) prevDay.classList.remove('active');

				element.classList.add('active');

				this.timeInput.value = '';
				this.generateHours(this.professional.start, this.professional.end, this.professional.duration)
			});

			this.datesContainer.appendChild(element);
		}
	}

	generateHours(start, end, interval = 20) {
		this.hoursContainer.innerHTML = '';

		const startMinutes = start.hour * 60 + start.minute;
		const endMinutes = end.hour * 60 + end.minute;

		for (let minute = startMinutes; minute <= endMinutes; minute += interval) {
			if (!this.isHourAvailable(minute)) continue;

			let hr = parseInt(minute / 60);
			let min = minute - (hr * 60);
			if (hr < 10) hr = `0${hr}`;
			if (min < 10) min = `0${min}`;

			const timeStr = `${hr}:${min}`;

			const element = PAW.createElement('button', timeStr, { class: 'hour' });
			element.addEventListener('click', e =>{
				e.preventDefault();
				this.timeInput.value = timeStr;

				// Elimina la hora previa
				const prevHour = this.hoursContainer.querySelector('.hour.active');
				if (prevHour) prevHour.classList.remove('active');

				this.selectedHour = minute;
				element.classList.add('active');
			} );
			this.hoursContainer.appendChild(element);
		}
	}
}