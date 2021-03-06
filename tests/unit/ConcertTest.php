<?php

use App\Concert;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConcertTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function can_get_formatted_date()
    {
        $concert = factory(Concert::class)->make([
            'date' => Carbon::parse('2017-03-15 8:00pm')
        ]);

        $this->assertEquals('March 15, 2017',  $concert->formatted_date);
    }

    /** @test */
    function can_get_formatted_start_time()
    {
        $concert = factory(Concert::class)->make([
            'date' => Carbon::parse('2017-03-15 17:00:00')
        ]);

        $this->assertEquals('5:00pm', $concert->formatted_start_time);
    }

    /** @test */
    function can_get_ticket_price_in_pounds()
    {
        $concert = factory(Concert::class)->make([
            'ticket_price' => 6750
        ]);

        $this->assertEquals('67.50', $concert->ticket_price_in_pounds);
    }

    /** @test */
    function concerts_with_a_published_at_date_are_published()
    {
        $published_concert_a = factory(Concert::class)->create([
            'published_at' => Carbon::parse('-1 week')
        ]);
        $published_concert_b = factory(Concert::class)->create([
            'published_at' => Carbon::parse('-1 week')
        ]);
        $unpublished_concert = factory(Concert::class)->create([
            'published_at' => null
        ]);

        $published_concerts = Concert::published()->get();

        $this->assertTrue($published_concerts->contains($published_concert_a));
        $this->assertTrue($published_concerts->contains($published_concert_b));
        $this->assertFalse($published_concerts->contains($unpublished_concert));
    }
}
