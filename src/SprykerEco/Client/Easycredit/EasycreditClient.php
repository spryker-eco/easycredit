<?php

namespace SprykerEco\Client\Easycredit;

use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \SprykerEco\Client\Easycredit\EasycreditFactory getFactory()
 */
class EasycreditClient extends AbstractClient implements EasycreditClientInterface
{

    /**
     * @return \SprykerEco\Client\Easycredit\Zed\EasycreditStubInterface
     */
    protected function getZedStub()
    {
        return $this->getFactory()->createZedStub();
    }
}
