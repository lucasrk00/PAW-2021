class DragAndDrop {
	constructor(parent, insertBefore) {
		if (typeof parent === 'string')
			parent = document.querySelector(parent);
		if (!parent) throw new Error('Invalid parent');

		const p = PAW.createElement('p', 'Seleccione una imagen o arrastre y suelte las imágenes aquí');

		const label = PAW.createElement('label', 'Seleccionar Archivo', {
			class: 'button secondary',
			for: 'estudioClinico'
		});

		const input = PAW.createElement('input', null, {
			type: 'file',
			accept: '.png, .jpg, .jpeg',
			name: 'estudioClinico',
			id: 'estudioClinico'
		});

		const fieldset = PAW.createElement('fieldset', [p, label, input], { class: 'file-upload' });

		fieldset.addEventListener('dragenter', this.handleDragEnter.bind(this));

		fieldset.addEventListener('dragleave', this.handleDragLeave.bind(this));

		fieldset.addEventListener('dragover', e => { e.preventDefault(); e.stopPropagation() });
		fieldset.addEventListener('drop', this.handleDrop.bind(this));

		this.fileInput = input;
		this.enter = 0;

		this.element = fieldset;
		this.parent = parent;

		if (insertBefore) {
			if (typeof insertBefore === 'string') 
				insertBefore = parent.querySelector(insertBefore);
			parent.insertBefore(this.element, insertBefore);
		} else {
			parent.appendChild(this.element);
		}
	}

	handleDragEnter(e) {
		e.stopPropagation()
		e.preventDefault();
		this.enter ++;
		if (this.enter > 0) {
			this.element.classList.add('over');
		}
	}
	handleDragLeave(e) {
		e.stopPropagation()
		e.preventDefault();
		this.enter --;
		if (this.enter < 0) this.enter = 0;
		if (this.enter === 0) {
			this.element.classList.remove('over');
		}
	}
	handleDrop(e) {
		e.stopPropagation()
		e.preventDefault();
		this.enter = 0;
		this.fileInput.files = e.dataTransfer.files;
		this.element.classList.remove('over');
	}
}