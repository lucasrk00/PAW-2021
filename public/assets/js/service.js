const professionals = [
	{
		id: 1,
		nombre: 'Ali Vefa',
		availableDays: ['Lunes', 'Martes', 'Miércoles'],
		start: {
			hour: 9,
			minute: 0
		},
		end: {
			hour: 12,
			minute:0
		},
		duration: 20,
		appointments: [
			{
				timestamp: new Date('2021-06-08 09:00:00'),
				id: 'C1',
				state: 'pending',
			},
			{
				timestamp: new Date('2021-06-07 10:40:00'),
				id: 'C2',
				state: 'pending',
			}
		]
	},
	{
		id: 2,
		nombre: 'Lucas Rivero',
		availableDays: ['Miércoles', 'Jueves', 'Viernes'],
		start: {
			hour: 12,
			minute: 0
		},
		end: {
			hour: 16,
			minute:0
		},
		duration: 35,
		appointments: [
			{
				timestamp: new Date('2021-06-10 13:10:00'),
				id: 'B1',
				state: 'attended',
			},
			{
				timestamp: new Date('2021-06-11 14:55:00'),
				id: 'B2',
				state: 'attending',
			}
		]
	},
	{
		id: 3,
		nombre: 'Gregory House',
		availableDays: ['Miércoles', 'Jueves', 'Viernes'],
		start: {
			hour: 12,
			minute: 0
		},
		end: {
			hour: 16,
			minute:0
		},
		duration: 35,
		appointments: [
			{
				timestamp: new Date('2021-06-11 13:00:00'),
				id: 'A1',
				state: 'attended'
			},
			{
				timestamp: new Date('2021-06-10 13:10:00'),
				id: 'A2',
				state: 'attending',
			},
			{
				timestamp: new Date('2021-06-11 14:55:00'),
				id: 'A3',
				state: 'pending'
			},
			{
				timestamp: new Date('2021-06-11 15:00:00'),
				id: 'A4',
				state: 'pending'
			}
		]
	}
]
const appointments = {};
for (const professional of professionals) {
	appointments[professional.id] = {
		nombre: professional.nombre,
		appointments: professional.appointments,
	};
}

const clientAppointment = {
	id: 'A3',
	timestamp: new Date('2021-06-11 14:55:00'),
}

const service = {
	async fetchProfessionals() {
		return professionals;
	},
	async fetchAppointments(filters) {
		return appointments;
	},
	async fetchAppointment(id) {
		for (const professionalId in appointments) {
			const appointment = appointments[professionalId]
				.appointments.find(app => app.id === id);
			if (appointment) return appointment;
		}
		return null;
	},
	async fetchClientAppointment(filters) {
		return clientAppointment;
	},
	async fetchProfessionalById(id) {
		return professionals.filter(professional => professional.id === id)[0];
	},
	async fetchProfessionalAppointments(filters) {
		const professional = await this.fetchProfessionalById(filters.id);
		return professional.appointments;
	},
	async updateAppointment(appointmentId, data) {
		const appointment = await this.fetchAppointment(appointmentId);
		for (const key in data) {
			appointment[key] = data[key];
		}
		return appointment;
	}
}