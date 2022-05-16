<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Mapper;

use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;
use SprykerEco\Zed\Easycredit\EasycreditConfig;

class EasycreditMapper implements MapperInterface
{
    /**
     * @var string
     */
    public const KEY_PERSONEN_DATEN = 'personendaten';

    /**
     * @var string
     */
    public const KEY_RECHNUNGS_ADRESSE = 'rechnungsadresse';

    /**
     * @var string
     */
    public const KEY_WEITERE_KAEUFER_ANGABEN = 'weitereKaeuferangaben';

    /**
     * @var string
     */
    public const KEY_RUECK_SPRUNG_ADRESSEN = 'ruecksprungadressen';

    /**
     * @var string
     */
    public const KEY_LIEFER_ADRESSE = 'lieferadresse';

    /**
     * @var string
     */
    public const KEY_KONTAKT = 'kontakt';

    /**
     * @var string
     */
    public const KEY_RISIKORELEVANTE_ANGABEN = 'risikorelevanteAngaben';

    /**
     * @var string
     */
    public const KEY_WARENKORBINFOS = 'warenkorbinfos';

    /**
     * @var string
     */
    public const KEY_SHOP_KENNUNG = 'shopKennung';

    /**
     * @var string
     */
    public const KEY_BESTELL_WERT = 'bestellwert';

    /**
     * @var string
     */
    public const KEY_INTEGRATIONS_ART = 'integrationsart';

    /**
     * @var string
     */
    public const KEY_ANREDE = 'anrede';

    /**
     * @var string
     */
    public const KEY_VORNAME = 'vorname';

    /**
     * @var string
     */
    public const KEY_NACHNAME = 'nachname';

    /**
     * @var string
     */
    public const KEY_GEBURTS_DATUM = 'geburtsdatum';

    /**
     * @var string
     */
    public const KEY_STRASSE_HAUS_NR = 'strasseHausNr';

    /**
     * @var string
     */
    public const KEY_PLZ = 'plz';

    /**
     * @var string
     */
    public const KEY_ORT = 'ort';

    /**
     * @var string
     */
    public const KEY_LAND = 'land';

    /**
     * @var string
     */
    public const KEY_TELEFON_NUMMER = 'telefonnummer';

    /**
     * @var string
     */
    public const KEY_TITEL = 'titel';

    /**
     * @var string
     */
    public const KEY_GEBURTSNAME = 'geburtsname';

    /**
     * @var string
     */
    public const KEY_GEBURTSORT = 'geburtsort';

    /**
     * @var string
     */
    public const KEY_EMAIL = 'email';

    /**
     * @var string
     */
    public const KEY_URL_ERFOLG = 'urlErfolg';

    /**
     * @var string
     */
    public const KEY_URL_ABBRUCH = 'urlAbbruch';

    /**
     * @var string
     */
    public const KEY_URL_ABLEHNUNG = 'urlAblehnung';

    /**
     * @var string
     */
    public const KEY_BESTELLUNG_ERFOLGT_UEBER_LOGIN = 'bestellungErfolgtUeberLogin';

    /**
     * @var string
     */
    public const KEY_LOGISTIK_DIENSTLEISTER = 'logistikDienstleister';

    /**
     * @var string
     */
    public const KEY_MENGE = 'menge';

    /**
     * @var string
     */
    public const KEY_PREIS = 'preis';

    /**
     * @var string
     */
    public const KEY_PRODUKTBEZEICHNUNG = 'produktbezeichnung';

    /**
     * @var array
     */
    protected const SALUTATION_MAPPER = [
        'Mr' => 'HERR',
        'Mrs' => 'FRAU',
        'Dr' => 'HERR',
        'Ms' => 'FRAU',
    ];

    /**
     * @var \SprykerEco\Zed\Easycredit\EasycreditConfig
     */
    protected $config;

    /**
     * @var \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    protected $moneyPlugin;

    /**
     * @param \SprykerEco\Zed\Easycredit\EasycreditConfig $config
     * @param \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface $moneyPlugin
     */
    public function __construct(
        EasycreditConfig     $config,
        MoneyPluginInterface $moneyPlugin
    )
    {
        $this->config = $config;
        $this->moneyPlugin = $moneyPlugin;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditRequestTransfer
     */
    public function mapInitializePaymentRequest(QuoteTransfer $quoteTransfer): EasycreditRequestTransfer
    {
        $payload = [
            static::KEY_SHOP_KENNUNG => $this->config->getShopIdentifier(),
            static::KEY_BESTELL_WERT => $this->moneyPlugin->convertIntegerToDecimal($quoteTransfer->getTotals()->getGrandTotal() ?? 0),
            static::KEY_INTEGRATIONS_ART => $this->config->getPaymentPageIntegrationType(),
            static::KEY_PERSONEN_DATEN => [
                static::KEY_ANREDE => static::SALUTATION_MAPPER[$quoteTransfer->getCustomer()->getSalutation()],
                static::KEY_VORNAME => $quoteTransfer->getShippingAddress()->getFirstName(),
                static::KEY_NACHNAME => $quoteTransfer->getShippingAddress()->getLastName(),
                static::KEY_GEBURTS_DATUM => '',
            ],
            static::KEY_RECHNUNGS_ADRESSE => [
                static::KEY_STRASSE_HAUS_NR => $quoteTransfer->getBillingAddress()->getAddress1() . $quoteTransfer->getBillingAddress()->getAddress2(),
                static::KEY_PLZ => $quoteTransfer->getBillingAddress()->getZipCode(),
                static::KEY_ORT => $quoteTransfer->getBillingAddress()->getCity(),
                static::KEY_LAND => $quoteTransfer->getBillingAddress()->getIso2Code(),
            ],
            static::KEY_LIEFER_ADRESSE => [
                static::KEY_VORNAME => $quoteTransfer->getShippingAddress()->getFirstName(),
                static::KEY_NACHNAME => $quoteTransfer->getShippingAddress()->getLastName(),
                static::KEY_STRASSE_HAUS_NR => $quoteTransfer->getShippingAddress()->getAddress1() . $quoteTransfer->getShippingAddress()->getAddress2(),
                static::KEY_PLZ => $quoteTransfer->getShippingAddress()->getZipCode(),
                static::KEY_ORT => $quoteTransfer->getShippingAddress()->getCity(),
                static::KEY_LAND => $quoteTransfer->getShippingAddress()->getIso2Code(),
            ],
            static::KEY_WEITERE_KAEUFER_ANGABEN => [
                static::KEY_TELEFON_NUMMER => $quoteTransfer->getCustomer()->getPhone(),
                static::KEY_GEBURTSNAME => $quoteTransfer->getCustomer()->getFirstName(),
            ],
            static::KEY_RUECK_SPRUNG_ADRESSEN => [
                static::KEY_URL_ERFOLG => $this->config->getSuccessUrl(),
                static::KEY_URL_ABBRUCH => $this->config->getCancelledUrl(),
                static::KEY_URL_ABLEHNUNG => $this->config->getDeniedUrl(),
            ],
            static::KEY_KONTAKT => [
                static::KEY_EMAIL => $quoteTransfer->getCustomer()->getEmail(),
            ],
            static::KEY_RISIKORELEVANTE_ANGABEN => [
                static::KEY_BESTELLUNG_ERFOLGT_UEBER_LOGIN => false,
                static::KEY_LOGISTIK_DIENSTLEISTER => $quoteTransfer->getShipment()->getShipmentSelection(),
            ],
        ];

        $payload[static::KEY_WARENKORBINFOS] = $this->prepareOrderItems($quoteTransfer);

        $requestTransfer = new EasycreditRequestTransfer();
        $requestTransfer->setPayload($payload);

        if ($quoteTransfer->getPayment() && $quoteTransfer->getPayment()->getEasycredit()) {
            $requestTransfer->setVorgangskennung($quoteTransfer->getPayment()->getEasycredit()->getVorgangskennung());
        }

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditRequestTransfer
     */
    public function mapPreContractualInformationAndRedemptionPlanRequest(QuoteTransfer $quoteTransfer): EasycreditRequestTransfer
    {
        $requestTransfer = new EasycreditRequestTransfer();
        $requestTransfer->setVorgangskennung($quoteTransfer->getPayment()->getEasycredit()->getVorgangskennung());

        return $requestTransfer;
    }

    /**
     * @param int $fkSalesOrder
     * @param \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditRequestTransfer
     */
    public function mapOrderConfirmationRequest(
        int $fkSalesOrder,
        PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
    ): EasycreditRequestTransfer {
        $requestTransfer = new EasycreditRequestTransfer();
        $requestTransfer->setVorgangskennung($paymentEasycreditOrderIdentifierTransfer->getIdentifier());

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditRequestTransfer
     */
    public function mapInterestAndTotalSumRequest(QuoteTransfer $quoteTransfer): EasycreditRequestTransfer
    {
        $requestTransfer = new EasycreditRequestTransfer();
        $requestTransfer->setVorgangskennung($quoteTransfer->getPayment()->getEasycredit()->getVorgangskennung());

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditRequestTransfer
     */
    public function mapQueryCreditAssessmentRequest(QuoteTransfer $quoteTransfer): EasycreditRequestTransfer
    {
        $requestTransfer = new EasycreditRequestTransfer();

        if ($quoteTransfer->getPayment() && $quoteTransfer->getPayment()->getEasycredit()) {
            $requestTransfer->setVorgangskennung($quoteTransfer->getPayment()->getEasycredit()->getVorgangskennung());
        }

        return $requestTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\EasycreditRequestTransfer
     */
    public function mapApprovalTextRequest(): EasycreditRequestTransfer
    {
        return new EasycreditRequestTransfer();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return array<array-key,mixed>
     */
    protected function prepareOrderItems(QuoteTransfer $quoteTransfer): array
    {
        $items = [];

        foreach ($quoteTransfer->getItems() as $itemTransfer) {
            $items[] = [
                static::KEY_MENGE => $itemTransfer->getQuantity(),
                static::KEY_PREIS => $this->moneyPlugin->convertIntegerToDecimal($itemTransfer->getRefundableAmount()),
                static::KEY_PRODUKTBEZEICHNUNG => $itemTransfer->getName(),
            ];
        }

        return $items;
    }
}
