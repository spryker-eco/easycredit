declare var rkPlugin: any;

import Component from 'ShopUi/models/component';
import ScriptLoader from 'ShopUi/components/molecules/script-loader/script-loader';

interface easyCreditPluginOptions {
    webshopId: string,
    finanzierungsbetrag: string,
    textVariante: string
}

export default class EasycreditBadge extends Component {
    protected easyCreditScriptLoader: ScriptLoader;
    protected contentContainer: HTMLElement;
    protected mainContainer: HTMLElement;
    protected sidebarContainer: HTMLElement;

    protected readyCallback(): void {
        this.mainContainer = <HTMLElement>document.querySelector('.page-layout-main');
        this.sidebarContainer = <HTMLElement>document.querySelector('.page-layout-main__sidebar-pdp');
        this.contentContainer = <HTMLElement>this.querySelector(`.${this.jsName}__content`);
        this.easyCreditScriptLoader = <ScriptLoader>this.querySelector(`.${this.jsName}__script-loader`);
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.easyCreditScriptLoader.addEventListener('scriptload', () => this.onScriptLoad());
        this.contentContainer.addEventListener('click', (event) => this.onClickHandler(event));
    }

    protected onScriptLoad(): void {
        rkPlugin.anzeige(this.easyCreditContainerId, this.easyCreditPluginOptions);
    }

    protected onClickHandler(event: Event): void {
        const clickedElement = <HTMLElement>event.target;
        this.mainContainer.setAttribute('style', 'position: relative; z-index: 10000;');
        this.sidebarContainer.setAttribute('style', 'position: relative; z-index: 10000;');

        if (clickedElement.classList.contains('modal')) {
            const closeButton = <HTMLElement>this.querySelector('.close');

            closeButton.click();
            this.mainContainer.setAttribute('style', '');
            this.sidebarContainer.setAttribute('style', '');
        }

        if (clickedElement.classList.contains('close')) {
            this.mainContainer.setAttribute('style', '');
            this.sidebarContainer.setAttribute('style', '');
        }
    }

    get easyCreditPluginOptions(): easyCreditPluginOptions {
        return JSON.parse(this.getAttribute('easycredit-options'));
    }

    get easyCreditContainerId(): string {
        return this.querySelector(`.${this.jsName}__content`).id;
    }
}
