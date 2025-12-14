<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // --- CONEXIÓN CON LA TABLA PERSONALIZADA ---
    
    /**
     * El nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * La clave primaria de la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_usuario';

    // --- MANTENER/AJUSTAR ATRIBUTOS ---

    /**
     * The attributes that are mass assignable (deben coincidir con tus columnas).
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',              // Mapea a la columna 'nombre'
        'correo_electronico',  // Mapea a la columna 'correo_electronico'
        'contrasena_hash',     // Mapea a la columna 'contrasena_hash'
        'rol',                 // Agregamos 'rol' si lo quieres crear masivamente
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'contrasena_hash',     // USAMOS 'contrasena_hash' en lugar de 'password'
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     * Mantenemos el casteo a 'datetime', pero quitamos el 'password' => 'hashed'
     * ya que lo manejaremos con getAuthPassword() y la columna no se llama 'password'.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // No tienes esta columna, pero si la tuvieras, sería 'datetime'.
            // 'email_verified_at' => 'datetime', 
        ];
    }
    
    // --- LÓGICA DE AUTENTICACIÓN ---

    /**
     * Indica a Laravel qué columna usar para la contraseña.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->contrasena_hash;
    }
}