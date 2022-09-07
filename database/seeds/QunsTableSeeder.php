<?php

use App\Models\Qun;
use Illuminate\Database\Seeder;

class QunsTableSeeder extends Seeder
{
    public function run()
    {
        $quns = factory(Qun::class)->times(50)->create();
    }

}
