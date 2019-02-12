<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit\Controller;

use SprykerShop\Yves\CheckoutPage\Plugin\Provider\CheckoutPageControllerProvider;
use SprykerShop\Yves\ShopApplication\Controller\AbstractController;

/**
 * @method \SprykerEco\Yves\Easycredit\EasycreditFactory getFactory()
 */
class EasycreditController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function successEasycreditResponseAction()
    {
        $this->getFactory()->createSuccessResponseProcessor()->process();

        return $this->redirectResponseInternal(CheckoutPageControllerProvider::CHECKOUT_SUMMARY);
    }
}
