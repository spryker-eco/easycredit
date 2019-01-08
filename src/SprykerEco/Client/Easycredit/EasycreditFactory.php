<?php

namespace SprykerEco\Client\Easycredit;

use SprykerEco\Client\Easycredit\Zed\EasycreditStub;
use Spryker\Client\Kernel\AbstractFactory;

class EasycreditFactory extends AbstractFactory
{

    /**
     * @return \SprykerEco\Client\Easycredit\Zed\EasycreditStubInterface
     */
    public function createZedStub()
    {
        return new EasycreditStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient()
    {
        return $this->getProvidedDependency(EasycreditDependencyProvider::CLIENT_ZED_REQUEST);
    }

}
