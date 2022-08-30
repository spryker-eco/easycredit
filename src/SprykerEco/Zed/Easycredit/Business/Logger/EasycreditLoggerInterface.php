<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\Easycredit\Business\Logger;

use Generated\Shared\Transfer\EasycreditRequestTransfer;
use Generated\Shared\Transfer\EasycreditResponseTransfer;
use Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer;

interface EasycreditLoggerInterface
{
    /**
     * @var string
     */
    public const LOG_TYPE_PAYMENT_INITIALIZE = 'payment_initialize';

    /**
     * @var string
     */
    public const LOG_TYPE_CREDIT_ASSESSMENT = 'credit_assessment';

    /**
     * @var string
     */
    public const LOG_TYPE_ORDER_CONFIRMATION = 'order_confirmation';

    /**
     * @var string
     */
    public const LOG_TYPE_APPROVAL_TEXT = 'approval_text';

    /**
     * @var string
     */
    public const LOG_TYPE_INTEREST_AND_ADJUST_TOTAL_SUM = 'interest_and_adjust_total_sum';

    /**
     * @var string
     */
    public const LOG_TYPE_PRE_CONTRACTUAL_INFORMATION_AMD_REDEMPTION_PLAN = 'pre_contractual_information_and_redemption_plan';

    /**
     * @param string $type
     * @param \Generated\Shared\Transfer\EasycreditRequestTransfer $easycreditRequestTransfer
     * @param \Generated\Shared\Transfer\EasycreditResponseTransfer $easycreditResponseTransfer
     *
     * @return \Generated\Shared\Transfer\PaymentEasycreditApiLogTransfer
     */
    public function saveApiLog(
        string $type,
        EasycreditRequestTransfer $easycreditRequestTransfer,
        EasycreditResponseTransfer $easycreditResponseTransfer
    ): PaymentEasycreditApiLogTransfer;
}
