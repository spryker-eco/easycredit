<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Client\Easycredit;

use Spryker\Client\Kernel\AbstractFactory;
use SprykerEco\Client\Easycredit\Dependency\Client\EasycreditToZedRequestClientInterface;
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
     * @return \SprykerEco\Client\Easycredit\Dependency\Client\EasycreditToZedRequestClientInterface
     */
    protected function getZedRequestClient(): EasycreditToZedRequestClientInterface
    {
        return $this->getProvidedDependency(EasycreditDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
