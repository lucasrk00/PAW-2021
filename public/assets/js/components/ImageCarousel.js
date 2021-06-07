class ImageCarousel {
	constructor(parent, imagesUrl, transition, interval = 5000) {
		if (typeof parent === 'string')
			parent = document.querySelector(parent);
		if (!parent) throw new Error('Invalid parent');
		if (!imagesUrl || !Array.isArray(imagesUrl) || imagesUrl.length < 1) throw new Error('Invalid images');

		// Initialize properties
		this.touchStartX;
		this.touchEndX;
		this.slideIndex = 1;
		this.loadingProgress = 0;
		this.images = imagesUrl;
		this.interval = interval;
		this.selectedTransition = transition;

		// Create loading
		const loadingOverlay = this.createLoadingOverlay();

		// Create images
		const imagesContainer = [];
		const dots = [];
		for (const [imageIndex, imageUrl] of imagesUrl.entries()) {
			const dot = PAW.createElement('li', '', {
				class: 'dot',
			})
			dot.addEventListener('click', () => {
				this.setSlide(imageIndex + 1);
			})
			dots.push(dot);
			imagesContainer.push(this.createImage(imageUrl));
		}

		const dotsContainer = PAW.createElement('ul', dots);

		// Create next and previous "buttons"
		const buttons = this.createButtons();

		// Create image carousel section
		const carouselSection = PAW.createElement('section', [loadingOverlay, ...imagesContainer, ...buttons, dotsContainer], {
			class: 'image-slider'
		});

		carouselSection.addEventListener('touchstart', this.setTouchStartX.bind(this));
		carouselSection.addEventListener('touchend', this.setTouchEndX.bind(this));
		
		document.addEventListener('keydown', this.checkKeyPressed.bind(this));

		parent.appendChild(carouselSection);

		this.element = carouselSection;
		this.parent = parent;
		this.setSlide(this.slideIndex);
	}
	set progress(val) {
		if (this.loadingProgress > this.images.length) return;
		this.loadingProgress = val;
		this.handleProgress();
	}
	get progress() {
		return this.loadingProgress;
	}
	get transitions() {
		return ['fade', 'show', 'translate'];
	}

	createButtons() {
		const prevButton = PAW.createElement('a', '<', {
			class: 'prev-button'
		});
		const nextButton = PAW.createElement('a', '>', {
			class: 'next-button'
		});
		prevButton.addEventListener('click', () => {
			this.nextSlide(-1);
		});
		nextButton.addEventListener('click', () => {
			this.nextSlide(1);
		});
		return [prevButton, nextButton];
	}
	createLoadingOverlay() {
		const loadingPercentage = PAW.createElement('p', '0%');
		const loadingText = PAW.createElement('p', 'Cargando');
		const loadingOverlay = PAW.createElement('div', [loadingText, loadingPercentage], { class:'loading' });
		this.loading = {
			text: loadingPercentage,
			overlay: loadingOverlay
		}
		return loadingOverlay;
	}
	handleProgress() {
		if (this.progress >= this.images.length) {
			this.element.removeChild(this.loading.overlay);
		} else {
			this.loading.text.innerText = `${Math.round((this.progress / this.images.length) * 100)}%`;
		}
	}

	createImage(url) {
			const image = PAW.createElement('img', 'imagen', {
				src: url,
				style: 'width: 100%',
			})
			const transition = this.selectedTransition || this.transitions[Math.floor(Math.random() * (this.transitions.length))];
			const imageContainer = PAW.createElement('div', image, {
				class: `slide ${transition}`
			});
			image.addEventListener('load', e => this.progress++);

			return imageContainer;
	}

	setTouchStartX(e) {
		this.touchStartX = e.changedTouches[0].screenX;
	}
	setTouchEndX(e) {
		this.touchEndX = e.changedTouches[0].screenX;
		this.handleGesture();
	}

	handleGesture() {
		if (this.touchEndX < this.touchStartX) this.nextSlide();
		if (this.touchEndX > this.touchStartX) this.nextSlide(-1);
	}

	checkKeyPressed(e) {
		switch (e.keyCode) {
			case 37:
				this.nextSlide(-1);
				break;
			case 39:
				this.nextSlide(1);
				break;
		}
	}

	nextSlide(n = 1) {
		this.setSlide(this.slideIndex += n);
	}
	setSlide(n) {
		this.slideIndex = n;
		let slides = document.getElementsByClassName("slide");
		let dots = document.getElementsByClassName("dot");

		if (n > slides.length) {this.slideIndex = 1}
		if (n < 1) {this.slideIndex = slides.length}

		for (const slide of slides) {
			slide.style.display = "none";
		}
		for (const dot of dots) {
			dot.className = dot.className.replace(" active-dot", "");
		}

		slides[this.slideIndex-1].style.display = "block";
		dots[this.slideIndex-1].className += " active-dot";

		if (this.nextTimeout) clearTimeout(this.nextTimeout);
		this.nextTimeout = setTimeout(() => this.nextSlide(), this.interval);
	}
}