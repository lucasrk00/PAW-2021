const professionals = [
	{
		id: 1,
		nombre: 'Facu',
		apellido: 'silva',
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
				timestamp: new Date('2021-06-08 09:00:00')
			},
			{
				timestamp: new Date('2021-06-07 10:40:00')
			}
		]
	},
	{
		id: 2,
		nombre: 'Facu',
		apellido: 'silva',
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
				timestamp: new Date('2021-06-10 13:10:00')
			},
			{
				timestamp: new Date('2021-06-11 14:55:00')
			}
		]
	},
	{
		id: 3,
		nombre: 'Facu',
		apellido: 'silva',
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
				timestamp: new Date('2021-06-10 13:10:00')
			},
			{
				timestamp: new Date('2021-06-11 14:55:00')
			}
		]
	}
]
const appointments = [];
for (const professional of professionals) {
	appointments.push(...professional.appointments);
}


const service = {
	async fetchProfessionals() {
		return professionals;
	},
	async fetchAppointments(filters) {
		return appointments;
	}
}