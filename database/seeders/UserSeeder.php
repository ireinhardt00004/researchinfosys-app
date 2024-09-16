<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'lname' => 'Aromin',
            'middlename' => null,
            'fname' => 'Erick Stephen',
            'roles' => 'admin',
            'courseID' => 'N/A',
            'sex' => 'N/A',
            'email' => 'admin@cvsu.edu.ph',
            'verified' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('789456123'), 
        ]);

        User::create([
            'lname' => 'Doe',
            'middlename' => 'A',
            'fname' => 'John',
            'roles' => 'sub-admin',
            'courseID' => 'BSHM',
            'sex' => 'Female',
            'verified' => false,
            'email' => 'xxx@cvsu.edu.ph',
            'email_verified_at' => now(),
            'password' => Hash::make('789456123'), 
        ]);

        User::create([
            'studnum' => '2012-100-069',
            'lname' => 'Brown',
            'middlename' => 'C',
            'fname' => 'Charlie',
            'roles' => 'user',
            'courseID' => 'BSBA',
            'sex' => 'Male',
            'verified' => false,
            'email' => 'sample@cvsu.edu.ph',
            'email_verified_at' => now(),
            'password' => Hash::make('789456123'), 
        ]);
    }
}
