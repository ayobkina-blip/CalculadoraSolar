<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    
    use HasFactory, Notifiable;

    


    // Declarar la tabla a usar
    protected $table = 'usuarios';

    //Declarar la PK de la tabla
    protected $primaryKey = 'id_usuario';


    //Para proteger la asignacion masiva de datos - Los siguientes datos son los unicos que se podran crear
    protected $fillable = [
        'nombre',
        'email',
        'contrasena_hash',
        'rol',
    ];

    //Las contraseñas o datos sensibles deben estar en hidden
    protected $hidden = [
        'contrasena_hash',
        'remember_token',
    ];

    
    // No se que hace esta parte
    protected function casts(): array
    {
        return [
            // No tienes esta columna, pero si la tuvieras, sería 'datetime'.
            // 'email_verified_at' => 'datetime', 
        ];
    }
    
    //Esto hace que laravel sepa que 'password' es 'contrasena_hash'
    public function getAuthPassword()
    {
        return $this->contrasena_hash;
    }
    // En app/Models/User.php

    public function resultados()
    {
        return $this->hasMany(\App\Models\Resultado::class, 'usuario_fr', 'id_usuario');
    }
}