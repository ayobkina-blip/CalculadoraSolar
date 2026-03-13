<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 2 admin users
        for ($i = 1; $i <= 2; $i++) {
            User::updateOrCreate(
                ['email' => "admin{$i}@solarcalc.com"],
                [
                    'nombre' => "Admin {$i}",
                    'contrasena_hash' => Hash::make('password'),
                    'rol' => 1,
                    'email_verified_at' => now(),
                ]
            );
        }

        // Create 10 normal users
        for ($i = 1; $i <= 10; $i++) {
            User::updateOrCreate(
                ['email' => "usuario{$i}@solarcalc.com"],
                [
                    'nombre' => "Usuario {$i}",
                    'contrasena_hash' => Hash::make('password'),
                    'rol' => 0,
                    'email_verified_at' => now(),
                ]
            );
        }

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

        // Plan mensual
        SubscriptionPlan::updateOrCreate(
            ['code' => 'premium_monthly'],
            [
                'name'             => 'Premium Mensual',
                'price_cents'      => 999,   // 9,99 €
                'currency'         => 'EUR',
                'interval'         => 'month',
                'simulation_limit' => null,  // ilimitado
                'features'         => ['pdf_export', 'advanced_stats', 'result_compare', 'csv_export'],
                'is_active'        => true,
            ]
        );

        // Plan anual
        SubscriptionPlan::updateOrCreate(
            ['code' => 'premium_yearly'],
            [
                'name'             => 'Premium Anual',
                'price_cents'      => 7999,  // 79,99 €
                'currency'         => 'EUR',
                'interval'         => 'year',
                'simulation_limit' => null,
                'features'         => ['pdf_export', 'advanced_stats', 'result_compare', 'csv_export'],
                'is_active'        => true,
            ]
        );

        // Assign free subscriptions to all normal users
        for ($i = 1; $i <= 10; $i++) {
            $usuario = User::where('email', "usuario{$i}@solarcalc.com")->first();
            
            if ($usuario) {
                UserSubscription::updateOrCreate(
                    ['usuario_fr' => $usuario->id_usuario, 'status' => 'active'],
                    [
                        'plan_fr' => $freePlan->id,
                        'starts_at' => now(),
                    ]
                );
            }
        }
    }
}
