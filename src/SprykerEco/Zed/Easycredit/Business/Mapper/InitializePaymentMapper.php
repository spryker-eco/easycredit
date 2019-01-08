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

    public const KEY_URL_ERFOLG = 'urlErfolg';
    public const KEY_URL_ABBRUCH = 'urlAbbruch';
    public const KEY_URL_ABLEHNUNG = 'urlAblehnung';

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
        return [
            static::KEY_PERSONEN_DATEN => [
                static::KEY_ANREDE => $transfer->getCustomer()->getSalutation(),
                static::KEY_VORNAME => $transfer->getCustomer()->getFirstName(),
                static::KEY_NACHNAME => $transfer->getCustomer()->getLastName(),
                static::KEY_GEBURTS_DATUM => '',

            ],
            static::KEY_RECHNUNGS_ADRESSE => [
                static::KEY_STRASSE_HAUS_NR => $transfer->getBillingAddress()->getAddress1() . $transfer->getBillingAddress()->getAddress2(),
                static::KEY_PLZ => $transfer->getBillingAddress()->getZipCode(),
                static::KEY_ORT => $transfer->getBillingAddress()->getCity(),
                static::KEY_LAND => $transfer->getBillingAddress()->getCountry()->getIso2Code(),
            ],
            static::KEY_WEITERE_KAEUFER_ANGABEN => [
                static::KEY_TELEFON_NUMMER => $transfer->getCustomer()->getPhone(),
                static::KEY_TITEL => '',
                static::KEY_GEBURTSNAME => $transfer->getCustomer()->getFirstName(),
                static::KEY_GEBURTSORT => '',
            ],
            static::KEY_RUECK_SPRUNG_ADRESSEN => [
                static::KEY_URL_ERFOLG => $this->config->getSuccessUrl(),
                static::KEY_URL_ABBRUCH => $this->config->getCancelledUrl(),
                static::KEY_URL_ABLEHNUNG => $this->config->getDeniedUrl(),
            ],
        ];
    }
}
