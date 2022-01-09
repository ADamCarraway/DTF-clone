export default class ShowInFeed {
    constructor({api, data}) {
        this.api = api;
        this.data = data || false;
        this.button = document.createElement('span');
        this.buttonBase = 'cdx-settings-button';
        this.buttonActive = 'cdx-settings-button--active';
    }

    static get isTune() {
        return true;
    }

    render() {
        this.button.classList.add(this.buttonBase);
        this.button.innerHTML = '<ion-icon name="star-outline"></ion-icon>';

        this.button.addEventListener('click', () => {
            this.button.classList.toggle(this.buttonActive, !this.button.classList.contains(this.buttonActive));

            this.data = this.button.classList.contains(this.buttonActive);
        });

        this.button.classList.toggle(this.buttonActive, this.data);

        return this.button;
    }

    // wrap(blockContent) {
    //     // this.button.classList.toggle(this.buttonActive, toolData);
    //
    //     console.log(blockContent)
    //     const myWrapper = document.createElement('div');
    //
    //     myWrapper.append(blockContent);
    //
    //     myWrapper.style.fontSize = '0.9em';
    //
    //     return myWrapper;
    // }

    save() {
        return  this.data;;
    }
}