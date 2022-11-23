<?php

namespace routes;

use controllers\EquipeApi;
use controllers\HackathonApi;
use controllers\MembreApi;
use routes\base\Route;

class Api
{
    function __construct()
    {
        $hackathonApi = new HackathonApi();
        $equipeApi = new EquipeApi();
        $membreApi = new MembreApi();

        // Route relative aux API Hackathon
        Route::Add('/api/hackathon/all', [$hackathonApi, 'getAll']);
        Route::Add('/api/hackathon/active', [$hackathonApi, 'getActiveHackathon']);
        Route::Add('/api/hackathon/{idh}/equipe', [$equipeApi, 'getEquipeByHackathon']);

        // Route relative aux API membre
        Route::Add('/api/membre/all', [$membreApi, 'getAll']);
        Route::Add('/api/membre/{idequipe}', [$membreApi, 'getByEquipeId']);

        // Route relative aux API équipe
        Route::Add('/api/equipe/all', [$equipeApi, 'getAll']);
        Route::Add('/api/equipe/create', [$equipeApi, 'create']);
        Route::Add('/api/equipe/auth', [$equipeApi, 'auth']);
        Route::Add('/api/equipe/{token}', [$equipeApi, 'getByToken']);
    }
}

