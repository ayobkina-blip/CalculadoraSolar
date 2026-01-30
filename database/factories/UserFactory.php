<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Administrador
        $admin = new User();
        $admin->nombre = 'Admin SolarCalc';
        $admin->email = 'admin@solarcalc.com';
        $admin->contrasena_hash = Hash::make('admin1234');
        $admin->rol = 1;
        $admin->save();

        // Usuario Normal
        $user = new User();
        $user->nombre = 'Usuario Demo';
        $user->email = 'user@solarcalc.com';
        $user->contrasena_hash = Hash::make('user1234');
        $user->rol = 0;
        $user->save();
        
        $this->command->info('Protocolo de usuarios inyectado manualmente con éxito.');
    }
}
