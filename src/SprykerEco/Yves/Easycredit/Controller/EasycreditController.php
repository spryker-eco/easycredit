<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit\Controller;

use SprykerShop\Yves\ShopApplication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @method \SprykerEco\Yves\Easycredit\EasycreditFactory getFactory()
 */
class EasycreditController extends AbstractController
{
    /**
     * @var string
     *
     * @uses \SprykerShop\Yves\CheckoutPage\Plugin\Router\CheckoutPageRouteProviderPlugin::ROUTE_NAME_CHECKOUT_SUMMARY
     */
    protected const ROUTE_NAME_CHECKOUT_SUMMARY = 'checkout-summary';

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function successEasycreditResponseAction(): RedirectResponse
    {
        $this->getFactory()->createSuccessResponseProcessor()->process();

        return $this->redirectResponseInternal(static::ROUTE_NAME_CHECKOUT_SUMMARY);
    }
}
