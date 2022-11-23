<?php

namespace controllers;

use controllers\base\Web;
use models\Membre;
use utils\SessionHelpers;
use utils\Template;

class Equipe extends Web
{
    private \models\Hackathon $hackathon;
    private Membre $membre;
    private \models\Equipe $equipe;

    public function __construct()
    {
        $this->hackathon = new \models\Hackathon();
        $this->membre = new Membre();
        $this->equipe = new \models\Equipe();
    }

    /**
     * Affichage du profil d'une équipe
     * @return void
     */
    function me($idh = ""): void
    {
        $connected = SessionHelpers::getConnected();
        $relatedHackathon = $this->hackathon->getHackathonForTeamId($connected['idequipe']);
        $membres = $this->membre->getByIdEquipe($connected['idequipe']);
        $activeHackathon=$this->hackathon->getActive();
        $desinscription=$this->hackathon->getDesinscriptionDate($activeHackathon['idhackathon'], $connected['idequipe']);

        Template::render("views/equipe/me.php", array('hackathon' => $relatedHackathon, 'connected' => $connected, "membres" => $membres, 'desinscription' => $desinscription));
    }

    /**
     * Méthode d'ajout d'un membre. Appelé depuis la vue de profil
     * @param $nom
     * @param $prenom
     * @return void
     */
    function addMembre($nom = "", $prenom = "", $mail= "", $telephone= "", $datenaissance= "", $portfolio= ""): void
    {
        if (!empty($nom) && !empty($prenom) && !empty($mail) && !empty($telephone) && !empty($datenaissance) && !empty($portfolio)) {
            $connected = SessionHelpers::getConnected();
            $this->membre->UpdateNumberParticipant(1, $connected['idequipe']);
            $this->membre->addToEquipe(htmlspecialchars($nom), htmlspecialchars($prenom), $connected['idequipe'], htmlspecialchars($mail), htmlspecialchars($telephone), htmlspecialchars($datenaissance), htmlspecialchars($portfolio));
        }

        $this->redirect('/me');
    }

    /**
     * Méthode de création d'une nouvelel équipe en base. Une équipe est forcément rattachée à un hackathon
     * @param $idh
     * @param $nom
     * @param $lien
     * @param $login
     * @param $password
     * @return void
     */
    function create($idh = "", $nom = "", $lien = "", $login = "", $password = ""): void
    {
        $verif=$this->hackathon->getParticipantHackaton($idh);
        if (!$idh OR !$verif) {
            $this->redirect("/");
        }

        $erreur = "";
        if (!empty($idh) && !empty($nom) && !empty($lien) && !empty($login) && !empty($password)) {
            // Création de l'équipe
            $equipe = $this->equipe->create($nom, $lien, $login, $password);

            if ($equipe != null) {
                // Ajout de l'équipe dans le hackathon demandé
                $this->hackathon->joinHackathon($idh, $equipe['idequipe']);
                SessionHelpers::login($equipe);
                $this->redirect('/me');
            } else {
                $erreur = "Création de votre équipe impossible";
            }

        }

        Template::render("views/equipe/create.php", array("idh" => $idh, "erreur" => $erreur));

    }

    /**
     * Méthode de connexion d'une équipe
     * @param $login
     * @param $password
     * @return void
     */
    function login($login = "", $password = ""): void
    {
        if (SessionHelpers::isLogin()) {
            $this->redirect("/");
        }

        $erreur = "";
        if (!empty($login) && !empty($password)) {
            $equipeController = new \models\Equipe();

            $lequipe = $equipeController->login($login, $password);
            if ($lequipe != null) {
                $_SESSION['equipe']=$lequipe['idequipe'];
                SessionHelpers::login($lequipe);
                $this->redirect("/me");
            } else {
                SessionHelpers::logout();
                $erreur = "Connexion impossible avec vos identifiants";
            }
        }

        Template::render("views/equipe/login.php", array("erreur" => $erreur));
    }

    function getMembre($idh): void
    {
        if (!SessionHelpers::isLogin()) {
            $this->redirect("/login");
        }

        $equipe=$this->equipe->getMembre($idh);
        Template::render("views/equipe/membre.php", array('equipes' => $equipe));
    }

    function setPassword()
    {
        if (!SessionHelpers::isLogin()) {
            $this->redirect("/login");
        }
        $this->equipe->setPassword(htmlspecialchars($_POST['mdp1']),$_SESSION['equipe']);
        SessionHelpers::logout();
        $this->redirect("/login");
    }

    function setLogin()
    {
        if (!SessionHelpers::isLogin()) {
            $this->redirect("/login");
        }
        $this->equipe->setLogin(htmlspecialchars($_POST['modifLogin']),$_SESSION['equipe']);
        SessionHelpers::logout();
        $this->redirect("/login");
    }

    function setPrototype()
    {
        if (!SessionHelpers::isLogin()) {
            $this->redirect("/login");
        }
        $this->equipe->setPrototype(htmlspecialchars($_POST['modifPrototype']),$_SESSION['equipe']);
        SessionHelpers::logout();
        $this->redirect("/login");
    }

    function setNomEquipe()
    {
        if (!SessionHelpers::isLogin()) {
            $this->redirect("/login");
        }
        $this->equipe->setNomEquipe(htmlspecialchars($_POST['nomEquipe']), $_SESSION['equipe']);
        SessionHelpers::logout();
        $this->redirect("/login");
    }

    function deleteMember($idmembre)
    {
        if (isset($_SESSION['equipe']))
        {
            $this->membre->UpdateNumberParticipant(-1, $_SESSION['equipe']);
            return $this->membre->DeleteMember($idmembre, $_SESSION['equipe']);
        }
        else {
            $this->redirect("/login");
        }
    }

    /**
     * Déconnexion de la plateforme
     * @return void
     */
    function logout(): void
    {
        SessionHelpers::logout();
        session_destroy();
        $this->redirect("/");
    }
}