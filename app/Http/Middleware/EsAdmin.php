<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de Control de Acceso Administrativo
 * 
 * Verifica que el usuario autenticado tenga rol de administrador (rol = 1)
 * antes de permitir el acceso a rutas protegidas del panel administrativo.
 * 
 * Si el usuario no es administrador, se devuelve un error 403 (Forbidden).
 */
class EsAdmin
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar que el usuario esté autenticado y tenga rol de administrador
        if (auth()->check() && (auth()->user()->rol === 1 || auth()->user()->es_admin)) {
            return $next($request);
        }
        
        // Denegar acceso si no es administrador
        abort(403, 'Acceso denegado. Se requieren permisos de administrador.');
    }
}
