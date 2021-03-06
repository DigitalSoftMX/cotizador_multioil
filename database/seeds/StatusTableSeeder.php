<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create(['name' => 'pendiente']);
        Status::create(['name' => 'autorizado']);
        Status::create(['name' => 'denegado']);
    }
}
