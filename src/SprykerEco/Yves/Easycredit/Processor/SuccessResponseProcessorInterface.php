<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Easycredit\Processor;

use Generated\Shared\Transfer\QuoteTransfer;

interface SuccessResponseProcessorInterface
{
    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function process(): QuoteTransfer;
}
