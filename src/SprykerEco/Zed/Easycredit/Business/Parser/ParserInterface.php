<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Psr\Http\Message\StreamInterface;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

interface ParserInterface
{
    /**
     * @param StreamInterface $response
     *
     * @return EasycreditInitializePaymentResponseTransfer
     */
    public function parse(StreamInterface $response): EasycreditInitializePaymentResponseTransfer;
}
