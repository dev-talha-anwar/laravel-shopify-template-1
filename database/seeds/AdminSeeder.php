<?php

use App\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Admin();
        $admin->email = "admin@admin.com";
        $admin->name = "Super Admin";
        $admin->password = Hash::make('admin123');
        $admin->save();
    }
}
