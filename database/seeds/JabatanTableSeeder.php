<?php

use Illuminate\Database\Seeder;

use App\Models\Jabatan;

class JabatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Jabatan::create([
            'jabatan'  => 'admin'
        ]);

        Jabatan::create([
            'jabatan'  => 'teknisi',
        ]);

        Jabatan::create([
            'jabatan'  => 'operator',
        ]);
    }
}
