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
        // 1. CREAR 2 ADMINISTRADORES
        for ($i = 1; $i <= 2; $i++) {
            \App\Models\User::create([
                'nombre'   => "Admin {$i}",
                'email'    => "admin{$i}@solarcalc.com",
                'contrasena_hash' => \Illuminate\Support\Facades\Hash::make('password'),
                'rol'      => 1,
                'avatar'   => null,
            ]);
        }

        // 2. CREAR 10 USUARIOS NORMALES
        for ($i = 1; $i <= 10; $i++) {
            \App\Models\User::create([
                'nombre'   => "Usuario {$i}",
                'email'    => "usuario{$i}@solarcalc.com",
                'contrasena_hash' => \Illuminate\Support\Facades\Hash::make('password'),
                'rol'      => 0,
                'avatar'   => null,
            ]);
        }
    }
}