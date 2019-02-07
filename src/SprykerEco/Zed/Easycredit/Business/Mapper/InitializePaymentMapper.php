<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Mapper;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\Easycredit\EasycreditConfig;

class InitializePaymentMapper implements MapperInterface
{
    public const KEY_PERSONEN_DATEN = 'personendaten';
    public const KEY_RECHNUNGS_ADRESSE = 'rechnungsadresse';
    public const KEY_WEITERE_KAEUFER_ANGABEN = 'weitereKaeuferangaben';
    public const KEY_RUECK_SPRUNG_ADRESSEN = 'ruecksprungadressen';
    public const KEY_LIEFER_ADRESSE = 'lieferadresse';
    public const KEY_KONTAKT = 'kontakt';
    public const KEY_RISIKORELEVANTE_ANGABEN = 'risikorelevanteAngaben';
    public const KEY_WARENKORBINFOS = 'warenkorbinfos';

    public const KEY_SHOP_KENNUNG = 'shopKennung';
    public const KEY_BESTELL_WERT = 'bestellwert';
    public const KEY_INTEGRATIONS_ART = 'integrationsart';

    public const KEY_ANREDE = 'anrede';
    public const KEY_VORNAME = 'vorname';
    public const KEY_NACHNAME = 'nachname';
    public const KEY_GEBURTS_DATUM = 'geburtsdatum';

    public const KEY_STRASSE_HAUS_NR = 'strasseHausNr';
    public const KEY_PLZ = 'plz';
    public const KEY_ORT = 'ort';
    public const KEY_LAND = 'land';

    public const KEY_TELEFON_NUMMER = 'telefonnummer';
    public const KEY_TITEL = 'titel';
    public const KEY_GEBURTSNAME = 'geburtsname';
    public const KEY_GEBURTSORT = 'geburtsort';

    public const KEY_EMAIL = 'email';

    public const KEY_URL_ERFOLG = 'urlErfolg';
    public const KEY_URL_ABBRUCH = 'urlAbbruch';
    public const KEY_URL_ABLEHNUNG = 'urlAblehnung';

    public const KEY_BESTELLUNG_ERFOLGT_UEBER_LOGIN = 'bestellungErfolgtUeberLogin';
    public const KEY_LOGISTIK_DIENSTLEISTER = 'logistikDienstleister';

    public const KEY_MENGE = 'menge';
    public const KEY_PREIS= 'preis';
    public const KEY_PRODUKTBEZEICHNUNG = 'produktbezeichnung';

    protected const SALUTATION_MAPPER = [
        'Mr' => 'HERR',
        'Mrs' => 'FRAU',
        'Dr' => 'HERR',
        'Ms' => 'FRAU',
    ];

    /**
     * @var EasycreditConfig
     */
    protected $config;

    public function __construct(EasycreditConfig $config)
    {
        $this->config = $config;
    }

    public function map(QuoteTransfer $transfer): array
    {
        $payload = [
            static::KEY_SHOP_KENNUNG => $this->config->getShopIdentifier(),
            static::KEY_BESTELL_WERT => $transfer->getTotals()->getGrandTotal() / 100,
            static::KEY_INTEGRATIONS_ART => $this->config->getPaymentPageIntegrationType(),
            static::KEY_PERSONEN_DATEN => [
                static::KEY_ANREDE => static::SALUTATION_MAPPER[$transfer->getCustomer()->getSalutation()],
                static::KEY_VORNAME => $transfer->getShippingAddress()->getFirstName(),
                static::KEY_NACHNAME => $transfer->getShippingAddress()->getLastName(),
                static::KEY_GEBURTS_DATUM => '',
            ],
            static::KEY_RECHNUNGS_ADRESSE => [
                static::KEY_STRASSE_HAUS_NR => $transfer->getBillingAddress()->getAddress1() . $transfer->getBillingAddress()->getAddress2(),
                static::KEY_PLZ => $transfer->getBillingAddress()->getZipCode(),
                static::KEY_ORT => $transfer->getBillingAddress()->getCity(),
                static::KEY_LAND => $transfer->getBillingAddress()->getIso2Code(),
            ],
            static::KEY_LIEFER_ADRESSE => [
                static::KEY_VORNAME => $transfer->getShippingAddress()->getFirstName(),
                static::KEY_NACHNAME => $transfer->getShippingAddress()->getLastName(),
                static::KEY_STRASSE_HAUS_NR => $transfer->getShippingAddress()->getAddress1() . $transfer->getShippingAddress()->getAddress2(),
                static::KEY_PLZ => $transfer->getShippingAddress()->getZipCode(),
                static::KEY_ORT => $transfer->getShippingAddress()->getCity(),
                static::KEY_LAND => $transfer->getShippingAddress()->getIso2Code(),
            ],
            static::KEY_WEITERE_KAEUFER_ANGABEN => [
                static::KEY_TELEFON_NUMMER => $transfer->getCustomer()->getPhone(),
                static::KEY_GEBURTSNAME => $transfer->getCustomer()->getFirstName(),
            ],
            static::KEY_RUECK_SPRUNG_ADRESSEN => [
                static::KEY_URL_ERFOLG => $this->config->getSuccessUrl(),
                static::KEY_URL_ABBRUCH => $this->config->getCancelledUrl(),
                static::KEY_URL_ABLEHNUNG => $this->config->getDeniedUrl(),
            ],
            static::KEY_KONTAKT => [
                static::KEY_EMAIL => $transfer->getCustomer()->getEmail(),
            ],
            static::KEY_RISIKORELEVANTE_ANGABEN => [
                static::KEY_BESTELLUNG_ERFOLGT_UEBER_LOGIN => false,
                static::KEY_LOGISTIK_DIENSTLEISTER => $transfer->getShipment()->getShipmentSelection()
            ],
        ];

        $payload[static::KEY_WARENKORBINFOS] = $this->prepareOrderItems($transfer);

        return $payload;
    }

    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return array
     */
    protected function prepareOrderItems(QuoteTransfer $quoteTransfer): array
    {
        $items = [];

        foreach ($quoteTransfer->getItems() as $item) {
            $items[] = [
                static::KEY_MENGE => 1,
                static::KEY_PREIS => $item->getRefundableAmount(),
                static::KEY_PRODUKTBEZEICHNUNG => $item->getName(),
            ];
        }

        return $items;
    }
}
