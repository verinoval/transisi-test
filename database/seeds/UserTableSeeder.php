<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'  => 'admin',
            'level_id' => '1',
            'email' => 'admin@email.com',
            'password'  => bcrypt('admin')
        ]);

        User::create([
            'name'  => 'test',
            'level_id' => '2',
            'email' => 'test@email.com',
            'password'  => bcrypt('test')
        ]);
    }
}
