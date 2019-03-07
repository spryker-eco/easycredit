<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit\Dependency\Client;

use Generated\Shared\Transfer\QuoteTransfer;

class EasycreditToCalculationClientBridge implements EasycreditToCalculationClientInterface
{
    /**
     * @var \Spryker\Client\Calculation\CalculationClientInterface
     */
    protected $calculationClient;

    /**
     * @param \Spryker\Client\Calculation\CalculationClientInterface $calculationClient
     */
    public function __construct($calculationClient)
    {
        $this->calculationClient = $calculationClient;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function recalculate(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->calculationClient->recalculate($quoteTransfer);
    }
}
