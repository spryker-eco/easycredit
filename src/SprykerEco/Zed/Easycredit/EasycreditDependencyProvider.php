<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Service\Easycredit\Dependency\Service\EasycreditToUtilEncodingServiceBridge;

class EasycreditDependencyProvider extends AbstractBundleDependencyProvider
{
    public const UTIL_ENCODING_SERVICE = 'UTIL_ENCODING_SERVICE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = $this->addUtilEncodingService($container);

        return $container;

    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilEncodingService(Container $container): Container
    {
        $container[static::UTIL_ENCODING_SERVICE] = function (Container $container) {
            return new EasycreditToUtilEncodingServiceBridge($container->getLocator()->utilEncoding()->service());
        };

        return $container;
    }
}