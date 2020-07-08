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
            'email' => 'admin@email.com',
            'password'  => bcrypt('admin')
        ]);

        User::create([
            'name'  => 'test',
            'email' => 'test@email.com',
            'password'  => bcrypt('test')
        ]);
    }
}
