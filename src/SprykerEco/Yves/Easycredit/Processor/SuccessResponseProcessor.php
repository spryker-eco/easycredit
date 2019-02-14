<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit\Processor;

use Generated\Shared\Transfer\ExpenseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Client\Easycredit\EasycreditClientInterface;
use SprykerEco\Shared\Easycredit\EasycreditConstants;
use SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToCalculationClientInterface;
use SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToQuoteClientInterface;

class SuccessResponseProcessor implements SuccessResponseProcessorInterface
{
    public const EXPENSE_TYPE_EASYCREDIT = 'Easycredit';

    /**
     * @var \SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToQuoteClientInterface
     */
    protected $quoteClient;

    /**
     * @var \SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToCalculationClientInterface
     */
    protected $calculationClient;

    /**
     * @var \SprykerEco\Client\Easycredit\EasycreditClientInterface
     */
    protected $easycreditClient;

    /**
     * @param \SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToQuoteClientInterface $quoteClient
     * @param \SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToCalculationClientInterface $calculationClient
     * @param \SprykerEco\Client\Easycredit\EasycreditClientInterface $easycreditClient
     */
    public function __construct(
        EasycreditToQuoteClientInterface $quoteClient,
        EasycreditToCalculationClientInterface $calculationClient,
        EasycreditClientInterface $easycreditClient
    ) {
        $this->quoteClient = $quoteClient;
        $this->calculationClient = $calculationClient;
        $this->easycreditClient = $easycreditClient;
    }

    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function process(): QuoteTransfer
    {
        $quoteTransfer = $this->quoteClient->getQuote();

        $quoteTransfer = $this->addEasycreditSummaryInfo($quoteTransfer);
        $quoteTransfer = $this->addEasycreditExpense($quoteTransfer);
        $quoteTransfer = $this->calculationClient->recalculate($quoteTransfer);

        $this->quoteClient->setQuote($quoteTransfer);

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function addEasycreditExpense(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $expenseTransfer = new ExpenseTransfer();
        $expenseTransfer->setType(EasycreditConstants::EASYCREDIT_EXPENSE_TYPE);
        $expenseTransfer->setUnitNetPrice(0);
        $expenseTransfer->setUnitGrossPrice($quoteTransfer->getPayment()->getEasycredit()->getAnfallendeZinsen() * 100);
        $expenseTransfer->setQuantity(1);

        $quoteTransfer->addExpense($expenseTransfer);

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function addEasycreditSummaryInfo(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $easycreditContractualInformationAndRedemptionPlanResponseTransfer = $this->easycreditClient->sendPreContractualInformationAndRedemptionPlanRequest($quoteTransfer);
        $easycreditInterestAndAdjustTotalSumResponseTransfer = $this->easycreditClient->sendInterestAndTotalSumRequest($quoteTransfer);

        $quoteTransfer->getPayment()->getEasycredit()
            ->setUrlVorvertraglicheInformationen($easycreditContractualInformationAndRedemptionPlanResponseTransfer->getUrlVorvertraglicheInformationen())
            ->setTilgungsplanText($easycreditInterestAndAdjustTotalSumResponseTransfer->getTilgungsplanText())
            ->setAnfallendeZinsen($easycreditInterestAndAdjustTotalSumResponseTransfer->getAnfallendeZinsen());

        return $quoteTransfer;
    }
}
