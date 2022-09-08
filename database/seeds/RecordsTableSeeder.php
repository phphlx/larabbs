<?php

use Illuminate\Database\Seeder;
use App\Models\Record;

class RecordsTableSeeder extends Seeder
{
    public function run()
    {
        $records = factory(Record::class)->times(50)->create();
    }

}

