<?php

use App\Models\Country;
use Yandex\Translate\Translator;
use Yandex\Translate\Exception;
use Illuminate\Database\Seeder;
use GuzzleHttp\Client as Guzzle;

class CountrySeeder extends Seeder
{
    protected $client;

    public function __construct(Guzzle $client)
    {
        $this->client = $client;
    }

    public function run()
    {
        $translator = new Translator(config('services.yandex_translator.key'));

        $countries = $this->get();

        foreach ($countries as $country) {
            Country::create([
                'name'     => [
                    'en' => $country->name,
                    'ru' => $country->name, //$translator->translate($country->name, 'en-ru'),
                ],
                'currency' => $country->currencies[0]->code ?? 'RUB',
            ]);
        }
    }

    protected function get()
    {
        $response = $this->client->request('GET', 'https://restcountries.eu/rest/v2/all');

        return json_decode($response->getBody());
    }
}
