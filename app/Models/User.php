<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre',
        'name',
        'email',
        'contrasena_hash',
        'password',
        'avatar',
        'rol',
    ];

    protected $hidden = [
        'contrasena_hash',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'contrasena_hash' => 'hashed',
            'rol' => 'integer',
        ];
    }

    public function getAuthPassword(): string
    {
        return $this->contrasena_hash;
    }

    public function getIdAttribute(): int
    {
        return (int) $this->id_usuario;
    }

    public function getNameAttribute(): string
    {
        return (string) $this->nombre;
    }

    public function setNameAttribute(string $value): void
    {
        $this->attributes['nombre'] = $value;
    }

    public function getPasswordAttribute(): string
    {
        return (string) $this->contrasena_hash;
    }

    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['contrasena_hash'] = $value;
    }

    public function getEsAdminAttribute(): bool
    {
        return (int) $this->rol === 1;
    }

    public function isAdminBypass(): bool
    {
        return (int) $this->rol === 1 || $this->es_admin;
    }

    public function resultados(): HasMany
    {
        return $this->hasMany(Resultado::class, 'usuario_fr', 'id_usuario');
    }

    public function presupuestos(): HasMany
    {
        return $this->resultados();
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class, 'usuario_fr', 'id_usuario');
    }

    public function activeSubscription(): HasOne
    {
        return $this->hasOne(UserSubscription::class, 'usuario_fr', 'id_usuario')
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            })
            ->latest('starts_at');
    }

    public function getAvatarUrl(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->nombre) . '&color=7F9CF5&background=EBF4FF';
    }
}
