<?php

use Laravel\Fortify\Features;

return [
    'guard' => 'web',
    
    // Esta es la línea que soluciona tu problema de login
    'username' => 'email', 

    'home' => '/dashboard', 

    'middleware' => ['web'],

    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        Features::twoFactorAuthentication([
            'confirmPassword' => true,
        ]),
    ],

];