<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'code' => SubscriptionPlan::CODE_FREE,
                'name' => 'Free',
                'price_cents' => 0,
                'currency' => 'EUR',
                'interval' => 'none',
                'simulation_limit' => 3,
                'features' => [],
                'is_active' => true,
            ],
            [
                'code' => SubscriptionPlan::CODE_PREMIUM_MONTHLY,
                'name' => 'Premium Mensual',
                'price_cents' => 999,
                'currency' => 'EUR',
                'interval' => 'month',
                'simulation_limit' => null,
                'features' => [
                    SubscriptionPlan::FEATURE_PDF_EXPORT,
                    SubscriptionPlan::FEATURE_ADVANCED_STATS,
                    SubscriptionPlan::FEATURE_RESULT_COMPARE,
                    SubscriptionPlan::FEATURE_CSV_EXPORT,
                ],
                'is_active' => true,
            ],
            [
                'code' => SubscriptionPlan::CODE_PREMIUM_YEARLY,
                'name' => 'Premium Anual',
                'price_cents' => 9900,
                'currency' => 'EUR',
                'interval' => 'year',
                'simulation_limit' => null,
                'features' => [
                    SubscriptionPlan::FEATURE_PDF_EXPORT,
                    SubscriptionPlan::FEATURE_ADVANCED_STATS,
                    SubscriptionPlan::FEATURE_RESULT_COMPARE,
                    SubscriptionPlan::FEATURE_CSV_EXPORT,
                ],
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::query()->updateOrCreate(
                ['code' => $plan['code']],
                $plan
            );
        }
    }
}
