<?php

namespace controllers;

use controllers\base\Web;
use models\Equipe;
use models\Hackathon;
use models\Membre;
use utils\Template;

/**
 * Ensemble de méthode en lien avec l'API.
 */

class ApiDoc extends Web
{
    private Equipe $equipes;
    private Hackathon $hackatons;
    private Membre $membres;

    function __construct()
    {
        $this->equipes = new Equipe();
        $this->membres = new Membre();
        $this->hackatons = new Hackathon();
    }

    function liste()
    {
        Template::render("views/apidoc/liste.php");
    }

    function listeHackathons()
    {
        Template::render("views/apidoc/hackathon.php", array('data' => $this->hackatons->getAll()));
    }

    function listeMembres($idequipe = "")
    {
        $lequipe = null;
        if ($idequipe != "") {
            // Récupération de l'équipe passé en paramètre
            $lequipe = $this->equipes->getOne($idequipe);
            $data = $this->membres->getByIdEquipe($idequipe);
        } else {
            $data = $this->membres->getAll();
        }

        Template::render("views/apidoc/membre.php", array('data' => $data, 'lequipe' => $lequipe));
    }

    function listeEquipes($idh = "")
    {
        $hackathon = null;
        if ($idh != "") {
            // Récupération de l'équipe passé en paramètre
            $hackathon = $this->hackatons->getOne($idh);
            $data = $this->equipes->getForIdHackathon($idh);
        } else {
            $data = $this->equipes->getAll();
        }

        Template::render("views/apidoc/equipe.php", array('data' => $data, 'hackathon' => $hackathon));
    }
}
