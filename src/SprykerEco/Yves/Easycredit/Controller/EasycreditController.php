<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit\Controller;

use SprykerShop\Yves\CheckoutPage\Plugin\Router\CheckoutPageRouteProviderPlugin;
use SprykerShop\Yves\ShopApplication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @method \SprykerEco\Yves\Easycredit\EasycreditFactory getFactory()
 */
class EasycreditController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function successEasycreditResponseAction(): RedirectResponse
    {
        $this->getFactory()->createSuccessResponseProcessor()->process();

        $test = 2;

        return $this->redirectResponseInternal(CheckoutPageRouteProviderPlugin::ROUTE_NAME_CHECKOUT_SUMMARY);
    }
}
