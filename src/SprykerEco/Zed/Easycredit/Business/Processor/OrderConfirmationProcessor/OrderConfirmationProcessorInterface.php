<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Easycredit\Business\Processor\OrderConfirmationProcessor;

interface OrderConfirmationProcessorInterface
{
    /**
     * @param int $idOrder
     *
     * @return void
     */
    public function process(int $idOrder): void;
}
