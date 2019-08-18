<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Itinerary;

class ItineraryTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::all()->random(1)->first();
    }

    /**
     * A feature test to get all itineraries with a bearer token
     *
     * @return void
     */
    public function testGetAllItinerariesWithBearerToken()
    {

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->api_token,
            'Accept' => 'application/json'

        ])->get('/api/itineraries');

        $response->assertStatus(200);

    }


    /**
     * A feature test to get all itineraries without a bearer token
     *
     * @return void
     */
    public function testGetAllItinerariesWithoutBearerToken()
    {

        $response = $this->withHeaders([
            'Accept' => 'application/json'

        ])->get('/api/itineraries');

        $response->assertStatus(401);
    }

    /**
     * A feature test to get a single itinerary with a bearer token
     *
     * @return void
     */
    public function testGetSingleItinerariesWithBearerToken()
    {
        $itinerary = Itinerary::all()->random(1)->first();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->api_token,
            'Accept' => 'application/json'

        ])->get('/api/itineraries/' . $itinerary->id);

        $response->assertStatus(200);

    }

    /**
     * A feature test to get a single itinerary without a bearer token
     *
     * @return void
     */
    public function testGetSingleItinerariesWithoutBearerToken()
    {
        $itinerary = Itinerary::all()->random(1)->first();

        $response = $this->withHeaders([
            'Accept' => 'application/json'

        ])->get('/api/itineraries/' . $itinerary->id);

        $response->assertStatus(401);

    }

}
