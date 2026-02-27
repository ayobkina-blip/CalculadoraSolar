<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users
        User::updateOrCreate(
            ['email' => 'admin@solarcalc.com'],
            [
                'nombre' => 'Admin',
                'contrasena_hash' => 'password',
                'rol' => 1,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'usuario@solarcalc.com'],
            [
                'nombre' => 'Usuario Demo',
                'contrasena_hash' => 'password',
                'rol' => 0,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'premium@solarcalc.com'],
            [
                'nombre' => 'Premium Demo',
                'contrasena_hash' => 'password',
                'rol' => 0,
                'email_verified_at' => now(),
            ]
        );

        // Ensure free plan exists
        $freePlan = SubscriptionPlan::firstOrCreate(
            ['code' => 'free'],
            [
                'name'             => 'Gratuito',
                'price_cents'      => 0,
                'currency'         => 'EUR',
                'interval'         => 'none',
                'simulation_limit' => 3,
                'features'         => [],
                'is_active'        => true,
            ]
        );

        // Assign free subscriptions to demo users
        $usuarioDemo = User::where('email', 'usuario@solarcalc.com')->first();
        $premiumDemo = User::where('email', 'premium@solarcalc.com')->first();

        if ($usuarioDemo) {
            UserSubscription::updateOrCreate(
                ['usuario_fr' => $usuarioDemo->id_usuario, 'status' => 'active'],
                [
                    'plan_fr' => $freePlan->id,
                    'starts_at' => now(),
                ]
            );
        }

        if ($premiumDemo) {
            UserSubscription::updateOrCreate(
                ['usuario_fr' => $premiumDemo->id_usuario, 'status' => 'active'],
                [
                    'plan_fr' => $freePlan->id,
                    'starts_at' => now(),
                ]
            );
        }
    }
}
