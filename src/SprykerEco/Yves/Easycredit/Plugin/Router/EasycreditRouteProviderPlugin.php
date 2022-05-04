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
    /**
     * @var string
     */
    protected const ROUTE_NAME_EASYCREDIT_SUCCESS_RESPONSE = 'easycredit/success-response';

    /**
     * {@inheritDoc}
     * - Adds Easycredit specific Routes to the RouteCollection.
     *
     * @api
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addEasycreditSuccessRoute($routeCollection);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addEasycreditSuccessRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/easycredit/payment/success', 'Easycredit', 'Easycredit', 'successEasycreditResponse');
        $route = $route->setMethods([Request::METHOD_GET]);
        $routeCollection->add(static::ROUTE_NAME_EASYCREDIT_SUCCESS_RESPONSE, $route);

        return $routeCollection;
    }
}
