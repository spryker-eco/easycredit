declare var rkPlugin: any;

import Component from 'ShopUi/models/component';
import ScriptLoader from 'ShopUi/components/molecules/script-loader/script-loader';

interface rkPluginOptions {
    webshopId: string,
    finanzierungsbetrag: string,
    textVariante: string
}

export default class EasycreditBadge extends Component {

    protected easyCreditScriptLoader: ScriptLoader;

    protected readyCallback(): void {
        this.easyCreditScriptLoader = <ScriptLoader>this.querySelector(`${this.jsName}__script-loader`);
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.easyCreditScriptLoader.addEventListener('scriptload', () => this.onScriptLoad());
    }

    protected onScriptLoad(): void {
        rkPlugin.anzeige(this.easyCreditContainerID, this.easyCreditPluginOptions);
    }

    get easyCreditPluginOptions(): rkPluginOptions {
        return JSON.parse(this.getAttribute('easycredit-options'));
    }

    get easyCreditContainerID(): string {
        return <string>this.querySelector(`.${this.jsName}__content`).id;
    }
}
