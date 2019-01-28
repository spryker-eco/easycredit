<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use SprykerEco\Zed\Easycredit\Persistence\Mapper\EasycreditPersistenceMapper;
use SprykerEco\Zed\Easycredit\Persistence\Mapper\EasycreditPersistenceMapperInterface;

class EasycreditPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return EasycreditPersistenceMapperInterface
     */
    public function createEasycreditPersistenceMapper(): EasycreditPersistenceMapperInterface
    {
        return new EasycreditPersistenceMapper();
    }
}
