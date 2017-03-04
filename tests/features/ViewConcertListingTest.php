<?php

use App\Concert;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewConcertListingTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    function user_can_view_concert_listing()
    {
        // Arrange
        // Create a concert
        $concert = Concert::create([
            'title' => 'Future',
            'subtitle' => 'with Young Thug',
            'date' => Carbon::parse('March 15, 2017 8:00pm'),
            'ticket_price' => 3250,
            'venue' => 'O2 Academy Brixton',
            'venue_address' => '123 Brixton Road',
            'city' => 'London',
            'postcode' => 'SW12 3BH',
            'additional_information' => 'For tickets, call (020) 7430 2345.'
        ]);

        // Act
        // View the concert listing
        $this->visit('/concerts/' . $concert->id);

        // Assert
        // See the concert details
        $this->see('Future');
        $this->see('with Young Thug');
        $this->see('March 15, 2017');
        $this->see('8:00pm');
        $this->see('32.50');
        $this->see('O2 Academy Brixton');
        $this->see('123 Brixton Road');
        $this->see('London');
        $this->see('SW12 3BH');
        $this->see('For tickets, call (020) 7430 2345.');
    }
}
