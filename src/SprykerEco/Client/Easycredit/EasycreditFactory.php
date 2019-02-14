<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Client\Easycredit;

use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use SprykerEco\Client\Easycredit\Zed\EasycreditStub;
use SprykerEco\Client\Easycredit\Zed\EasycreditStubInterface;

class EasycreditFactory extends AbstractFactory
{
    /**
     * @return \SprykerEco\Client\Easycredit\Zed\EasycreditStubInterface
     */
    public function createZedStub(): EasycreditStubInterface
    {
        return new EasycreditStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(EasycreditDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
