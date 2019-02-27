<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit;

use Spryker\Yves\Kernel\AbstractFactory;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToCalculationClientInterface;
use SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToQuoteClientInterface;
use SprykerEco\Yves\Easycredit\Form\DataProvider\EasycreditDataProvider;
use SprykerEco\Yves\Easycredit\Form\EasycreditSubForm;
use SprykerEco\Yves\Easycredit\Handler\EasycreditPaymentHandler;
use SprykerEco\Yves\Easycredit\Handler\EasycreditPaymentHandlerInterface;
use SprykerEco\Yves\Easycredit\Processor\SuccessResponseProcessor;
use SprykerEco\Yves\Easycredit\Processor\SuccessResponseProcessorInterface;

/**
 * @method \SprykerEco\Client\Easycredit\EasycreditClientInterface getClient()
 */
class EasycreditFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    public function createEasycreditSubForm(): SubFormInterface
    {
        return new EasycreditSubForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createEasycreditDataProvider(): StepEngineFormDataProviderInterface
    {
        return new EasycreditDataProvider();
    }

    /**
     * @return \SprykerEco\Yves\Easycredit\Handler\EasycreditPaymentHandlerInterface
     */
    public function createEasycreditPaymentHandler(): EasycreditPaymentHandlerInterface
    {
        return new EasycreditPaymentHandler();
    }

    /**
     * @return \SprykerEco\Yves\Easycredit\Processor\SuccessResponseProcessorInterface
     */
    public function createSuccessResponseProcessor(): SuccessResponseProcessorInterface
    {
        return new SuccessResponseProcessor(
            $this->getQuoteClient(),
            $this->getCalculationClient(),
            $this->getClient(),
            $this->getProvidedDependency(EasycreditDependencyProvider::PLUGIN_MONEY)
        );
    }

    /**
     * @return \SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToQuoteClientInterface
     */
    public function getQuoteClient(): EasycreditToQuoteClientInterface
    {
        return $this->getProvidedDependency(EasycreditDependencyProvider::CLIENT_QUOTE);
    }

    /**
     * @return \SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToCalculationClientInterface
     */
    public function getCalculationClient(): EasycreditToCalculationClientInterface
    {
        return $this->getProvidedDependency(EasycreditDependencyProvider::CLIENT_CALCULATION);
    }
}
