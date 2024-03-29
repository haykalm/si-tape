<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

use App\Models\user;
use App\Models\Roleuser;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// create user table
        User::create([
            'name' => 'Haykal',
            'email' => 'haykal@gmail.com',
            'phone' => '083806605069',
            'address' => 'Babelan - Bekasi',
            'password' =>  Hash::make('password'),
            'role_id' => 1
        ]);
        User::create([
            'name' => 'Ian',
            'email' => 'ian@gmail.com',
            'phone' => '085806605068',
            'address' => 'medan satria - Bekasi',
            'password' =>  Hash::make('password'),
            'role_id' => 1
        ]);
        User::create([
            'name' => 'ponco',
            'email' => 'ponco@gmail.com',
            'phone' => '081806605064',
            'address' => 'bekasi utara - Bekasi',
            'password' =>  Hash::make('password'),
            'role_id' => 2
        ]);
        User::create([
            'name' => 'ahmad',
            'email' => 'ahmad@gmail.com',
            'phone' => '088806605063',
            'address' => 'bekasi timur - Bekasi',
            'password' =>  Hash::make('password'),
            'role_id' => 2
        ]);

        // create role user table
        Roleuser::create([
            'name' => 'super admin'
        ]);
        Roleuser::create([
            'name' => 'admin'
        ]);

    }
}
