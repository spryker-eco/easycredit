<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;
use Psr\Http\Message\StreamInterface;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface;

class PreContractualInformationAndRedemptionPlanParser implements ParserInterface
{
    protected const KEY_ALLGEMEINE_VORGANGSDATEN = 'allgemeineVorgangsdaten';
    protected const KEY_URL_VORVERTRAGLICHE_INFORMATIONEN = 'urlVorvertraglicheInformationen';
    protected const KEY_TILGUNGSPLAN_TEXT = 'tilgungsplanText';

    /**
     * @param EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return AbstractTransfer
     */
    public function parse(EasycreditResponseTransfer $easycreditResponseTransfer): AbstractTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $transfer = new EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer();
        $transfer->setSuccess(false);

        if (array_key_exists(static::KEY_URL_VORVERTRAGLICHE_INFORMATIONEN, $payload) && !$easycreditResponseTransfer->getError()) {
            $transfer->setSuccess(true);
            $transfer->setUrlVorvertraglicheInformationen(
                $payload[static::KEY_ALLGEMEINE_VORGANGSDATEN][static::KEY_URL_VORVERTRAGLICHE_INFORMATIONEN]
            );
            $transfer->setTilgungsplanText($payload[static::KEY_TILGUNGSPLAN_TEXT]);
        }

        return $transfer;
    }
}
