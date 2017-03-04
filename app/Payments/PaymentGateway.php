<?php

namespace App\Payments;

interface PaymentGateway
{
    public function charge($amount, $token);
}
