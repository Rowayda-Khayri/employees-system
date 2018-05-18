<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

use App\Position;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        
        Position::firstOrCreate([
        'id' => 1,
        'name' => 'Manager'
        ]);
        Position::firstOrCreate([
        'id' => 2,
        'name' => 'Sales Man'
        ]);
    }
}
