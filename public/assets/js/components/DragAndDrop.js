class DragAndDrop {
	constructor(parent, insertBefore) {
		if (typeof parent === 'string')
			parent = document.querySelector(parent);
		if (!parent) throw new Error('Invalid parent');

		if (typeof insertBefore === 'string') 
			insertBefore = parent.querySelector(insertBefore);

		const p = PAW.createElement('p', 'Seleccione una imagen o arrastre y suelte las imágenes aquí');
		const selectedContainer = PAW.createElement('p', null, { class: 'file' });

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

		const fieldset = PAW.createElement('div', [p, selectedContainer, label, input], { class: 'file-upload' });

		fieldset.addEventListener('dragenter', this.handleDragEnter.bind(this));

		fieldset.addEventListener('dragleave', this.handleDragLeave.bind(this));

		fieldset.addEventListener('dragover', e => { e.preventDefault(); e.stopPropagation() });
		fieldset.addEventListener('drop', this.handleDrop.bind(this));
		input.addEventListener('input', this.handleFileChange.bind(this));

		this.fileInput = input;
		this.selectedContainer = selectedContainer;
		this.enter = 0;

		this.element = fieldset;
		this.parent = parent;

		if (insertBefore) {
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
		this.handleFileChange();
	}
	removeFile(e) {
		if (e) e.preventDefault();
		this.fileInput.value='';
		this.selectedContainer.innerHTML = '';
	}
	handleFileChange() {
		this.selectedContainer.innerHTML = '';
		if (this.fileInput.files.length <= 0) return;
		const file = [...this.fileInput.files].pop();
		const name = PAW.createElement('span', file.name);
		const removeButton = PAW.createElement('button', 'x', { class: 'remove' });
		removeButton.addEventListener('click', this.removeFile.bind(this));
		this.selectedContainer.appendChild(name);
		this.selectedContainer.appendChild(removeButton);
	}
}