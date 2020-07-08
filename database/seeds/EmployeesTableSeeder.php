<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\Models\employees;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create('id_ID');
 
    	for($i = 1; $i <= 5; $i++){
 
    	      // insert data ke table pegawai menggunakan Faker
    		DB::table('employees')->insert([
                'employee_name'  => $faker->name,
                'employee_salary' => $faker->numberBetween(1000000,5000000),
                'employee_age'  => $faker->numberBetween(25,40),
                'profile_image' => ''
    		]);
 
    	}
    }
}
