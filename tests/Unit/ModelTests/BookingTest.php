<?php

namespace Tests\Unit\ModelTests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_booking_belongs_to_an_employer_window()
    {
      $employerWindow = create('App\Models\EmployerWindow');

      $booking = create('App\Models\Booking', ['employer_window_id' => $employerWindow->id]);

      $this->assertInstanceOf('App\Models\EmployerWindow', $booking->employerWindow);
    }
}
