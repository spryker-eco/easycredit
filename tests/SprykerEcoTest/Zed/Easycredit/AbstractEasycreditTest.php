<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\Easycredit;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;
use Generated\Shared\Transfer\EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer;
use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\EasycreditOrderConfirmationResponseTransfer;
use Generated\Shared\Transfer\EasycreditPreContractualInformationAndRedemptionPlanResponseTransfer;
use Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer;
use Generated\Shared\Transfer\EasycreditTransfer;
use Generated\Shared\Transfer\PaymentEasycreditOrderIdentifierTransfer;
use Generated\Shared\Transfer\PaymentMethodsTransfer;
use Generated\Shared\Transfer\PaymentMethodTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use SprykerEco\Shared\Easycredit\EasycreditConfig;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Easycredit\Business\EasycreditBusinessFactory;
use SprykerEco\Zed\Easycredit\Business\EasycreditFacade;
use SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLogger;
use SprykerEco\Zed\Easycredit\Business\Mapper\InitializePaymentMapper;
use SprykerEco\Zed\Easycredit\Business\Parser\ApprovalTextResponseParser;
use SprykerEco\Zed\Easycredit\Business\Parser\DisplayInterestAndAdjustTotalSumParser;
use SprykerEco\Zed\Easycredit\Business\Parser\InitializePaymentResponseParser;
use SprykerEco\Zed\Easycredit\Business\Parser\OrderConfirmationResponseParser;
use SprykerEco\Zed\Easycredit\Business\Parser\PreContractualInformationAndRedemptionPlanParser;
use SprykerEco\Zed\Easycredit\Business\Parser\QueryCreditAssessmentResponseParser;
use SprykerEco\Zed\Easycredit\Business\Processor\ApprovalTextProcessor\EasycreditApprovalTextProcessor;
use SprykerEco\Zed\Easycredit\Business\Processor\CreditAssessmentProcessor\EasycreditQueryAssessmentProcessor;
use SprykerEco\Zed\Easycredit\Business\Processor\EasycreditPaymentInitializeProcessor;
use SprykerEco\Zed\Easycredit\Business\Processor\InterestAndAdjustTotalSumProcessor\InterestAndAdjustTotalSumProcessor;
use SprykerEco\Zed\Easycredit\Business\Processor\OrderConfirmationProcessor\OrderConfirmationProcessor;
use SprykerEco\Zed\Easycredit\Business\Processor\PreContractualInformationAndRedemptionPlanProcessor\PreContractualInformationAndRedemptionPlanProcessor;
use SprykerEco\Zed\Easycredit\EasycreditConfig as ZedEasycreditConfig;
use SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManager;
use SprykerEco\Zed\Easycredit\Persistence\EasycreditRepository;

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
                'createEasycreditPaymentInitializeProcessor',
                'createEasycreditPaymentQueryAssessmentProcessor',
                'createEasycreditOrderConfirmationProcessor',
                'createEasycreditApprovalTextProcessor',
                'createInterestAndAdjustTotalSumProcessor',
                'createPreContractualInformationAndRedemptionPlanProcessor',
            ])
            ->getMock();

        $factory->method('getEntityManager')->willReturn(new EasycreditEntityManager());
        $factory->method('getConfig')->willReturn($this->getConfigMock());
        $factory->method('createEasycreditPaymentInitializeProcessor')->willReturn($this->getEasycreditPaymentInitializeProcessorMock());
        $factory->method('createEasycreditPaymentQueryAssessmentProcessor')->willReturn($this->getEasycreditPaymentQueryAssessmentProcessorMock());
        $factory->method('createEasycreditOrderConfirmationProcessor')->willReturn($this->getEasycreditOrderConfirmationProcessorMock());
        $factory->method('createEasycreditApprovalTextProcessor')->willReturn($this->getEasycreditApprovalTextProcessorMock());
        $factory->method('createInterestAndAdjustTotalSumProcessor')->willReturn($this->getInterestAndAdjustTotalSumProcessorMock());
        $factory->method('createPreContractualInformationAndRedemptionPlanProcessor')->willReturn($this->getPreContractualInformationAndRedemptionPlanProcessorMock());

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
     * @return \SprykerEco\Zed\Easycredit\Business\Processor\EasycreditPaymentInitializeProcessor
     */
    protected function getEasycreditPaymentInitializeProcessorMock(): EasycreditPaymentInitializeProcessor
    {
        $processor = $this->getMockBuilder(EasycreditPaymentInitializeProcessor::class)
            ->setConstructorArgs([
                $this->getInitializePaymentMapperMock(),
                $this->getInitializePaymentResponseParserMock(),
                $this->getEasycreditAdapterMock(),
                $this->getLoggerMock(),
            ])
            ->setMethodsExcept([
                'process',
            ])
            ->getMock();

        return $processor;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Processor\CreditAssessmentProcessor\EasycreditQueryAssessmentProcessor
     */
    protected function getEasycreditPaymentQueryAssessmentProcessorMock(): EasycreditQueryAssessmentProcessor
    {
        $processor = $this->getMockBuilder(EasycreditQueryAssessmentProcessor::class)
            ->setConstructorArgs([
                $this->getQueryCreditAssessmentResponseParserMock(),
                $this->getEasycreditAdapterMock(),
                $this->getLoggerMock(),
            ])
            ->setMethodsExcept([
                'process',
            ])
            ->getMock();

        return $processor;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Processor\OrderConfirmationProcessor\OrderConfirmationProcessor
     */
    protected function getEasycreditOrderConfirmationProcessorMock(): OrderConfirmationProcessor
    {
        $processor = $this->getMockBuilder(OrderConfirmationProcessor::class)
            ->setConstructorArgs([
                $this->getOrderConfirmationResponseParserMock(),
                $this->getEasycreditAdapterMock(),
                $this->getLoggerMock(),
                new EasycreditRepository(),
                new EasycreditEntityManager(),
            ])
            ->setMethodsExcept([
                'process',
            ])
            ->setMethods([
                'getEasycreditOrderIdentifierTransfer',
            ])
            ->getMock();

        $processor->method('getEasycreditOrderIdentifierTransfer')->willReturn(new PaymentEasycreditOrderIdentifierTransfer());

        return $processor;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Processor\ApprovalTextProcessor\EasycreditApprovalTextProcessor
     */
    protected function getEasycreditApprovalTextProcessorMock(): EasycreditApprovalTextProcessor
    {
        $processor = $this->getMockBuilder(EasycreditApprovalTextProcessor::class)
            ->setConstructorArgs([
                $this->getApprovalTextResponseParserMock(),
                $this->getEasycreditAdapterMock(),
                $this->getLoggerMock(),
            ])
            ->setMethodsExcept([
                'process',
            ])
            ->getMock();

        return $processor;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Processor\InterestAndAdjustTotalSumProcessor\InterestAndAdjustTotalSumProcessor
     */
    protected function getInterestAndAdjustTotalSumProcessorMock(): InterestAndAdjustTotalSumProcessor
    {
        $processor = $this->getMockBuilder(InterestAndAdjustTotalSumProcessor::class)
            ->setConstructorArgs([
                $this->getDisplayInterestAndAdjustTotalSumParserMock(),
                $this->getEasycreditAdapterMock(),
                $this->getLoggerMock(),
            ])
            ->setMethodsExcept([
                'process',
            ])
            ->getMock();

        return $processor;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Processor\PreContractualInformationAndRedemptionPlanProcessor\PreContractualInformationAndRedemptionPlanProcessor
     */
    protected function getPreContractualInformationAndRedemptionPlanProcessorMock(): PreContractualInformationAndRedemptionPlanProcessor
    {
        $processor = $this->getMockBuilder(PreContractualInformationAndRedemptionPlanProcessor::class)
            ->setConstructorArgs([
                $this->getPreContractualInformationAndRedemptionPlanParserMock(),
                $this->getEasycreditAdapterMock(),
                $this->getLoggerMock(),
            ])
            ->setMethodsExcept([
                'process',
            ])
            ->getMock();

        return $processor;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Mapper\InitializePaymentMapper
     */
    protected function getInitializePaymentMapperMock(): InitializePaymentMapper
    {
        $mapper = $this->getMockBuilder(InitializePaymentMapper::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'map',
            ])
            ->getMock();

        return $mapper;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Parser\InitializePaymentResponseParser
     */
    protected function getInitializePaymentResponseParserMock(): InitializePaymentResponseParser
    {
        $parser = $this->getMockBuilder(InitializePaymentResponseParser::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'parse',
            ])
            ->getMock();

        $parser->method('parse')->willReturn($this->prepareEasycreditInitializePaymentResponseTransfer());

        return $parser;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Parser\QueryCreditAssessmentResponseParser
     */
    protected function getQueryCreditAssessmentResponseParserMock(): QueryCreditAssessmentResponseParser
    {
        $parser = $this->getMockBuilder(QueryCreditAssessmentResponseParser::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'parse',
            ])
            ->getMock();

        $parser->method('parse')->willReturn($this->prepareEasycreditQueryAssessmentResponseTransfer());

        return $parser;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Parser\OrderConfirmationResponseParser
     */
    protected function getOrderConfirmationResponseParserMock(): OrderConfirmationResponseParser
    {
        $parser = $this->getMockBuilder(OrderConfirmationResponseParser::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'parse',
            ])
            ->getMock();

        $parser->method('parse')->willReturn($this->prepareEasycreditOrderConfirmationResponseTransfer());

        return $parser;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Parser\ApprovalTextResponseParser
     */
    protected function getApprovalTextResponseParserMock(): ApprovalTextResponseParser
    {
        $parser = $this->getMockBuilder(ApprovalTextResponseParser::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'parse',
            ])
            ->getMock();

        $parser->method('parse')->willReturn($this->prepareEasycreditApprovalTextResponseTransfer());

        return $parser;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Parser\DisplayInterestAndAdjustTotalSumParser
     */
    protected function getDisplayInterestAndAdjustTotalSumParserMock(): DisplayInterestAndAdjustTotalSumParser
    {
        $parser = $this->getMockBuilder(DisplayInterestAndAdjustTotalSumParser::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'parse',
            ])
            ->getMock();

        $parser->method('parse')->willReturn($this->prepareEasycreditDisplayInterestAndAdjustTotalSumResponseTransfer());

        return $parser;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Parser\PreContractualInformationAndRedemptionPlanParser
     */
    protected function getPreContractualInformationAndRedemptionPlanParserMock(): PreContractualInformationAndRedemptionPlanParser
    {
        $parser = $this->getMockBuilder(PreContractualInformationAndRedemptionPlanParser::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'parse',
            ])
            ->getMock();

        $parser->method('parse')->willReturn($this->prepareEasycreditPreContractualInformationAndRedemptionPlanResponseTransfer());

        return $parser;
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\InitializePaymentAdapter
     */
    protected function getEasycreditAdapterMock(): AdapterInterface
    {
        $adapter = $this->getMockBuilder(AdapterInterface::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'sendRequest',
            ])
            ->getMock();

        return $adapter;
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
     * @return \Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer
     */
    protected function prepareEasycreditQueryAssessmentResponseTransfer(): EasycreditQueryAssessmentResponseTransfer
    {
        $transfer = new EasycreditQueryAssessmentResponseTransfer();
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
     * @return \Generated\Shared\Transfer\EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer
     */
    protected function prepareEasycreditDisplayInterestAndAdjustTotalSumResponseTransfer(): EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer
    {
        $transfer = new EasycreditDisplayInterestAndAdjustTotalSumResponseTransfer();
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
        $transfer->setTilgungsplanText(static::RESPONSE_KEY_TILGUNGSPLAN_TEXT);
        $transfer->setUrlVorvertraglicheInformationen(static::RESPONSE_KEY_URL_VORVERTRAGLICHE_INFORMATIONEN);
        $transfer->setSuccess(true);

        return $transfer;
    }
}
