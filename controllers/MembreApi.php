<?php

namespace controllers;

use controllers\base\Api;
use models\Membre;
use utils\JsonHelpers;

class MembreApi extends Api
{
    private Membre $membres;

    function __construct()
    {
        $this->membres = new Membre();
    }

    /**
     * Retourne l'ensemble des membres présents en base de données
     * @return void
     */
    function getAll(): void
    {
        echo JsonHelpers::stringify($this->membres->getAll());
    }

    /**
     * Retourne les membres d'une équipe précise
     * @param $idequipe
     * @return void
     */
    function getByEquipeId($idequipe = ""): void
    {
        echo JsonHelpers::stringify($this->membres->getByIdEquipe($idequipe));
    }
}