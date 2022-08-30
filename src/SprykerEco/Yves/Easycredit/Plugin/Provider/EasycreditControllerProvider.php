<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit\Plugin\Provider;

use Silex\Application;
use SprykerShop\Yves\ShopApplication\Plugin\Provider\AbstractYvesControllerProvider;

/**
 * @deprecated Use {@link \SprykerEco\Yves\Easycredit\Plugin\Router\EasycreditRouteProviderPlugin} instead.
 */
class EasycreditControllerProvider extends AbstractYvesControllerProvider
{
    /**
     * @var string
     */
    public const ROUTE_EASYCREDIT_SUCCESS_RESPONSE = 'easycredit/success-response';

    /**
     * @param \Silex\Application $app
     *
     * @return $this
     */
    protected function defineControllers(Application $app)
    {
        $this->createController('/easycredit/payment/success', static::ROUTE_EASYCREDIT_SUCCESS_RESPONSE, 'Easycredit', 'Easycredit', 'successEasycreditResponse')
            ->method('GET');

        return $this;
    }
}
