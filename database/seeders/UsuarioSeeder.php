<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. CREAR ADMINISTRADOR
        \App\Models\User::create([
            'nombre'   => 'Admin SolarCalc', // CAMBIADO: 'name' -> 'nombre'
            'email'    => 'admin@solarcalc.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin1234'),
            'rol'      => 1,
            'avatar'   => null,
        ]);

        // 2. CREAR USUARIO NORMAL
        \App\Models\User::create([
            'nombre'   => 'Usuario Demo', // CAMBIADO: 'name' -> 'nombre'
            'email'    => 'user@solarcalc.com',
            'password' => \Illuminate\Support\Facades\Hash::make('user1234'),
            'rol'      => 0,
            'avatar'   => null,
        ]);
    }
}