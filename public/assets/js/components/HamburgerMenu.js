class HamburgerMenu {
	constructor(parent, navMenu) {
		if (typeof parent === 'string')
			parent = document.querySelector(parent);
		if (!parent) throw new Error('Invalid parent');

		if (typeof navMenu === 'string') {
			navMenu = document.querySelector(navMenu);
		}
		this.navMenu = navMenu;

		const span = PAW.createElement('span', null, { class: 'navicon' });
		const button = PAW.createElement('button', span, { class: 'menu-icon' });

		button.addEventListener('click', this.handleClick.bind(this))

		this.button = button;
		this.parent = parent;

		parent.append(button);
	}
	get isActive() {
		return this.button.classList.contains('active');
	}
	handleClick(event) {
		if (this.isActive) {
			this.button.classList.remove('active');
			if (this.navMenu) this.navMenu.classList.remove('active')
		} else {
			this.button.classList.add('active');
			if (this.navMenu) this.navMenu.classList.add('active')
		}
	}
}