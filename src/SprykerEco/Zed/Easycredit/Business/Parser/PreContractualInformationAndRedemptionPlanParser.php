<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
use Psr\Http\Message\StreamInterface;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface;

class PreContractualInformationAndRedemptionPlanParser implements ParserInterface
{
    protected const KEY_ALLGEMEINE_VORGANGSDATEN = 'allgemeineVorgangsdaten';
    protected const KEY_URL_VORVERTRAGLICHE_INFORMATIONEN = 'urlVorvertraglicheInformationen';
    protected const KEY_TILGUNGSPLAN_TEXT = 'tilgungsplanText';

    /**
     * @var EasycreditToUtilEncodingServiceInterface
     */
    protected $utilEncoding;

    /**
     * @param EasycreditToUtilEncodingServiceInterface $utilEncoding
     */
    public function __construct(EasycreditToUtilEncodingServiceInterface $utilEncoding)
    {
        $this->utilEncoding = $utilEncoding;
    }

    /**
     * @param StreamInterface $response
     *
     * @return AbstractTransfer
     */
    public function parse(StreamInterface $response): AbstractTransfer
    {
        $payload = $this->utilEncoding->decodeJson($response->getContents(), true);

        $transfer = new EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer();

        if (array_key_exists(static::KEY_URL_VORVERTRAGLICHE_INFORMATIONEN, $payload)) {
            $transfer->setUrlVorvertraglicheInformationen(
                $payload[static::KEY_ALLGEMEINE_VORGANGSDATEN][static::KEY_URL_VORVERTRAGLICHE_INFORMATIONEN]
            );
            $transfer->setTilgungsplanText($payload[static::KEY_TILGUNGSPLAN_TEXT]);
        }

        return $transfer;
    }
}
