<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit\Plugin\Router;

use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;

class EasycreditRouteProviderPlugin extends AbstractRouteProviderPlugin
{
    public const ROUTE_NAME_EASYCREDIT_SUCCESS_RESPONSE = 'easycredit/success-response';

    /**
     * {@inheritDoc}
     * - Adds easycredit success response action to RouteCollection.
     *
     * @api
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/easycredit/payment/success', 'Easycredit', 'Easycredit', 'successEasycreditResponse');
        $route = $route->setMethods([Request::METHOD_GET]);
        $routeCollection->add(static::ROUTE_NAME_EASYCREDIT_SUCCESS_RESPONSE, $route);

        return $routeCollection;
    }
}
