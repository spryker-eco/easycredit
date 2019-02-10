<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\Easycredit;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;
use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\EasycreditInterestAndAdjustTotalSumResponseTransfer;
use Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer;
use Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
use Generated\Shared\Transfer\EasycreditQueryCreditAssessmentResponseTransfer;
use Generated\Shared\Transfer\EasycreditTransfer;
use Generated\Shared\Transfer\PaymentMethodsTransfer;
use Generated\Shared\Transfer\PaymentMethodTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use SprykerEco\Shared\Easycredit\EasycreditConfig;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\Factory\AdapterFactoryInterface;
use SprykerEco\Zed\Easycredit\Business\Api\RequestSender\RequestSender;
use SprykerEco\Zed\Easycredit\Business\Api\RequestSender\RequestSenderInterface;
use SprykerEco\Zed\Easycredit\Business\EasycreditBusinessFactory;
use SprykerEco\Zed\Easycredit\Business\EasycreditFacade;
use SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLogger;
use SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\ResponseParserInterface;
use SprykerEco\Zed\Easycredit\EasycreditConfig as ZedEasycreditConfig;
use SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManager;
use SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface;
use SprykerEco\Zed\Easycredit\Persistence\EasycreditRepositoryInterface;

/**
 * @group SprykerEcoTest
 * @group Zed
 * @group Easycredit
 * @group EasycreditTest
 */
abstract class AbstractEasycreditTest extends Unit
{
    protected const RESPONSE_KEY_PAYMENT_IDENTIFIER = 'payment_identifier';
    protected const RESPONSE_KEY_STATUS = 'status';
    protected const RESPONSE_KEY_TEXT = 'text';
    protected const RESPONSE_KEY_ANFALLENDE_ZINSEN = '123.45';
    protected const RESPONSE_KEY_URL_VORVERTRAGLICHE_INFORMATIONEN = 'url';
    protected const RESPONSE_KEY_TILGUNGSPLAN_TEXT = 'text';

    /**
     * @var EasycreditTester
     */
    protected $tester;

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\EasycreditFacade
     */
    protected function prepareFacade(): EasycreditFacade
    {
        $facade = new EasycreditFacade();
        $facade->setFactory($this->createEasycreditBusinessFactoryMock());

        return $facade;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\EasycreditBusinessFactory
     */
    protected function createEasycreditBusinessFactoryMock(): EasycreditBusinessFactory
    {
        $factory = $this->getMockBuilder(EasycreditBusinessFactory::class)
            ->setMethods([
                'getEntityManager',
                'getConfig',
                'createRequestSender',
                'createResponseParser',
                'createAdapterFactory',
                'createMapper',
            ])
            ->getMock();

        $factory->method('getEntityManager')->willReturn(new EasycreditEntityManager());
        $factory->method('getConfig')->willReturn($this->getConfigMock());
        $factory->method('createRequestSender')->willReturn($this->getRequestSender());

        return $factory;
    }

    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function prepareQuoteTransfer(): QuoteTransfer
    {
        $quoteTransfer = new QuoteTransfer();

        return $quoteTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\PaymentMethodsTransfer
     */
    protected function preparePaymentMethodsTransfer(): PaymentMethodsTransfer
    {
        $paymentMethodTransfer = new PaymentMethodTransfer();
        $paymentMethodTransfer->setMethodName(EasycreditConfig::PAYMENT_METHOD);

        $paymentMethodsTransfer = new PaymentMethodsTransfer();
        $paymentMethodsTransfer->addMethod($paymentMethodTransfer);

        return $paymentMethodsTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\PaymentTransfer
     */
    protected function preparePaymentTransfer(): PaymentTransfer
    {
        $paymentTransfer = new PaymentTransfer();
        $paymentTransfer->setPaymentSelection(EasycreditConfig::PAYMENT_METHOD);
        $paymentTransfer->setEasycredit(
            (new EasycreditTransfer())
                ->setVorgangskennung('vorgangskennung')
        );

        return $paymentTransfer;
    }

    /**
     * @param int $grandTotal
     *
     * @return \Generated\Shared\Transfer\TotalsTransfer
     */
    protected function prepareTotalsTransfer(int $grandTotal): TotalsTransfer
    {
        $totalsTransfer = new TotalsTransfer();
        $totalsTransfer->setGrandTotal($grandTotal);

        return $totalsTransfer;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\EasycreditConfig
     */
    protected function getConfigMock(): ZedEasycreditConfig
    {
        $config = $this->getMockBuilder(ZedEasycreditConfig::class)
            ->setMethods([])
            ->getMock();

        return $config;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\Factory\AdapterFactoryInterface
     */
    protected function getAdapterFactoryMock(): AdapterFactoryInterface
    {
        $factory = $this->getMockBuilder(AdapterFactoryInterface::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept()
            ->getMock();

        return $factory;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\RequestSender\RequestSenderInterface
     */
    protected function getRequestSender(): RequestSenderInterface
    {
        return new RequestSender(
            $this->getMapperMock(),
            $this->getAdapterFactoryMock(),
            $this->getParserMock(),
            $this->getLoggerMock(),
            $this->getEasycreditRepositoryMock(),
            $this->getEasycreditEntityManagerMock()
        );
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface
     */
    protected function getMapperMock(): MapperInterface
    {
        $mapper = $this->getMockBuilder(MapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $mapper;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Parser\ResponseParserInterface
     */
    protected function getParserMock(): ResponseParserInterface
    {
        $parser = $this->getMockBuilder(ResponseParserInterface::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'parseInitializePaymentResponse',
                'parsePreContractualInformationAndRedemptionPlanResponse',
                'parseOrderConfirmationResponse',
                'parseInterestAndTotalSumResponse',
                'parseQueryCreditAssessmentResponse',
                'parseApprovalTextResponse',
            ])
            ->getMock();

        $parser->method('parseInitializePaymentResponse')->willReturn($this->prepareEasycreditInitializePaymentResponseTransfer());
        $parser->method('parsePreContractualInformationAndRedemptionPlanResponse')->willReturn($this->prepareEasycreditPreContractualInformationAndRedemptionPlanResponseTransfer());
        $parser->method('parseOrderConfirmationResponse')->willReturn($this->prepareEasycreditOrderConfirmationResponseTransfer());
        $parser->method('parseInterestAndTotalSumResponse')->willReturn($this->prepareEasycreditDisplayInterestAndAdjustTotalSumResponseTransfer());
        $parser->method('parseQueryCreditAssessmentResponse')->willReturn($this->prepareEasycreditQueryAssessmentResponseTransfer());
        $parser->method('parseApprovalTextResponse')->willReturn($this->prepareEasycreditApprovalTextResponseTransfer());

        return $parser;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLogger
     */
    protected function getLoggerMock(): EasycreditLogger
    {
        $logger = $this->getMockBuilder(EasycreditLogger::class)
            ->disableOriginalConstructor()
            ->setMethods([])
            ->getMock();

        return $logger;
    }

    /**
     * @return \Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer
     */
    protected function prepareEasycreditInitializePaymentResponseTransfer(): EasycreditInitializePaymentResponseTransfer
    {
        $transfer = new EasycreditInitializePaymentResponseTransfer();
        $transfer->setPaymentIdentifier(static::RESPONSE_KEY_PAYMENT_IDENTIFIER);
        $transfer->setSuccess(true);

        return $transfer;
    }

    /**
     * @return \Generated\Shared\Transfer\EasycreditQueryCreditAssessmentResponseTransfer
     */
    protected function prepareEasycreditQueryAssessmentResponseTransfer(): EasycreditQueryCreditAssessmentResponseTransfer
    {
        $transfer = new EasycreditQueryCreditAssessmentResponseTransfer();
        $transfer->setStatus(static::RESPONSE_KEY_STATUS);
        $transfer->setSuccess(true);

        return $transfer;
    }

    /**
     * @return \Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer
     */
    protected function prepareEasycreditOrderConfirmationResponseTransfer(): EasycreditOrderConfirmationResponseTransfer
    {
        $transfer = new EasycreditOrderConfirmationResponseTransfer();
        $transfer->setConfirmed(false);
        $transfer->setSuccess(true);

        return $transfer;
    }

    /**
     * @return \Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer
     */
    protected function prepareEasycreditApprovalTextResponseTransfer(): EasycreditApprovalTextResponseTransfer
    {
        $transfer = new EasycreditApprovalTextResponseTransfer();
        $transfer->setText(static::RESPONSE_KEY_TEXT);
        $transfer->setSuccess(true);

        return $transfer;
    }

    /**
     * @return \Generated\Shared\Transfer\EasycreditInterestAndAdjustTotalSumResponseTransfer
     */
    protected function prepareEasycreditDisplayInterestAndAdjustTotalSumResponseTransfer(): EasycreditInterestAndAdjustTotalSumResponseTransfer
    {
        $transfer = new EasycreditInterestAndAdjustTotalSumResponseTransfer();
        $transfer->setAnfallendeZinsen(static::RESPONSE_KEY_ANFALLENDE_ZINSEN);
        $transfer->setSuccess(true);

        return $transfer;
    }

    /**
     * @return \Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
     */
    protected function prepareEasycreditPreContractualInformationAndRedemptionPlanResponseTransfer(): EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer
    {
        $transfer = new EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer();
        $transfer->setUrlVorvertraglicheInformationen(static::RESPONSE_KEY_URL_VORVERTRAGLICHE_INFORMATIONEN);
        $transfer->setSuccess(true);

        return $transfer;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface
     */
    protected function getEasycreditEntityManagerMock(): EasycreditEntityManagerInterface
    {
        $em = $this->getMockBuilder(EasycreditEntityManagerInterface::class)
            ->getMock();

        return $em;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Persistence\EasycreditRepositoryInterface
     */
    protected function getEasycreditRepositoryMock(): EasycreditRepositoryInterface
    {
        $repository = $this->getMockBuilder(EasycreditRepositoryInterface::class)
            ->getMock();

        return $repository;
    }
}
