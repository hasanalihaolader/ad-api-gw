<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::create([
            'name' => 'Hasan Ali Haolader',
            'email' => 'rahibhasan689009@gmail.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
