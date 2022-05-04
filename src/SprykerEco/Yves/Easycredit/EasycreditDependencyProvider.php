<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;
use Spryker\Yves\Money\Plugin\MoneyPlugin;
use SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToCalculationClientBridge;
use SprykerEco\Yves\Easycredit\Dependency\Client\EasycreditToQuoteClientBridge;

class EasycreditDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_CALCULATION = 'CLIENT_CALCULATION';

    /**
     * @var string
     */
    public const CLIENT_QUOTE = 'CLIENT_QUOTE';

    /**
     * @var string
     */
    public const PLUGIN_MONEY = 'PLUGIN_MONEY';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addClientCalculation($container);
        $container = $this->addClientQuote($container);
        $container = $this->addPluginMoney($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addClientCalculation(Container $container): Container
    {
        $container->set(static::CLIENT_CALCULATION, function (Container $container) {
            return new EasycreditToCalculationClientBridge($container->getLocator()->calculation()->client());
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addClientQuote(Container $container): Container
    {
        $container->set(static::CLIENT_QUOTE, function (Container $container) {
            return new EasycreditToQuoteClientBridge($container->getLocator()->quote()->client());
        });

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addPluginMoney(Container $container): Container
    {
        $container->set(static::PLUGIN_MONEY, function () {
            return new MoneyPlugin();
        });

        return $container;
    }
}
