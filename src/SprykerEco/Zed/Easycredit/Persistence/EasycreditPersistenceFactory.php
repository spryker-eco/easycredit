<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Persistence;

use Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditOrderIdentifierQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use SprykerEco\Zed\Easycredit\Persistence\Mapper\EasycreditPersistenceMapper;
use SprykerEco\Zed\Easycredit\Persistence\Mapper\EasycreditPersistenceMapperInterface;

/**
 * @method \SprykerEco\Zed\Easycredit\EasycreditConfig getConfig()
 * @method \SprykerEco\Zed\Easycredit\Persistence\EasycreditEntityManagerInterface getEntityManager()
 * @method \SprykerEco\Zed\Easycredit\Persistence\EasycreditRepositoryInterface getRepository()
 *
 * @SuppressWarnings(PHPMD)
 */
class EasycreditPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \SprykerEco\Zed\Easycredit\Persistence\Mapper\EasycreditPersistenceMapperInterface
     */
    public function createEasycreditPersistenceMapper(): EasycreditPersistenceMapperInterface
    {
        return new EasycreditPersistenceMapper();
    }

    /**
     * @return \Orm\Zed\Easycredit\Persistence\SpyPaymentEasycreditOrderIdentifierQuery
     */
    public function createPaymentEasycreditOrderIdentifierQuery(): SpyPaymentEasycreditOrderIdentifierQuery
    {
        return SpyPaymentEasycreditOrderIdentifierQuery::create();
    }
}
