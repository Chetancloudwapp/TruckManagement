<?php

namespace Modules\Admin\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\app\Models\Admin;
use Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('123456');
        $adminRecords = [
            ['id'=>1, 'name'=>'Admin', 'email'=>'admin@admin.com', 'password'=> $password],
        ];
        Admin::insert($adminRecords);
    }
}
