<?php

use App\Models\LegalEntity;
use Illuminate\Database\Seeder;

class LegalEntitySeeder extends Seeder
{
    public function run()
    {
        $legalEntities = ['ООО ПИЛКИ', 'ООО Красота', 'ООО Комильфо', 'ООО Сфинкс'];

        foreach ($legalEntities as $legalEntity) {
            LegalEntity::create([
                'name' => $legalEntity
            ]);
        }
    }
}
