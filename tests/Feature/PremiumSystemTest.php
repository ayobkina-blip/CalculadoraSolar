<?php

namespace Tests\Feature;

use App\Models\Resultado;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserSubscription;
use Database\Seeders\SubscriptionPlanSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PremiumSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_free_user_is_blocked_after_three_simulations(): void
    {
        $this->seed(SubscriptionPlanSeeder::class);

        $user = User::factory()->create([
            'email_verified_at' => now(),
            'rol' => 0,
        ]);

        Resultado::factory()->count(3)->create([
            'usuario_fr' => $user->id_usuario,
        ]);

        $response = $this->actingAs($user)->post(route('solar.procesar'), [
            'consumo' => 350,
            'superficie' => 40,
            'orientacion' => 0,
            'inclinacion' => 30,
            'provincia' => 'Valencia',
            'latitud' => 39.4699,
            'longitud' => -0.3763,
        ]);

        $response->assertRedirect(route('premium.index', ['reason' => 'simulation_quota']));
        $response->assertSessionHas('error');
    }

    public function test_premium_user_can_create_more_than_three_simulations(): void
    {
        $this->seed(SubscriptionPlanSeeder::class);

        $user = User::factory()->create([
            'email_verified_at' => now(),
            'rol' => 0,
        ]);

        Resultado::factory()->count(3)->create([
            'usuario_fr' => $user->id_usuario,
        ]);

        $plan = SubscriptionPlan::query()->where('code', SubscriptionPlan::CODE_PREMIUM_MONTHLY)->firstOrFail();

        UserSubscription::query()->create([
            'usuario_fr' => $user->id_usuario,
            'plan_fr' => $plan->id,
            'status' => 'active',
            'starts_at' => now()->subDay(),
            'ends_at' => now()->addMonth(),
            'source' => 'manual_admin',
        ]);

        Http::fake([
            '*' => Http::response([
                'outputs' => [
                    'totals' => [
                        'fixed' => [
                            'E_y' => 1750,
                        ],
                    ],
                ],
            ], 200),
        ]);

        $response = $this->actingAs($user)->post(route('solar.procesar'), [
            'consumo' => 350,
            'superficie' => 40,
            'orientacion' => 0,
            'inclinacion' => 30,
            'provincia' => 'Valencia',
            'latitud' => 39.4699,
            'longitud' => -0.3763,
        ]);

        $this->assertEquals(4, Resultado::query()->where('usuario_fr', $user->id_usuario)->count());
        $created = Resultado::query()->where('usuario_fr', $user->id_usuario)->latest('id_resultado')->firstOrFail();
        $response->assertRedirect(route('solar.resultados', $created->id_resultado));
    }

    public function test_free_user_cannot_download_pdf(): void
    {
        $this->seed(SubscriptionPlanSeeder::class);

        $user = User::factory()->create([
            'email_verified_at' => now(),
            'rol' => 0,
        ]);

        $resultado = Resultado::factory()->create([
            'usuario_fr' => $user->id_usuario,
        ]);

        $response = $this->actingAs($user)->get(route('solar.pdf', $resultado->id_resultado));

        $response->assertRedirect(route('premium.index', ['reason' => 'pdf_export']));
    }

    public function test_admin_bypass_can_download_pdf_without_subscription(): void
    {
        $this->seed(SubscriptionPlanSeeder::class);

        $admin = User::factory()->create([
            'email_verified_at' => now(),
            'rol' => 1,
        ]);

        $resultado = Resultado::factory()->create([
            'usuario_fr' => $admin->id_usuario,
        ]);

        $response = $this->actingAs($admin)->get(route('solar.pdf', $resultado->id_resultado));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_free_user_sees_statistics_teaser(): void
    {
        $this->seed(SubscriptionPlanSeeder::class);

        $user = User::factory()->create([
            'email_verified_at' => now(),
            'rol' => 0,
        ]);

        $response = $this->actingAs($user)->get(route('solar.estadisticas'));

        $response->assertOk();
        $response->assertSee('Vista previa bloqueada para cuentas Free');
    }
}
