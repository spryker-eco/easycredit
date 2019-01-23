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
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\InitializePaymentAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\OrderConfirmationAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\QueryCreditAssessmentAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Client\EasycreditClient;
use SprykerEco\Zed\Easycredit\Business\Mapper\InitializePaymentMapper;
use SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\ApprovalTextResponseParser;
use SprykerEco\Zed\Easycredit\Business\Parser\InitializePaymentResponseParser;
use SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\QueryCreditAssessmentResponseParser;
use SprykerEco\Zed\Easycredit\Business\Processor\ApprovalTextProcessor\EasycreditApprovalTextProcessor;
use SprykerEco\Zed\Easycredit\Business\Processor\ApprovalTextProcessor\EasycreditApprovalTextProcessorInterface;
use SprykerEco\Zed\Easycredit\Business\Processor\CreditAssessmentProcessor\CreditAssessmentProcessorInterface;
use SprykerEco\Zed\Easycredit\Business\Processor\CreditAssessmentProcessor\EasycreditQueryAssessmentProcessor;
use SprykerEco\Zed\Easycredit\Business\Processor\CreditAssessmentProcessor\EasycreditQueryAssessmentProcessorInterface;
use SprykerEco\Zed\Easycredit\Business\Processor\EasycreditPaymentInitializeProcessor;
use SprykerEco\Zed\Easycredit\Business\Processor\EasycreditPaymentInitializeProcessorInterface;
use SprykerEco\Zed\Easycredit\Business\Processor\OrderConfirmationProcessor\OrderConfirmationProcessor;
use SprykerEco\Zed\Easycredit\Business\Processor\OrderConfirmationProcessor\OrderConfirmationProcessorInterface;
use SprykerEco\Zed\Easycredit\EasycreditDependencyProvider;

/**
 * @method \SprykerEco\Zed\Easycredit\EasycreditConfig getConfig()
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
        return new InitializePaymentResponseParser($this->getUtilEncodingService());
    }

    /**
     * @return ParserInterface
     */
    public function createEasycreditApprovalTextResponseParser(): ParserInterface
    {
        return new ApprovalTextResponseParser($this->getUtilEncodingService());
    }

    /**
     * @return EasycreditPaymentInitializeProcessorInterface
     */
    public function createEasycreditPaymentInitializeProcessor(): EasycreditPaymentInitializeProcessorInterface
    {
        return new EasycreditPaymentInitializeProcessor(
            $this->createEasycreditInitializePaymentMapper(),
            $this->createEasycreditInitializePaymentResponseParser(),
            $this->createInitializePaymentAdapter()
        );
    }

    /**
     * @return EasycreditQueryAssessmentProcessorInterface
     */
    public function createEasycreditPaymentQueryAssessmentProcessor(): EasycreditQueryAssessmentProcessorInterface
    {
        return new EasycreditQueryAssessmentProcessor(
            $this->createEasycreditQueryCreditAssessmentParser(),
            $this->createQueryCreditAssessmentAdapter()
        );
    }

    /**
     * @return EasycreditApprovalTextProcessorInterface
     */
    public function createEasycreditApprovalTextProcessor(): EasycreditApprovalTextProcessorInterface
    {
        return new EasycreditApprovalTextProcessor(
            $this->createEasycreditApprovalTextResponseParser(),
            $this->createApprovalTextLoaderAdapter()
        );
    }

    /**
     * @return OrderConfirmationProcessorInterface
     */
    public function createEasycreditOrderConfirmationProcessor(): OrderConfirmationProcessorInterface
    {
        return new OrderConfirmationProcessor(
            $this->createEasycreditQueryCreditAssessmentParser(),
            $this->createQueryCreditAssessmentAdapter()
        );
    }

    /**
     * @return ParserInterface
     */
    protected function createEasycreditQueryCreditAssessmentParser(): ParserInterface
    {
        return new QueryCreditAssessmentResponseParser($this->getUtilEncodingService());
    }
}
