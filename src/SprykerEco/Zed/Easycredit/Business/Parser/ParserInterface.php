<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditResponseTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

interface ParserInterface
{
    /**
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    public function parse(EasycreditResponseTransfer $easycreditResponseTransfer): AbstractTransfer;
}
