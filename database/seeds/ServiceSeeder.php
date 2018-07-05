<?php

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'legal_entity_id'     => 1,
                'service_category_id' => 1,
                'title'               => ['ru' => 'Маникюр Люкс'],
                'title_online'        => ['ru' => 'Маникюр Люкс online'],
                'title_cashier'       => ['ru' => 'Маникюр Люкс чек'],
                'article'             => 'Элитный Маникюр',
                'barcode'             => str_random(13),
                'duration'            => rand(30, 120),
            ],
            [
                'legal_entity_id'     => 1,
                'service_category_id' => 2,
                'title'               => ['ru' => 'Снятие Люкс'],
                'title_online'        => ['ru' => 'Снятие Люкс online'],
                'title_cashier'       => ['ru' => 'Снятие Люкс чек'],
                'article'             => 'Элитный Маникюр',
                'barcode'             => str_random(13),
                'duration'            => rand(30, 120),
            ],
            [
                'legal_entity_id'     => 1,
                'service_category_id' => 3,
                'title'               => ['ru' => 'Педикюр Люкс'],
                'title_online'        => ['ru' => 'Педикюр Люкс online'],
                'title_cashier'       => ['ru' => 'Педикюр Люкс чек'],
                'article'             => 'Элитный Маникюр',
                'barcode'             => str_random(13),
                'duration'            => rand(30, 120),
            ],
        ];


        foreach ($services as $service) {
            Service::create($service);
        }


    }
}
