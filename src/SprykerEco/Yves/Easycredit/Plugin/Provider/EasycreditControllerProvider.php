<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit\Plugin\Provider;

use Silex\Application;
use SprykerShop\Yves\ShopApplication\Plugin\Provider\AbstractYvesControllerProvider;

class EasycreditControllerProvider extends AbstractYvesControllerProvider
{
    public const ROUTE_EASYCREDIT_SUCCESS_RESPONSE = 'easycredit/success-response';

    /**
     * @param \Silex\Application $app
     *
     * @return $this
     */
    protected function defineControllers(Application $app)
    {
        $this->createController('/easycredit/payment/success', self::ROUTE_EASYCREDIT_SUCCESS_RESPONSE, 'Easycredit', 'Easycredit', 'successEasycreditResponse')
            ->method('GET');

        return $this;
    }
}
