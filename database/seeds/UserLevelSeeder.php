<?php

use Illuminate\Database\Seeder;
use App\Models\UserLevel;

class UserLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserLevel::create([
            'level_name'  => 'admin'
        ]);

        UserLevel::create([
            'level_name'  => 'owner',
        ]);
    }
}
