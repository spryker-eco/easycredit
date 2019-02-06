<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business;

use GuzzleHttp\ClientInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\ApprovalTextLoaderAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\DisplayInterestAndAdjustTotalSumAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\InitializePaymentAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\OrderConfirmationAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\PreContractualInformationAndRedemptionPlanAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\QueryCreditAssessmentAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Client\EasycreditClient;
use SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLogger;
use SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface;
use SprykerEco\Zed\Easycredit\Business\Mapper\InitializePaymentMapper;
use SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\ApprovalTextResponseParser;
use SprykerEco\Zed\Easycredit\Business\Parser\DisplayInterestAndAdjustTotalSumParser;
use SprykerEco\Zed\Easycredit\Business\Parser\InitializePaymentResponseParser;
use SprykerEco\Zed\Easycredit\Business\Parser\OrderConfirmationResponseParser;
use SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\PreContractualInformationAndRedemptionPlanParser;
use SprykerEco\Zed\Easycredit\Business\Parser\QueryCreditAssessmentResponseParser;
use SprykerEco\Zed\Easycredit\Business\Payment\PaymentMethodFilter;
use SprykerEco\Zed\Easycredit\Business\Payment\PaymentMethodFilterInterface;
use SprykerEco\Zed\Easycredit\Business\Processor\ApprovalTextProcessor\EasycreditApprovalTextProcessor;
use SprykerEco\Zed\Easycredit\Business\Processor\ApprovalTextProcessor\EasycreditApprovalTextProcessorInterface;
use SprykerEco\Zed\Easycredit\Business\Processor\CreditAssessmentProcessor\CreditAssessmentProcessorInterface;
use SprykerEco\Zed\Easycredit\Business\Processor\CreditAssessmentProcessor\EasycreditQueryAssessmentProcessor;
use SprykerEco\Zed\Easycredit\Business\Processor\CreditAssessmentProcessor\EasycreditQueryAssessmentProcessorInterface;
use SprykerEco\Zed\Easycredit\Business\Processor\EasycreditPaymentInitializeProcessor;
use SprykerEco\Zed\Easycredit\Business\Processor\EasycreditPaymentInitializeProcessorInterface;
use SprykerEco\Zed\Easycredit\Business\Processor\InterestAndAdjustTotalSumProcessor\InterestAndAdjustTotalSumProcessor;
use SprykerEco\Zed\Easycredit\Business\Processor\InterestAndAdjustTotalSumProcessor\InterestAndAdjustTotalSumProcessorInterface;
use SprykerEco\Zed\Easycredit\Business\Processor\OrderConfirmationProcessor\OrderConfirmationProcessor;
use SprykerEco\Zed\Easycredit\Business\Processor\OrderConfirmationProcessor\OrderConfirmationProcessorInterface;
use SprykerEco\Zed\Easycredit\Business\Processor\PreContractualInformationAndRedemptionPlanProcessor\PreContractualInformationAndRedemptionPlanProcessor;
use SprykerEco\Zed\Easycredit\Business\Processor\PreContractualInformationAndRedemptionPlanProcessor\PreContractualInformationAndRedemptionPlanProcessorInterface;
use SprykerEco\Zed\Easycredit\Business\Saver\EasycreditOrderIdentifierSaver;
use SprykerEco\Zed\Easycredit\Business\Saver\EasycreditOrderIdentifierSaverInterface;
use SprykerEco\Zed\Easycredit\EasycreditDependencyProvider;

/**
 * @method \SprykerEco\Zed\Easycredit\EasycreditConfig getConfig()
 * @method \SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface getEntityManager()
 * @method \SprykerEco\Zed\Easycredit\Persistence\EasycreditRepositoryInterface getRepository()
 */
class EasycreditBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return ClientInterface
     */
    public function createEasycreditClient(): ClientInterface
    {
        return new EasycreditClient();
    }

    /**
     * @return AdapterInterface
     */
    public function createInitializePaymentAdapter(): AdapterInterface
    {
        return new InitializePaymentAdapter($this->createEasycreditClient(), $this->getUtilEncodingService(), $this->getConfig());
    }

    /**
     * @return AdapterInterface
     */
    public function createOrderConfirmationAdapter(): AdapterInterface
    {
        return new OrderConfirmationAdapter($this->createEasycreditClient(), $this->getUtilEncodingService(), $this->getConfig());
    }

    /**
     * @return AdapterInterface
     */
    public function createQueryCreditAssessmentAdapter(): AdapterInterface
    {
        return new QueryCreditAssessmentAdapter($this->createEasycreditClient(), $this->getUtilEncodingService(), $this->getConfig());
    }

    /**
     * @return AdapterInterface
     */
    public function createApprovalTextLoaderAdapter(): AdapterInterface
    {
        return new ApprovalTextLoaderAdapter($this->createEasycreditClient(), $this->getUtilEncodingService(), $this->getConfig());
    }

    /**
     * @return AdapterInterface
     */
    public function createDisplayInterestAndAdjustTotalSumAdapter(): AdapterInterface
    {
        return new DisplayInterestAndAdjustTotalSumAdapter($this->createEasycreditClient(), $this->getUtilEncodingService(), $this->getConfig());
    }

    /**
     * @return AdapterInterface
     */
    public function createPreContractualInformationAndRedemptionPlanAdapter(): AdapterInterface
    {
        return new PreContractualInformationAndRedemptionPlanAdapter($this->createEasycreditClient(), $this->getUtilEncodingService(), $this->getConfig());
    }


    /**
     * @return EasycreditToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): EasycreditToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(EasycreditDependencyProvider::UTIL_ENCODING_SERVICE);
    }

    public function createEasycreditInitializePaymentMapper(): MapperInterface
    {
        return new InitializePaymentMapper($this->getConfig());
    }

    /**
     * @return ParserInterface
     */
    public function createEasycreditInitializePaymentResponseParser(): ParserInterface
    {
        return new InitializePaymentResponseParser();
    }

    /**
     * @return ParserInterface
     */
    public function createEasycreditApprovalTextResponseParser(): ParserInterface
    {
        return new ApprovalTextResponseParser();
    }

    /**
     * @return EasycreditPaymentInitializeProcessorInterface
     */
    public function createEasycreditPaymentInitializeProcessor(): EasycreditPaymentInitializeProcessorInterface
    {
        return new EasycreditPaymentInitializeProcessor(
            $this->createEasycreditInitializePaymentMapper(),
            $this->createEasycreditInitializePaymentResponseParser(),
            $this->createInitializePaymentAdapter(),
            $this->createEasycreditLogger()
        );
    }

    /**
     * @return EasycreditQueryAssessmentProcessorInterface
     */
    public function createEasycreditPaymentQueryAssessmentProcessor(): EasycreditQueryAssessmentProcessorInterface
    {
        return new EasycreditQueryAssessmentProcessor(
            $this->createEasycreditQueryCreditAssessmentParser(),
            $this->createQueryCreditAssessmentAdapter(),
            $this->createEasycreditLogger()
        );
    }

    /**
     * @return EasycreditApprovalTextProcessorInterface
     */
    public function createEasycreditApprovalTextProcessor(): EasycreditApprovalTextProcessorInterface
    {
        return new EasycreditApprovalTextProcessor(
            $this->createEasycreditApprovalTextResponseParser(),
            $this->createApprovalTextLoaderAdapter(),
            $this->createEasycreditLogger()
        );
    }

    /**
     * @return OrderConfirmationProcessorInterface
     */
    public function createEasycreditOrderConfirmationProcessor(): OrderConfirmationProcessorInterface
    {
        return new OrderConfirmationProcessor(
            $this->createEasycreditOrderConfirmationResponseParser(),
            $this->createOrderConfirmationAdapter(),
            $this->createEasycreditLogger(),
            $this->getRepository(),
            $this->getEntityManager()
        );
    }

    /**
     * @return ParserInterface
     */
    protected function createEasycreditQueryCreditAssessmentParser(): ParserInterface
    {
        return new QueryCreditAssessmentResponseParser();
    }

    /**
     * @return ParserInterface
     */
    protected function createEasycreditOrderConfirmationResponseParser(): ParserInterface
    {
        return new OrderConfirmationResponseParser();
    }

    /**
     * @return ParserInterface
     */
    protected function createDisplayInterestAndAdjustTotalSumParser(): ParserInterface
    {
        return new DisplayInterestAndAdjustTotalSumParser();
    }

    /**
     * @return ParserInterface
     */
    protected function createPreContractualInformationAndRedemptionPlanParser(): ParserInterface
    {
        return new PreContractualInformationAndRedemptionPlanParser();
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Payment\PaymentMethodFilterInterface
     */
    public function createPaymentMethodFilter(): PaymentMethodFilterInterface
    {
        return new PaymentMethodFilter();
    }

    /**
     * @return EasycreditLoggerInterface
     */
    public function createEasycreditLogger(): EasycreditLoggerInterface
    {
        return new EasycreditLogger();
    }

    /**
     * @return EasycreditOrderIdentifierSaverInterface
     */
    public function createEasycreditOrderIdentifierSaver(): EasycreditOrderIdentifierSaverInterface
    {
        return new EasycreditOrderIdentifierSaver($this->getEntityManager());
    }

    /**
     * @return InterestAndAdjustTotalSumProcessorInterface
     */
    public function createInterestAndAdjustTotalSumProcessor(): InterestAndAdjustTotalSumProcessorInterface
    {
        return new InterestAndAdjustTotalSumProcessor(
            $this->createDisplayInterestAndAdjustTotalSumParser(),
            $this->createDisplayInterestAndAdjustTotalSumAdapter(),
            $this->createEasycreditLogger()
        );
    }

    /**
     * @return PreContractualInformationAndRedemptionPlanProcessorInterface
     */
    public function createPreContractualInformationAndRedemptionPlanProcessor(): PreContractualInformationAndRedemptionPlanProcessorInterface
    {
        return new PreContractualInformationAndRedemptionPlanProcessor(
            $this->createPreContractualInformationAndRedemptionPlanParser(),
            $this->createPreContractualInformationAndRedemptionPlanAdapter(),
            $this->createEasycreditLogger()
        );
    }
}
