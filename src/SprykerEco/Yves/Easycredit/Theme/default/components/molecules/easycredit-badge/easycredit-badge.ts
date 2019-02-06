declare var rkPlugin: any;

import Component from 'ShopUi/models/component';
import ScriptLoader from 'ShopUi/components/molecules/script-loader/script-loader';

interface rkPluginOptions {
    webshopId: string,
    finanzierungsbetrag: string,
    textVariante: string
}

export default class EasycreditBadge extends Component {

    scriptLoaderRkPlugin: ScriptLoader;
    rkContainerID: String;

    protected readyCallback(): void {
        this.scriptLoaderRkPlugin = <ScriptLoader>this.querySelector('.script-loader-rk-plugin');
        this.rkContainerID = <String>this.querySelector(`.${this.jsName}__content`).id;
        this.mapEvents();
    }

    protected mapEvents(): void {
        this.scriptLoaderRkPlugin.addEventListener('scriptload', () => this.onScriptLoad());

    }

    protected onScriptLoad(): void {
        rkPlugin.anzeige(this.rkContainerID, this.rkPluginOptions);
    }

    get rkPluginOptions(): rkPluginOptions {
        return JSON.parse(this.getAttribute('rk-options'));
    }
}
