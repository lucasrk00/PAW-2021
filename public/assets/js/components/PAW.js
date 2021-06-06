class PAW {
	static createElement(tag, content, attrs = {}) {
		const element = document.createElement(tag);

		for ( const attr in attrs) {
			element.setAttribute(attr, attrs[attr]);
		}
		if (content) {
			if (!Array.isArray(content)) content = [content];
			for (let node of content) {
				if (typeof node === 'string')
					node = document.createTextNode(node);

				element.appendChild(node);
			}
		}
		return element;
	}

	static async loadScript(url, name) {
		return new Promise((res, rej) => {
			let element = document.querySelector(`script#${name}`);
			if (!element) {
				element = this.createElement('script', null, { src: url, id: name });
				document.head.appendChild(element);
				element.addEventListener('load', res);
			} else {
				rej('Script already exists');
			}
		});
	}
	static get DOTWNAME() {
		return {
			1: 'Lunes',
			2: 'Martes',
			3: 'Miércoles',
			4: 'Jueves',
			5: 'Viernes',
			6: 'Sábado',
			0: 'Domingo'
		}
	}
	static get MONTH() {
		return [
			'Ene',
			'Feb',
			'Mar',
			'Abr',
			'May',
			'Jun',
			'Jul',
			'Ago',
			'Sep',
			'Oct',
			'Nov',
			'Dic'
		]
	}
}