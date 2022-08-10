<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Communication\Plugin\Oms\Condition;

use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;

/**
 * @method \SprykerEco\Zed\Easycredit\Business\EasycreditFacadeInterface getFacade()
 * @method \SprykerEco\Zed\Easycredit\EasycreditConfig getConfig()
 */
class IsOrderConfirmedPlugin extends AbstractPlugin implements ConditionInterface
{
    /**
     * @var string
     */
    public const NAME = 'IsOrderConfirmed';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return bool
     */
    public function check(SpySalesOrderItem $orderItem)
    {
        return (bool)$this->getFacade()->sendOrderConfirmationRequest($orderItem->getFkSalesOrder())->getConfirmed();
    }
}
