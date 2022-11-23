<?php

namespace controllers;

use controllers\base\Api;
use models\Hackathon;
use utils\JsonHelpers;

class HackathonApi extends Api
{
    private Hackathon $hackatons;

    function __construct()
    {
        $this->hackatons = new Hackathon();
    }

    /**
     * Retourne l'ensemble des Hackathons
     * @return void
     */
    function getAll(): void
    {
        echo JsonHelpers::stringify($this->hackatons->getAll());
    }

    /**
     * Retourn le Hackathon actuellement actif.
     * @return void
     */
    function getActiveHackathon(): void
    {
        echo JsonHelpers::stringify($this->hackatons->getActive());
    }
}