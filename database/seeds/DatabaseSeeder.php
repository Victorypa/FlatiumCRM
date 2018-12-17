<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ServiceTypeTableSeeder::class);
        $this->call(UnitTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ManagerTableSeeder::class);
        $this->call(RoomTypesTableSeeder::class);
    }
}
