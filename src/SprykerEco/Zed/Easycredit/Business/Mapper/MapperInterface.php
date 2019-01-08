<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Mapper;

use Generated\Shared\Transfer\QuoteTransfer;

interface MapperInterface
{
    public function map(QuoteTransfer $transfer): array;
}
