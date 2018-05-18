<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

use App\Performance;

class PerformancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Performance::firstOrCreate([
        'id' => 1,
        'name' => 'Excellent'
        ]);
        Performance::firstOrCreate([
        'id' => 2,
        'name' => 'Good'
        ]);
        Performance::firstOrCreate([
        'id' => 3,
        'name' => 'Bad'
        ]);
    }
}
