class ImageCarousel {
	constructor(parent, imagesUrl) {
		if (typeof parent === 'string')
			parent = document.querySelector(parent);
		if (!parent) throw new Error('Invalid parent');
		if (!imagesUrl || !Array.isArray(imagesUrl) || imagesUrl.length < 1) throw new Error('Invalid images');
		// Initialize properties
		this.touchStartX;
		this.touchEndX;
		this.slideIndex = 1;
		const transitions = ['fade', 'show'];

		const imagesContainer = [];
		const dots = [];
		for (const [imageIndex, imageUrl] of imagesUrl.entries()) {
			const image = PAW.createElement('img', 'imagen', {
				src: imageUrl,
				style: 'width: 100%',
			})
			const transition = transitions[Math.floor(Math.random() * (transitions.length))];
			const imageContainer = PAW.createElement('div', image, {
				class: `mySlides ${transition}`
			});
			const dot = PAW.createElement('span', '', {
				class: 'dot',
			})
			dot.addEventListener('click', () => {
				this.currentSlide(imageIndex + 1);
			})
			dots.push(dot);
			imagesContainer.push(imageContainer);
		}

		const dotsContainer = PAW.createElement('div', dots, {
			style: 'text-align: center;'
		});

		// Create next and previous "buttons"
		const prevButton = PAW.createElement('a', '<', {
			class: 'prev-button'
		});
		const nextButton = PAW.createElement('a', '>', {
			class: 'next-button'
		});
		prevButton.addEventListener('click', () => {
			this.plusSlides(-1);
		});
		nextButton.addEventListener('click', () => {
			this.plusSlides(1);
		});

		// Create image carousel section
		const carouselSection = PAW.createElement('section', [...imagesContainer, prevButton, nextButton, dotsContainer], {
			class: 'image-slider'
		});

		carouselSection.addEventListener('touchstart', this.setTouchStartX.bind(this));		
		carouselSection.addEventListener('touchend', this.setTouchEndX.bind(this));
		
		document.addEventListener('keydown', this.checkKeyPressed.bind(this));

		parent.appendChild(carouselSection);

		this.element = carouselSection;
		this.parent = parent;
		this.showSlides(this.slideIndex);
	}

	plusSlides(n) {
		this.showSlides(this.slideIndex += n);
	}
	currentSlide(n) {
		this.showSlides(this.slideIndex = n);
	}

	setTouchStartX(e) {
		this.touchStartX = e.changedTouches[0].screenX;
	}
	setTouchEndX(e) {
		this.touchEndX = e.changedTouches[0].screenX;
		this.handleGesture();
	}

	handleGesture() {
		if (this.touchEndX < this.touchStartX) this.plusSlides(1);
		if (this.touchEndX > this.touchStartX) this.plusSlides(-1);
	}

	checkKeyPressed(e) {
		switch (e.keyCode) {
			case 37:
				this.plusSlides(-1);
				break;
			case 39:
				this.plusSlides(1);
				break;
		}
	}

	showSlides(n) {
		let slides = document.getElementsByClassName("mySlides");
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
	}
}