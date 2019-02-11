<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToCalculationClientBridge;
use SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToQuoteClientBridge;

class EasycreditDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_CALCULATION = 'CLIENT_CALCULATION';
    public const CLIENT_QUOTE = 'CLIENT_QUOTE';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addClientCalculation($container);
        $container = $this->addClientQuote($container);

        return parent::provideDependencies($container);
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addClientCalculation(Container $container): Container
    {
        $container[static::CLIENT_CALCULATION] = function (Container $container) {
            return new EasycreditToCalculationClientBridge($container->getLocator()->calculation()->client());
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addClientQuote(Container $container): Container
    {
        $container[static::CLIENT_QUOTE] = function (Container $container) {
            return new EasycreditToQuoteClientBridge($container->getLocator()->quote()->client());
        };

        return $container;
    }
}
