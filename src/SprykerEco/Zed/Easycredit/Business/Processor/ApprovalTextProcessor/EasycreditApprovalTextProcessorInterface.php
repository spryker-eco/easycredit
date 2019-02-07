<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\ApprovalTextProcessor;

use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;

interface EasycreditApprovalTextProcessorInterface
{
    /**
     * @return \Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer
     */
    public function process(): EasycreditApprovalTextResponseTransfer;
}
