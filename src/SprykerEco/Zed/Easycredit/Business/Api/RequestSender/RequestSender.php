<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Api\RequestSender;

use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;
use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\EasycreditInterestAndAdjustTotalSumResponseTransfer;
use Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer;
use Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
use Generated\Shared\Transfer\EasycreditQueryCreditAssessmentResponseTransfer;
use Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\Factory\AdapterFactoryInterface;
use SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface;
use SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\ResponseParserInterface;
use SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface;
use SprykerEco\Zed\Easycredit\Persistence\EasycreditRepositoryInterface;

class RequestSender implements RequestSenderInterface
{
    /**
     * @var \SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface
     */
    protected $mapper;

    /**
     * @var \SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\Factory\AdapterFactoryInterface
     */
    protected $adapterFactory;

    /**
     * @var \SprykerEco\Zed\Easycredit\Business\Parser\ResponseParserInterface
     */
    protected $responseParser;

    /**
     * @var \SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface
     */
    protected $logger;

    /**
     * @var \SprykerEco\Zed\Easycredit\Persistence\EasycreditRepositoryInterface
     */
    protected $easycreditRepository;

    /**
     * @var \SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface
     */
    protected $easycreditEntityManager;

    /**
     * @param \SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface $mapper
     * @param \SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\Factory\AdapterFactoryInterface $adapterFactory
     * @param \SprykerEco\Zed\Easycredit\Business\Parser\ResponseParserInterface $responseParser
     * @param \SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface $logger
     * @param \SprykerEco\Zed\Easycredit\Persistence\EasycreditRepositoryInterface $easycreditRepository
     * @param \SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface $easycreditEntityManager
     */
    public function __construct(
        MapperInterface $mapper,
        AdapterFactoryInterface $adapterFactory,
        ResponseParserInterface $responseParser,
        EasycreditLoggerInterface $logger,
        EasycreditRepositoryInterface $easycreditRepository,
        EasycreditEntityManagerInterface $easycreditEntityManager
    ) {
        $this->mapper = $mapper;
        $this->adapterFactory = $adapterFactory;
        $this->responseParser = $responseParser;
        $this->logger = $logger;
        $this->easycreditRepository = $easycreditRepository;
        $this->easycreditEntityManager = $easycreditEntityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer
     */
    public function sendInitializePaymentRequest(QuoteTransfer $quoteTransfer): EasycreditInitializePaymentResponseTransfer
    {
        $requestTransfer = $this->mapper->mapInitializePaymentRequest($quoteTransfer);
        $responseTransfer = $this->adapterFactory
            ->createInitializePaymentAdapter()
            ->sendRequest($requestTransfer);

        $this->logger->saveApiLog(EasycreditLoggerInterface::LOG_TYPE_PAYMENT_INITIALIZE, $requestTransfer, $responseTransfer);

        return $this->responseParser->parseInitializePaymentResponse($responseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
     */
    public function sendPreContractualInformationAndRedemptionPlanRequest(QuoteTransfer $quoteTransfer): EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
    {
        $requestTransfer = $this->mapper->mapPreContractualInformationAndRedemptionPlanRequest($quoteTransfer);
        $responseTransfer = $this->adapterFactory
            ->createPreContractualInformationAndRedemptionPlanAdapter()
            ->sendRequest($requestTransfer);

        $this->logger->saveApiLog(EasycreditLoggerInterface::LOG_TYPE_PRE_CONTRACTUAL_INFORMATION_AMD_REDEMPTION_PLAN, $requestTransfer, $responseTransfer);

        return $this->responseParser->parsePreContractualInformationAndRedemptionPlanResponse($responseTransfer);
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer
     */
    public function sendOrderConfirmationRequest(int $idSalesOrder): EasycreditOrderConfirmationResponseTransfer
    {
        $paymentEasycreditOrderIdentifierTransfer = $this->easycreditRepository->findPaymentEasycreditOrderIdentifierByFkSalesOrderItem($idSalesOrder);

        if ($paymentEasycreditOrderIdentifierTransfer == null) {
            return $this->createNotConfirmedEasycreditOrderConfirmationResponseTransfer();
        }

        if ($paymentEasycreditOrderIdentifierTransfer->getConfirmed()) {
            return $this->createConfirmedEasycreditOrderConfirmationResponseTransfer();
        }

        $requestTransfer = $this->mapper->mapOrderConfirmationRequest($idSalesOrder, $paymentEasycreditOrderIdentifierTransfer);
        $responseTransfer = $this->adapterFactory
            ->createOrderConfirmationAdapter()
            ->sendRequest($requestTransfer);

        $easycreditOrderConfirmationResponseTransfer = $this->responseParser->parseOrderConfirmationResponse($responseTransfer);

        if ($easycreditOrderConfirmationResponseTransfer->getConfirmed()) {
            $this->confirmEasycreditOrderIdentifier($paymentEasycreditOrderIdentifierTransfer);
        }

        $this->logger->saveApiLog(EasycreditLoggerInterface::LOG_TYPE_ORDER_CONFIRMATION, $requestTransfer, $responseTransfer);

        return $easycreditOrderConfirmationResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditInterestAndAdjustTotalSumResponseTransfer
     */
    public function sendInterestAndTotalSumRequest(QuoteTransfer $quoteTransfer): EasycreditInterestAndAdjustTotalSumResponseTransfer
    {
        $requestTransfer = $this->mapper->mapInterestAndTotalSumRequest($quoteTransfer);
        $responseTransfer = $this->adapterFactory
            ->createInterestAndTotalSumAdapter()
            ->sendRequest($requestTransfer);

        $this->logger->saveApiLog(EasycreditLoggerInterface::LOG_TYPE_INTEREST_AND_ADJUST_TOTAL_SUM, $requestTransfer, $responseTransfer);

        return $this->responseParser->parseInterestAndTotalSumResponse($responseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditQueryCreditAssessmentResponseTransfer
     */
    public function sendQueryCreditAssessmentRequest(QuoteTransfer $quoteTransfer): EasycreditQueryCreditAssessmentResponseTransfer
    {
        $requestTransfer = $this->mapper->mapQueryCreditAssessmentRequest($quoteTransfer);
        $responseTransfer = $this->adapterFactory
            ->createQueryCreditAssessmentAdapter()
            ->sendRequest($requestTransfer);

        $this->logger->saveApiLog(EasycreditLoggerInterface::LOG_TYPE_CREDIT_ASSESSMENT, $requestTransfer, $responseTransfer);

        return $this->responseParser->parseQueryCreditAssessmentResponse($responseTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer
     */
    public function sendApprovalTextRequest(): EasycreditApprovalTextResponseTransfer
    {
        $requestTransfer = $this->mapper->mapApprovalTextRequest();
        $responseTransfer = $this->adapterFactory
            ->createApprovalTextAdapter()
            ->sendRequest($requestTransfer);

        $this->logger->saveApiLog(EasycreditLoggerInterface::LOG_TYPE_APPROVAL_TEXT, $requestTransfer, $responseTransfer);

        return $this->responseParser->parseApprovalTextResponse($responseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer
     *
     * @return void
     */
    protected function confirmEasycreditOrderIdentifier(PaymentEasycreditOrderIdentifierTransfer $paymentEasycreditOrderIdentifierTransfer): void
    {
        $paymentEasycreditOrderIdentifierTransfer->setConfirmed(true);
        $this->easycreditEntityManager->saveEasycreditOrderIdentifier($paymentEasycreditOrderIdentifierTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer
     */
    protected function createConfirmedEasycreditOrderConfirmationResponseTransfer(): EasycreditOrderConfirmationResponseTransfer
    {
        $responseTransfer = new EasycreditOrderConfirmationResponseTransfer();
        $responseTransfer->setConfirmed(true);

        return $responseTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer
     */
    protected function createNotConfirmedEasycreditOrderConfirmationResponseTransfer(): EasycreditOrderConfirmationResponseTransfer
    {
        $responseTransfer = new EasycreditOrderConfirmationResponseTransfer();
        $responseTransfer->setConfirmed(false);

        return $responseTransfer;
    }
}
