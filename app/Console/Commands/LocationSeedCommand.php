<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\Region;
use App\Models\City;
use App\Models\Metro;
use Illuminate\Console\Command;
use GuzzleHttp\Client as Guzzle;

class LocationSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:location {--truncate : Truncate tables}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Location seed command';

    protected $client;

    // 'https://api.vk.com/method/database.getCountries?uid=' .
    // config('services.vk_api.uid') . '&access_token=' .
    // config('services.vk_api.access_token') . '&v=' .
    // config('services.vk_api.version') .
    // '&need_all=1&count=1000';

    /**
     * Create a new command instance.
     *
     * @param Guzzle $client
     */
    public function __construct(Guzzle $client)
    {
        parent::__construct();

        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $countryMap = [];

        $regionMap = [];

        if ($this->option('truncate')) {
            \Schema::disableForeignKeyConstraints();
            \App\Models\Metro::truncate();
            \App\Models\CityDistrict::truncate();
            \App\Models\City::truncate();
            \App\Models\Region::truncate();
            \App\Models\Country::truncate();
            \Schema::enableForeignKeyConstraints();
        }

        $languages = ['ru','en'];

        foreach ($languages as $language) {
            $countries[$language] = array_pluck($this->getCountries($language),'title','id');
        }

        foreach ($countries['ru'] as $id => $title) {
            $nameData = [];
            foreach ($languages as $language) {
                $nameData[$language] = $countries[$language][$id];
            }
            $country = Country::create([
                'name' => $nameData,
                'currency' => 'RUB',
            ]);
            $countryMap[$id] = $country->id; // foreign country id, local country id

        }

        foreach ($countryMap as $key => $value) {
            foreach ($this->getRegionsByCountryId($key) as $region) {
                $currentRegion = Region::create([
                    'country_id' => $value,
                    'name' => ['ru' => $region->title]
                ]);

                $regionMap[$region->id] = $currentRegion->id; // foreign region id, local region id
            }
        }

        foreach ($countryMap as $countryKey => $countryValue) { // $countryKey => foreign country id, $countryValue => local country id
            foreach ($regionMap as $regionKey => $regionValue) { // $regionKey => foreign region id, $regionValue => local region id
                foreach ($this->getCitiesByCountryIdAndRegionId($countryKey, $regionKey) as $city) {
                    City::create([
                        'region_id' => $regionValue,
                        'name' => ['ru' => $city->title]
                    ]);
                }
            }
        } 
    }

    protected function getCountries($language)
    {
        $response = $this->client->request('GET',
            'https://api.vk.com/method/database.getCountries?uid=' .
            config('services.vk_api.uid') . '&access_token=' .
            config('services.vk_api.access_token') . '&v=' .
            config('services.vk_api.version') .
            '&need_all=1&count=1000&lang=' . $language
        );

        return json_decode($response->getBody())->response->items;
    }

    protected function getRegionsByCountryId($countryId)
    {
        $response = $this->client->request('GET',
            'https://api.vk.com/method/database.getRegions?uid=' .
            config('services.vk_api.uid') . '&access_token=' .
            config('services.vk_api.access_token') . '&v=' .
            config('services.vk_api.version') .
            '&need_all=1&count=1000&country_id=' . $countryId
        );

        return json_decode($response->getBody())->response->items;
    }

    protected function getCitiesByCountryIdAndRegionId($countryId, $regionId)
    {
        $response = $this->client->request('GET',
            'https://api.vk.com/method/database.getCities?uid=' .
            config('services.vk_api.uid') . '&access_token=' .
            config('services.vk_api.access_token') . '&v=' .
            config('services.vk_api.version') .
            '&need_all=1&count=1000&country_id=' . $countryId .
            '&region_id=' . $regionId
        );

        return json_decode($response->getBody())->response->items;
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
