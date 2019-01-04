<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Computop\Handler;

use SprykerEco\Client\Easycredit\ComputopClientInterface;
use SprykerEco\Yves\Computop\Easycredit\ConverterInterface;

abstract class AbstractPrePostPaymentHandler implements ComputopPrePostPaymentHandlerInterface
{
    /**
     * @var \SprykerEco\Yves\Easycredit\Converter\ConverterInterface
     */
    protected $converter;

    /**
     * @var \SprykerEco\Client\Easycredit\ComputopClientInterface
     */
    protected $computopClient;

    /**
     * @param \SprykerEco\Yves\Easycredit\Converter\ConverterInterface $converter
     * @param \SprykerEco\Client\Easycredit\ComputopClientInterface $computopClient
     */
    public function __construct(ConverterInterface $converter, ComputopClientInterface $computopClient)
    {
        $this->converter = $converter;
        $this->computopClient = $computopClient;
    }
}
