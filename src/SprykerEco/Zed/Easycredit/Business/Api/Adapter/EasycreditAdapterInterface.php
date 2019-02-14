<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Api\Adapter;

use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;

interface EasycreditAdapterInterface
{
    /**
     * @param \Generated\Shared\Transfer\EasycreditRequestTransfer $easycreditRequestTransfer
     *
     * @return \Generated\Shared\Transfer\EasycreditResponseTransfer
     */
    public function sendRequest(EasycreditRequestTransfer $easycreditRequestTransfer): EasycreditResponseTransfer;
}
