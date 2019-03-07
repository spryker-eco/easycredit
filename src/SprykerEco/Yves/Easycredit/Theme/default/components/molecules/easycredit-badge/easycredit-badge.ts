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

    protected readyCallback(): void {
        this.easyCreditScriptLoader = <ScriptLoader>this.querySelector(`.${this.jsName}__script-loader`);
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.easyCreditScriptLoader.addEventListener('scriptload', () => this.onScriptLoad());
    }

    protected onScriptLoad(): void {
        rkPlugin.anzeige(this.easyCreditContainerId, this.easyCreditPluginOptions);
    }

    get easyCreditPluginOptions(): easyCreditPluginOptions {
        return JSON.parse(this.getAttribute('easycredit-options'));
    }

    get easyCreditContainerId(): string {
        return this.querySelector(`.${this.jsName}__content`).id;
    }
}
