<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class PreContractualInformationAndRedemptionPlanParser implements ParserInterface
{
    protected const KEY_ALLGEMEINE_VORGANGSDATEN = 'allgemeineVorgangsdaten';
    protected const KEY_URL_VORVERTRAGLICHE_INFORMATIONEN = 'urlVorvertraglicheInformationen';
    protected const KEY_TILGUNGSPLAN_TEXT = 'tilgungsplanText';

    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    public function parse(EasycreditResponseTransfer $easycreditResponseTransfer): AbstractTransfer
    {
        $payload = $easycreditResponseTransfer->getBody();

        $transfer = new EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer();
        $transfer->setSuccess(false);

        if (array_key_exists(static::KEY_ALLGEMEINE_VORGANGSDATEN, $payload) && !$easycreditResponseTransfer->getError()) {
            $transfer->setSuccess(true);
            $transfer->setUrlVorvertraglicheInformationen(
                $payload[static::KEY_ALLGEMEINE_VORGANGSDATEN][static::KEY_URL_VORVERTRAGLICHE_INFORMATIONEN]
            );
//            $transfer->setTilgungsplanText($payload[static::KEY_TILGUNGSPLAN_TEXT]);
        }

        return $transfer;
    }
}
