<?php

use Illuminate\Database\Seeder;
use GuzzleHttp\Client as Guzzle;

class MetroSeeder extends Seeder
{
    protected $client;

    public function __construct(Guzzle $client)
    {
        $this->client = $client;
    }

    public function run()
    {
        $cityMoscow = factory('App\Models\City')->create(['name' => 'Москва']);

        $MoscowMetros = $this->getMoscowMetros();

        foreach ($MoscowMetros->objects as $metro) {
            $cityMoscow->metros()->create([
                'name' => $metro->title
            ]);
        }

        $citySPB = factory('App\Models\City')->create(['name' => 'Санкт-Петербург']);

        $SPBMetros = $this->getSPBMetros();

        foreach ($SPBMetros->objects as $metro) {
            $citySPB->metros()->create([
                'name' => $metro->title
            ]);
        }
    }

    protected function getMoscowMetros()
    {
        $response = $this->client->request('GET', 'https://api.superjob.ru/2.0/suggest/town/4/metro/all/');

        return json_decode($response->getBody());
    }

    protected function getSPBMetros()
    {
        $response = $this->client->request('GET', 'https://api.superjob.ru/2.0/suggest/town/14/metro/all/');

        return json_decode($response->getBody());
    }
}
