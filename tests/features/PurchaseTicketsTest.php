<?php

use App\Concert;
use App\Payments\PaymentGateway;
use App\Payments\FakePaymentGateway;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PurchaseTicketsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function customer_can_purchase_concert_tickets()
    {
        $paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $paymentGateway);

        $concert = factory(Concert::class)->create([
            'ticket_price' => 3250
        ]);

        $this->json('POST', "/concerts/{$concert->id}/orders", [
            'email' => 'john@example.com',
            'ticket_quantity' => 3,
            'payment_token' => $paymentGateway->getValidTestToken()
        ]);

        $this->assertResponseStatus(201);

        $this->assertEquals(9750, $paymentGateway->totalCharges());

        $order = $concert->orders()->where('email', 'john@example.com')->first();

        $this->assertNotNull($order);

        $this->assertEquals(3, $order->tickets()->count());
    }

    /** @test */
    // function test_2()
    // {

    // }
}
