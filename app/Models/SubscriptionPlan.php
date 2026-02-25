<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    use HasFactory;

    public const CODE_FREE = 'free';
    public const CODE_PREMIUM_MONTHLY = 'premium_monthly';
    public const CODE_PREMIUM_YEARLY = 'premium_yearly';

    public const FEATURE_PDF_EXPORT = 'pdf_export';
    public const FEATURE_ADVANCED_STATS = 'advanced_stats';
    public const FEATURE_RESULT_COMPARE = 'result_compare';
    public const FEATURE_CSV_EXPORT = 'csv_export';

    protected $table = 'subscription_plans';

    protected $fillable = [
        'code',
        'name',
        'price_cents',
        'currency',
        'interval',
        'simulation_limit',
        'features',
        'is_active',
    ];

    protected $casts = [
        'price_cents' => 'integer',
        'simulation_limit' => 'integer',
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class, 'plan_fr', 'id');
    }

    public function hasFeature(string $feature): bool
    {
        return in_array($feature, $this->features ?? [], true);
    }
}
