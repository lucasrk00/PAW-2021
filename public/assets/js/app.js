document.addEventListener('DOMContentLoaded', () => {
	const menuIcon = document.querySelector('.menu-icon');
	const menuNav = document.querySelector('header nav')

	if (menuIcon) {
		menuIcon.addEventListener('click', () => {
			if (menuNav && menuNav.classList && menuNav.classList.contains('active')) {
				menuIcon.classList.remove('active');
				menuNav.classList.remove('active');
			} else {
				menuIcon.classList.add('active');
				menuNav.classList.add('active');
			}
		});
	}

	const fileUpload = document.querySelector('fieldset.file-upload');
	if (fileUpload) {
		fileUpload.addEventListener("dragenter", dragenter, false);
		fileUpload.addEventListener("dragleave", dragleave, false);
		fileUpload.addEventListener("dragover", dragover, false);
		fileUpload.addEventListener("drop", drop, false);
	}
});


function dragenter(e) {
	e.srcElement.classList.add('over');
	e.stopPropagation();
	e.preventDefault();
}

function dragleave(e) {
	e.srcElement.classList.remove('over');
	e.stopPropagation();
	e.preventDefault();
}

function dragover(e) {
	e.stopPropagation();
	e.preventDefault();
} 

function drop(e) {
	e.stopPropagation();
	e.preventDefault();

	const dt = e.dataTransfer;
	const files = dt.files;

	const fileInput = document.getElementById('estudioClinico');
	fileInput.files = files;

	console.log(files);
}