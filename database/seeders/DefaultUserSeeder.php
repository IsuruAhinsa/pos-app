<?php

namespace Database\Seeders;

use App\Enum\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@pos.com')->first();

        if ($user === null) {
            $user = User::create([
                'first_name' => 'Super Administrator',
                'email' => 'admin@pos.com',
                'password' => Hash::make('password'),
            ]);

            $user->assignRole(RoleEnum::Admin->value);

            $this->command->info('Here is your super administrator details to login:');
            $this->command->warn($user->email);
            $this->command->warn('Password is "password"');
        }
    }
}
