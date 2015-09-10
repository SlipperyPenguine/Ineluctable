<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(EveApiCalllistTableSeeder::class);

        $this->call(EveCorporationRolemapSeeder::class);
        $this->call(EveNotificationTypesSeeder::class);
        $this->call(SeatPermissionsSeeder::class);
        $this->call(SeatSettingSeeder::class);

        Model::reguard();
    }
}
