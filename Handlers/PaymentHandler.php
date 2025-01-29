<?php

namespace Modules\Forms\Handlers;

use App\Facades\ServiceHandler;
use App\Models\Payment;
use Modules\Forms\Entities\Submission;

class PaymentHandler extends ServiceHandler
{
    /**
     * This event will be fired once the payment is completed
     */
    public function onPaymentCompleted(Payment $payment)
    {
        $submission = Submission::find($payment->options['submission_id']);
        $submission->onPaid();
    }

    /**
     * This event will be fired once the payment is completed
     */
    public function onPaymentFailed(Payment $payment)
    {
        //
    }

    public function onPaymentPending(Payment $payment)
    {
        //
    }

    public function onPaymentDeclined(Payment $payment)
    {
        //
    }

    public function onPaymentExpired(Payment $payment)
    {
        //
    }
}
