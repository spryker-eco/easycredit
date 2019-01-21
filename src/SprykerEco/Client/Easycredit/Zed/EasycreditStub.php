<?php

namespace SprykerEco\Client\Easycredit\Zed;

use Generated\Shared\Transfer\EasycreditInitializePaymentResponseTransfer;
use Generated\Shared\Transfer\EasycreditQueryAssessmentResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Client\ZedRequest\Stub\ZedRequestStub;

class EasycreditStub extends ZedRequestStub implements EasycreditStubInterface
{
    /**
     * @param QuoteTransfer $quoteTransfer
     *
     * @return EasycreditInitializePaymentResponseTransfer
     */
    public function sendEasycreditPaymentInitialize(QuoteTransfer $quoteTransfer): EasycreditInitializePaymentResponseTransfer
    {
        return $this->zedStub->call('/easycredit/gateway/send-easycredit-payment-initialize', $quoteTransfer);
    }

    public function sendEasycreditQueryAssessmentRequest(QuoteTransfer $quoteTransfer): EasycreditQueryAssessmentResponseTransfer
    {
        return $this->zedStub->call('/easycredit/gateway/send-easycredit-query-assessment-request', $quoteTransfer);
    }
}
