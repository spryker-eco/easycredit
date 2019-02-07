<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Mapper;

use Generated\Shared\Transfer\QuoteTransfer;

interface MapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $transfer
     *
     * @return array
     */
    public function map(QuoteTransfer $transfer): array;
}
