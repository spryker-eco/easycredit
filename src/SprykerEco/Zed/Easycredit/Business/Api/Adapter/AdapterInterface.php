<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Api\Adapter;

use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;

interface AdapterInterface
{
    /**
     * @param EasycreditRequestTransfer $transfer
     *
     * @return EasycreditResponseTransfer
     */
    public function sendRequest(EasycreditRequestTransfer $transfer): EasycreditResponseTransfer;
}
