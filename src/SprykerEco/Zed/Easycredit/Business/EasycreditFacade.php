<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business;

use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;
use Generated\Shared\Transfer\EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer;
use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer;
use Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
use Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer;
use Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer;
use Generated\Shared\Transfer\PaymentMethodsTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\Easycredit\Business\EasycreditBusinessFactory getFactory()
 * @method \SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface getEntityManager()
 * @method \SprykerEco\Zed\Easycredit\Persistence\EasycreditRepositoryInterface getRepository()
 */
class EasycreditFacade extends AbstractFacade implements EasycreditFacadeInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer
     */
    public function sendPaymentInitializeRequest(QuoteTransfer $quoteTransfer): EasycreditInitializePaymentResponseTransfer
    {
        return $this
            ->getFactory()
            ->createEasycreditPaymentInitializeProcessor()
            ->process($quoteTransfer);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer
     */
    public function sendQueryCreditAssessmentRequest(QuoteTransfer $quoteTransfer): EasycreditQueryAssessmentResponseTransfer
    {
        return $this
            ->getFactory()
            ->createEasycreditPaymentQueryAssessmentProcessor()
            ->process($quoteTransfer);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param int $orderId
     *
     * @return \Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer
     */
    public function sendOrderConfirmationRequest(int $orderId): EasycreditOrderConfirmationResponseTransfer
    {
        return $this
            ->getFactory()
            ->createEasycreditOrderConfirmationProcessor()
            ->process($orderId);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer
     */
    public function sendGettingApprovalTextRequest(): EasycreditApprovalTextResponseTransfer
    {
        return $this
            ->getFactory()
            ->createEasycreditApprovalTextProcessor()
            ->process();
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PaymentMethodsTransfer $paymentMethodsTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentMethodsTransfer
     */
    public function filterPaymentMethods(PaymentMethodsTransfer $paymentMethodsTransfer, QuoteTransfer $quoteTransfer): PaymentMethodsTransfer
    {
        return $this->getFactory()
            ->createPaymentMethodFilter()
            ->filterPaymentMethods($paymentMethodsTransfer, $quoteTransfer);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer
     */
    public function saveEasycreditOrderIdentifier(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer): PaymentEasycreditOrderIdentifierTransfer
    {
        return $this->getFactory()->createEasycreditOrderIdentifierSaver()->saveOrderIdentifier($quoteTransfer, $saveOrderTransfer);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer
     */
    public function sendInterestAndAdjustTotalSumRequest(QuoteTransfer $quoteTransfer): EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer
    {
        return $this
            ->getFactory()
            ->createInterestAndAdjustTotalSumProcessor()
            ->process($quoteTransfer);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
     */
    public function sendPreContractualInformationAndRedemptionPlanRequest(QuoteTransfer $quoteTransfer): EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
    {
        return $this
            ->getFactory()
            ->createPreContractualInformationAndRedemptionPlanProcessor()
            ->process($quoteTransfer);
    }
}
