<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(LinksTableSeeder::class);
        if (app()->isLocal()) {
            $this->call(TopicsTableSeeder::class);
            $this->call(RepliesTableSeeder::class);
            $this->call(VideosTableSeeder::class);
            $this->call(QunsTableSeeder::class);
            $this->call(RecordsTableSeeder::class);
        }
        $this->call(ArticlesTableSeeder::class);
        $this->call(SalespersonSeeder::class);
    }
}
