export default class ShowInFeed {
    constructor({api}) {
        this.api = api;
        this.button = document.createElement('span');
        this.buttonCss = 'cdx-settings-button';
        this.buttonActiveCss = 'cdx-settings-button--active';
    }

    static get isTune() {
        return true;
    }

    render() {
        this.button.classList.add(this.buttonCss);
        this.button.innerHTML = '<ion-icon name="star-outline"></ion-icon>';

        this.button.addEventListener('click', () => {
            this.button.classList.toggle(this.buttonActiveCss, !this.button.classList.contains(this.buttonActiveCss));
        });

        return this.button;
    }

    save() {
        return this.button.classList.contains(this.buttonActiveCss);
    }
}