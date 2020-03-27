<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['role_name' => 'ROLE_USER'],
            ['role_name' => 'ROLE_ADMIN'],
            ['role_name' => 'ROLE_SUPER_ADMIN']
        ]);
    }
}
