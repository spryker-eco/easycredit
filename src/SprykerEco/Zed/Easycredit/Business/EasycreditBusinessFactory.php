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
use SprykerEco\Zed\Easycredit\Business\Api\Adapter\Http\InitializePaymentAdapter;
use SprykerEco\Zed\Easycredit\Business\Api\Client\EasycreditClient;
use SprykerEco\Zed\Easycredit\Business\Mapper\InitializePaymentMapper;
use SprykerEco\Zed\Easycredit\Business\Mapper\MapperInterface;
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
        return new InitializePaymentAdapter($this->createEasycreditClient(), $this->getUtilEncodingService());
    }

    /**
     * @return EasycreditToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): EasycreditToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(EasycreditDependencyProvider::UTIL_ENCODING_SERVICE);
    }

    public function createInitializePaymentMapper(): MapperInterface
    {
        return new InitializePaymentMapper($this->getConfig());
    }
}
