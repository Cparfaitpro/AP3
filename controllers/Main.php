<?php

namespace controllers;

use controllers\base\Web;
use models\Hackathon;
use models\Organisateur;
use utils\Template;

/**
 * Contrôleur principal
 */
class Main extends Web
{
    private Hackathon $hackathon;
    private Organisateur $organisateur;

    public function __construct()
    {
        $this->hackathon = new Hackathon();
        $this->organisateur = new Organisateur();
    }

    function home()
    {
        $currentHackathon = $this->hackathon->getActive();
        $currentOrganisateur = $this->organisateur->getOne($currentHackathon['idorganisateur']);
        $verifAccepte = $this->hackathon->getParticipantHackaton($currentHackathon['idhackathon']);
        Template::render("views/global/home.php", array("hackathon" => $currentHackathon, "organisateur" => $currentOrganisateur, "checkParticipation" => $verifAccepte));
    }

    function about()
    {
        Template::render("views/global/about.php", array());
    }

    function calendar()
    {
        if (!\utils\SessionHelpers::isLogin()) {
            $this->redirect("/login");
        }
        $calendrier = $this->hackathon->atelier();
        Template::render("views/global/calendar.php", array('calendrier' => $calendrier));
    }

    function calendarEvent($idA)
    {
        if (!\utils\SessionHelpers::isLogin()) {
            $this->redirect("/login");
        }
        if ($idA==="" || !$this->hackathon->conferencierByID($idA))
        {
            $this->redirect("/calendar");
        }
        $conferencier = $this->hackathon->conferencierByID($idA);
        $salle = $this->hackathon->salleByID($idA);
        $atelier = $this->hackathon->atelierByID($idA);
        $hackathonAtelier = $this->hackathon->HackathonByID($idA);

        Template::render("views/global/atelier.php", array('conferencier' => $conferencier, 'salle' => $salle, 'atelier' => $atelier, 'hackathonAtelier' => $hackathonAtelier));


    }
}