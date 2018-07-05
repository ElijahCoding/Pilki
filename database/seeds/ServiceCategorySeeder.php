<?php

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    public function run()
    {
        $serviceCategories = [
            [
                'legal_entity_id' => 1,
                'title'           => [
                    'ru' => 'Маникюр',
                ],
            ],
            [
                'legal_entity_id' => 1,
                'title'           => [
                    'ru' => 'Педикюр',
                ],
            ],
            [
                'legal_entity_id' => 1,
                'title'           => [
                    'ru' => 'Снятие',
                ],
            ],
        ];

        foreach ($serviceCategories as $serviceCategory) {
            ServiceCategory::create($serviceCategory);
        }
    }
}
