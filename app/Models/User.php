<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * CONEXIÓN A BASE DE DATOS
     * Definimos la tabla y la clave primaria personalizada para que Laravel
     * no busque por defecto 'users' e 'id'.
     */
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    /**
     * ASIGNACIÓN MASIVA
     * Define qué campos se pueden llenar usando User::create([...])
     */
    protected $fillable = [
        'nombre', 
        'email',
        'contrasena_hash',
        'avatar',
        'rol',
    ];

    /**
     * ATRIBUTOS OCULTOS
     * Estos campos no se incluirán cuando el modelo se convierta a Array o JSON
     * (por ejemplo, en una API), protegiendo datos sensibles.
     */
    protected $hidden = [
        'contrasena_hash',
        'remember_token',
    ];

    /**
     * CASTING DE ATRIBUTOS
     * Esta función (introducida en Laravel 11) transforma los datos al leerlos o escribirlos.
     * Por ejemplo, convierte un string '2023-01-01' en un objeto Carbon (Fecha) automáticamente.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'contrasena_hash' => 'hashed', // Laravel aplicará hashing automáticamente si es necesario
            'rol' => 'integer',
        ];
    }

    /**
     * SOBREESCRITURA DE PASSWORD
     * Como tu columna no se llama 'password', debemos decirle a Laravel 
     * dónde encontrar el hash de la contraseña para el login.
     */
    public function getAuthPassword()
    {
        return $this->contrasena_hash;
    }

    /**
     * ACCESORES (Getters)
     * Permite usar $user->es_admin para verificar permisos de forma limpia.
     */
    public function getEsAdminAttribute(): bool
    {
        return (int) $this->rol === 1;
    }

    /**
     * RELACIONES (ORM)
     * Un usuario tiene muchos resultados de cálculos fotovoltaicos.
     */
    public function resultados()
    {
        return $this->hasMany(Resultado::class, 'usuario_fr', 'id_usuario');
    }

    /**
     * Alias de resultados para mayor claridad en la lógica de negocio.
     */
    public function presupuestos()
    {
        return $this->resultados();
    }

    /**
     * Avatar
     */


    public function getAvatarUrl()
    {
        return $this->avatar 
            ? asset('storage/' . $this->avatar) 
            : "https://ui-avatars.com/api/?name=" . urlencode($this->nombre) . "&color=7F9CF5&background=EBF4FF";
    }
}