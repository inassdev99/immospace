<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'admin@immospace.test';
        $password = Str::random(20);

        $user = User::firstOrNew([
            'email' => $email,
        ]);

        $user->forceFill([
            'name' => 'Inass Silbi',
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => true,
        ])->save();

        $this->command->info('Compte administrateur prêt.');
        $this->command->line('Email : '.$email);
        $this->command->line('Mot de passe : '.$password);
        $this->command->warn(
            'Conservez ce mot de passe. Relancer ce seeder le remplacera.'
        );
    }
}