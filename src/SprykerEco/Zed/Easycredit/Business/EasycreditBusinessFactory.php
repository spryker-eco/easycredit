<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business;

use GuzzleHttp\ClientInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\ApprovalTextLoaderAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\DisplayInterestAndAdjustTotalSumAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\Factory\AdapterFactory;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\Factory\AdapterFactoryInterface;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\InitializePaymentAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\OrderConfirmationAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\PreContractualInformationAndRedemptionPlanAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\QueryCreditAssessmentAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Client\EasycreditClient;
use SprykerEco\Zed\Easycredit\Business\Api\RequestSender\RequestSender;
use SprykerEco\Zed\Easycredit\Business\Api\RequestSender\RequestSenderInterface;
use SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLogger;
use SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface;
use SprykerEco\Zed\Easycredit\Business\Mapper\EasycreditMapper;
use SprykerEco\Zed\Easycredit\Business\Mapper\InitializePaymentMapper;
use SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\ApprovalTextResponseParser;
use SprykerEco\Zed\Easycredit\Business\Parser\DisplayInterestAndAdjustTotalSumParser;
use SprykerEco\Zed\Easycredit\Business\Parser\InitializePaymentResponseParser;
use SprykerEco\Zed\Easycredit\Business\Parser\OrderConfirmationResponseParser;
use SprykerEco\Zed\Easycredit\Business\Parser\ParserInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\PreContractualInformationAndRedemptionPlanParser;
use SprykerEco\Zed\Easycredit\Business\Parser\QueryCreditAssessmentResponseParser;
use SprykerEco\Zed\Easycredit\Business\Parser\ResponseParser;
use SprykerEco\Zed\Easycredit\Business\Parser\ResponseParserInterface;
use SprykerEco\Zed\Easycredit\Business\Payment\PaymentMethodFilter;
use SprykerEco\Zed\Easycredit\Business\Payment\PaymentMethodFilterInterface;
use SprykerEco\Zed\Easycredit\Business\Processor\ApprovalTextProcessor\EasycreditApprovalTextProcessor;
use SprykerEco\Zed\Easycredit\Business\Processor\ApprovalTextProcessor\EasycreditApprovalTextProcessorInterface;
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
     * @return \GuzzleHttp\ClientInterface
     */
    public function createEasycreditClient(): ClientInterface
    {
        return new EasycreditClient();
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\AdapterInterface
     */
    public function createPreContractualInformationAndRedemptionPlanAdapter(): AdapterInterface
    {
        return new PreContractualInformationAndRedemptionPlanAdapter($this->createEasycreditClient(), $this->getUtilEncodingService(), $this->getConfig());
    }

    /**
     * @return \SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): EasycreditToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(EasycreditDependencyProvider::UTIL_ENCODING_SERVICE);
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Payment\PaymentMethodFilterInterface
     */
    public function createPaymentMethodFilter(): PaymentMethodFilterInterface
    {
        return new PaymentMethodFilter();
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface
     */
    public function createEasycreditLogger(): EasycreditLoggerInterface
    {
        return new EasycreditLogger($this->getEntityManager());
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Saver\EasycreditOrderIdentifierSaverInterface
     */
    public function createEasycreditOrderIdentifierSaver(): EasycreditOrderIdentifierSaverInterface
    {
        return new EasycreditOrderIdentifierSaver($this->getEntityManager());
    }

    /**
     * @return MapperInterface
     */
    public function createMapper(): MapperInterface
    {
        return new EasycreditMapper($this->getConfig());
    }

    /**
     * @return AdapterFactoryInterface
     */
    public function createAdapterFactory(): AdapterFactoryInterface
    {
        return new AdapterFactory(
            $this->createEasycreditClient(),
            $this->getUtilEncodingService(),
            $this->getConfig()
        );
    }

    /**
     * @return ResponseParserInterface
     */
    public function createResponseParser(): ResponseParserInterface
    {
        return new ResponseParser();
    }

    /**
     * @return RequestSenderInterface
     */
    public function createRequestSender(): RequestSenderInterface
    {
        return new RequestSender(
            $this->createMapper(),
            $this->createAdapterFactory(),
            $this->createResponseParser(),
            $this->createEasycreditLogger(),
            $this->getRepository(),
            $this->getEntityManager()
        );
    }
}
