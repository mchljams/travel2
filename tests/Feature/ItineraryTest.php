<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Itinerary;
use Illuminate\Support\Facades\Artisan;

class ItineraryTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('config:cache');
        Artisan::call('config:clear');

        Artisan::call('migrate');
        Artisan::call('db:seed');

        $this->user = User::all()->random(1)->first();
    }


    public function tearDown(): void
    {
        parent::tearDown();

        //Artisan::call('migrate:reset');
        Artisan::call('config:cache');
        Artisan::call('config:clear');
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

//
//    /**
//     * A feature test to get all itineraries without a bearer token
//     *
//     * @return void
//     */
//    public function testGetAllItinerariesWithoutBearerToken()
//    {
//
//        $response = $this->withHeaders([
//            'Accept' => 'application/json'
//
//        ])->get('/api/itineraries');
//
//        $response->assertStatus(401);
//    }
//
//    /**
//     * A feature test to get a single itinerary with a bearer token
//     *
//     * @return void
//     */
//    public function testGetSingleItinerariesWithBearerToken()
//    {
//        $itinerary = Itinerary::all()->random(1)->first();
//
//        $response = $this->withHeaders([
//            'Authorization' => 'Bearer ' . $this->user->api_token,
//            'Accept' => 'application/json'
//
//        ])->get('/api/itineraries/' . $itinerary->id);
//
//        $response->assertStatus(200);
//
//    }
//
//
//    /**
//     * A feature test to attempt to get a itinerary that does not exist
//     *
//     * @return void
//     */
//    public function testGetSingleItineraryThatDoesNotExist()
//    {
//        $itinerary = $this->getItineraryThatDoesNotExist();
//
//
//        $response = $this->withHeaders([
//            'Authorization' => 'Bearer ' . $this->user->api_token,
//            'Accept' => 'application/json'
//
//        ])->get('/api/itineraries/' . $itinerary);
//
//
//        $response->assertJson([]);
//
//    }
//
//    /**
//     * A helper function to generate a itinerary id that does not exist
//     *
//     * @return int
//     */
//    function getItineraryThatDoesNotExist()
//    {
//
//        $itinerary = DB::table('itineraries')->orderBy('id', 'desc')->first();
//
//        return $itinerary->id + 1;
//
//    }

//    function testCreateNewItinerary()
//    {
//
//        $data = [
//            'name' => $this->faker->word(),
//            'user_id' => $this->user->id,
//        ];
//
//        $headers = [
//            'Authorization' => 'Bearer ' . $this->user->api_token,
//            'Accept' => 'application/json'
//        ];
//
//
//
//        $response = $this->withHeaders($headers)->post('/api/itineraries/', $data);
//
//    }
}
