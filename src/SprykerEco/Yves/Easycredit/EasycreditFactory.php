<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Easycredit;

use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use SprykerEco\Yves\Easycredit\Form\DataProvider\EasycreditDataProvider;
use SprykerEco\Yves\Easycredit\Form\EasycreditSubForm;

class EasycreditFactory extends AbstractFactory
{
    /**
     * @return SubFormInterface
     */
    public function createEasycreditSubForm(): SubFormInterface
    {
        return new EasycreditSubForm();
    }

    /**
     * @return StepEngineFormDataProviderInterface
     */
    public function createEasycreditDataProvider(): StepEngineFormDataProviderInterface
    {
        return new EasycreditDataProvider();
    }

    /**
     * @return \SprykerEco\Yves\Easycredit\Handler\EasycreditPrePostPaymentHandlerInterface
     */
    public function createEasycreditPaymentHandler()
    {
        return new EasycreditPaymentHandler(
            $this->createInitEasyCreditConverter(),
            $this->getComputopClient(),
            $this->getCalculationClient()
        );
    }

}
