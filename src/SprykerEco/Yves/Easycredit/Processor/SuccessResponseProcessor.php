<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit\Processor;

use Generated\Shared\Transfer\EasycreditTransfer;
use Generated\Shared\Transfer\ExpenseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;
use SprykerEco\Client\Easycredit\EasycreditClientInterface;
use SprykerEco\Shared\Easycredit\EasycreditConstants;
use SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToCalculationClientInterface;
use SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToQuoteClientInterface;

class SuccessResponseProcessor implements SuccessResponseProcessorInterface
{
    /**
     * @var string
     */
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
     * @var \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    protected $moneyPlugin;

    /**
     * @param \SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToQuoteClientInterface $quoteClient
     * @param \SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToCalculationClientInterface $calculationClient
     * @param \SprykerEco\Client\Easycredit\EasycreditClientInterface $easycreditClient
     * @param \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface $moneyPlugin
     */
    public function __construct(
        EasycreditToQuoteClientInterface $quoteClient,
        EasycreditToCalculationClientInterface $calculationClient,
        EasycreditClientInterface $easycreditClient,
        MoneyPluginInterface $moneyPlugin
    ) {
        $this->quoteClient = $quoteClient;
        $this->calculationClient = $calculationClient;
        $this->easycreditClient = $easycreditClient;
        $this->moneyPlugin = $moneyPlugin;
    }

    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function process(): QuoteTransfer
    {
        $quoteTransfer = $this->quoteClient->getQuote();

        if (!$this->isEasycreditExpenseAdded($quoteTransfer)) {
            $quoteTransfer = $this->addEasycreditSummaryInfo($quoteTransfer);
            $quoteTransfer = $this->addEasycreditExpense($quoteTransfer);
            $quoteTransfer = $this->calculationClient->recalculate($quoteTransfer);

            $this->quoteClient->setQuote($quoteTransfer);
        }

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function addEasycreditExpense(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $easycreditTransfer = $this->getEasycreditTransfer($quoteTransfer);

        $expenseTransfer = new ExpenseTransfer();
        $expenseTransfer->setType(EasycreditConstants::EASYCREDIT_EXPENSE_TYPE);
        $expenseTransfer->setUnitNetPrice(0);
        $expenseTransfer->setUnitGrossPrice($this->moneyPlugin->convertDecimalToInteger($easycreditTransfer ? ($easycreditTransfer->getAnfallendeZinsen() ?? 0) : 0.0));
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

        $easycreditTransfer = $this->getEasycreditTransfer($quoteTransfer);
        if ($easycreditTransfer) {
            $easycreditTransfer
                ->setUrlVorvertraglicheInformationen($easycreditContractualInformationAndRedemptionPlanResponseTransfer->getUrlVorvertraglicheInformationen())
                ->setTilgungsplanText($easycreditInterestAndAdjustTotalSumResponseTransfer->getTilgungsplanText())
                ->setAnfallendeZinsen($easycreditInterestAndAdjustTotalSumResponseTransfer->getAnfallendeZinsen());
        }

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditTransfer|null
     */
    protected function getEasycreditTransfer(QuoteTransfer $quoteTransfer): ?EasycreditTransfer
    {
        $paymentTransfer = $quoteTransfer->getPayment();

        return $paymentTransfer ? $paymentTransfer->getEasycredit() : null;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return bool
     */
    protected function isEasycreditExpenseAdded(QuoteTransfer $quoteTransfer): bool
    {
        $expenses = $quoteTransfer->getExpenses();

        foreach ($expenses as $expense) {
            if ($expense->getType() === EasycreditConstants::EASYCREDIT_EXPENSE_TYPE) {
                return true;
            }
        }

        return false;
    }
}
