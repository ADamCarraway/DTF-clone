export default class ShowInFeed {
    constructor({api, data}) {
        this.api = api;
        this.data = data || false;
        this.button = document.createElement('span');
        this.buttonBase = 'cdx-settings-button';
        this.buttonActive = 'cdx-settings-button--active';
        this.indicatorActiveClass = 'ce-block-indicator--hidden';
        this.indicator = getShowInFeedIndicatorElement()
    }

    static get isTune() {
        return true;
    }

    render() {
        this.button.classList.add(this.buttonBase);
        this.button.innerHTML = '<ion-icon name="star"></ion-icon>';

        this.button.addEventListener('click', () => {
            this.button.classList.toggle(this.buttonActive, !this.button.classList.contains(this.buttonActive));

            this.data = this.button.classList.contains(this.buttonActive);
            this.indicator.classList.toggle(this.indicatorActiveClass, !this.data)
        });

        this.indicator.addEventListener('click', () => {
            this.button.classList.toggle(this.buttonActive, false);
            this.data = false;
            this.indicator.classList.toggle(this.indicatorActiveClass, true)
        });

        this.button.classList.toggle(this.buttonActive, this.data);

        return this.button;
    }

    wrap(blockContent) {
        let wapper = getIndicatorsBlockElemet();
        let container = getIndicatorsContainerElemet()

        if (!this.data) {
            this.indicator.classList.add('ce-block-indicator--hidden')
        }else{
            this.indicator.addEventListener('click', () => {
                this.button.classList.toggle(this.buttonActive, false);
                this.data = false;
                this.indicator.classList.toggle(this.indicatorActiveClass, true)
            });
        }

        container.append(this.indicator)
        wapper.append(container)
        wapper.append(blockContent)
        blockContent = wapper;

        return blockContent;
    }

    save() {
        return this.data;
    }
}

export function getIndicatorsBlockElemet() {
    let block = document.createElement('div');

    block.className = 'ce-block__indicators'

    return block;
}

export function getIndicatorsContainerElemet() {
    let block = document.createElement('div');

    block.className = 'ce-block__indicators-container'

    return block;
}

export function getShowInFeedIndicatorElement() {
    let block = document.createElement('div');

    block.className = 'ce-block-indicator ce-block-indicator--cover ce-block-indicator--active '

    block.innerHTML = '<span class="ce-block-indicator__icon">\n' +
        '                    <ion-icon name="star"></ion-icon>\n' +
        '                </span>\n'

    return block;
}