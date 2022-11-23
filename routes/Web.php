<?php

namespace routes;

use controllers\Account;
use controllers\Equipe;
use controllers\Formation;
use controllers\Hackathon;
use controllers\Admin;
use controllers\Main;
use controllers\ApiDoc;
use routes\base\Route;
use utils\SessionHelpers;

class Web
{
    function __construct()
    {
        $main = new Main();
        $hackathon = new Hackathon();
        $equipe = new Equipe();
        $apiDoc = new ApiDoc();
        $admin = new Admin();

        Route::Add('/', [$main, 'home']);
        Route::Add('/about', [$main, 'about']);

        Route::Add('/login', [$equipe, 'login']);
        Route::Add('/loginAdmin', [$admin, 'loginAdmin']);
        Route::Add('/create-team', [$equipe, 'create']);
        Route::Add('/membre',[$equipe, 'getMembre']);
        Route::Add('/calendar', [$main, 'calendar']);
        Route::Add('/atelier/{id}', [$main, 'calendarEvent']);

       

        if (SessionHelpers::isLogin()) {
            // Ici seront les routes nécessitant un accès protégés
            Route::Add('/logout', [$equipe, 'logout']);
            Route::Add('/me', [$equipe, 'me']);
            Route::Add('/membre/add', [$equipe, 'addMembre']);
            Route::Add('/membre/delete/{id}',[$equipe,'deleteMember']);
            Route::Add('/membre/leave', [$hackathon, 'leave']);
            Route::Add('/join', [$hackathon, 'join']);
            Route::Add('/updatePassword',[$equipe, 'setPassword']);
            Route::Add('/updateNomEquipe',[$equipe, 'setNomEquipe']);
            Route::Add('/updateLoginEquipe', [$equipe, 'setLogin']);
            Route::Add('/updatePrototype', [$equipe, 'setPrototype']);
        }

        if (SessionHelpers::isLoginAdmin())
        {
             // Liste des routes de la partie API
            Route::Add('/sample/', [$apiDoc, 'liste']);
            Route::Add('/sample/hackathons', [$apiDoc, 'listeHackathons']);
            Route::Add('/sample/ateliers', [$apiDoc, 'listeAteliers']);
            Route::Add('/sample/membres', [$apiDoc, 'listeMembres']);
            Route::Add('/sample/equipes', [$apiDoc, 'listeEquipes']);
            Route::Add('/logoutAdmin', [$admin, 'logoutAdmin']);
            Route::Add('loginAdmin', [$admin, 'loginAdmin']);
            
        }
    }
}

