<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business;

use GuzzleHttp\ClientInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\EasycreditAdapterInterface;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\Factory\AdapterFactory;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\Factory\AdapterFactoryInterface;
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\PreContractualInformationAndRedemptionPlanAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Client\EasycreditClient;
use SprykerEco\Zed\Easycredit\Business\Api\RequestSender\RequestSender;
use SprykerEco\Zed\Easycredit\Business\Api\RequestSender\RequestSenderInterface;
use SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLogger;
use SprykerEco\Zed\Easycredit\Business\Logger\EasycreditLoggerInterface;
use SprykerEco\Zed\Easycredit\Business\Mapper\EasycreditMapper;
use SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface;
use SprykerEco\Zed\Easycredit\Business\Parser\ResponseParser;
use SprykerEco\Zed\Easycredit\Business\Parser\ResponseParserInterface;
use SprykerEco\Zed\Easycredit\Business\Payment\PaymentMethodFilter;
use SprykerEco\Zed\Easycredit\Business\Payment\PaymentMethodFilterInterface;
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
     * @return \SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): EasycreditToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(EasycreditDependencyProvider::SERVICE_UTIL_ENCODING);
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
     * @return \SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface
     */
    public function createMapper(): MapperInterface
    {
        return new EasycreditMapper($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\Factory\AdapterFactoryInterface
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
     * @return \SprykerEco\Zed\Easycredit\Business\Parser\ResponseParserInterface
     */
    public function createResponseParser(): ResponseParserInterface
    {
        return new ResponseParser();
    }

    /**
     * @return \SprykerEco\Zed\Easycredit\Business\Api\RequestSender\RequestSenderInterface
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
