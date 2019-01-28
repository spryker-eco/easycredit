<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\ApprovalTextProcessor;

use Generated\Shared\Transfer\EasycreditApprovalTextResponseTransfer;

interface EasycreditApprovalTextProcessorInterface
{
    /**
     * @return EasycreditApprovalTextResponseTransfer
     */
    public function process(): EasycreditApprovalTextResponseTransfer;

}