<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Parser;

use Psr\Http\Message\StreamInterface;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

interface ParserInterface
{
    /**
     * @param StreamInterface $response
     *
     * @return AbstractTransfer
     */
    public function parse(StreamInterface $response): AbstractTransfer;
}
