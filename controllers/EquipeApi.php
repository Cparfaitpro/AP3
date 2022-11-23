<?php

namespace controllers;

use controllers\base\Api;
use models\Equipe;
use models\Token;
use utils\JsonHelpers;

class EquipeApi extends Api
{
    private Equipe $equipes;
    private Token $token;

    function __construct()
    {
        $this->equipes = new Equipe();
        $this->token = new Token();
    }

    /**
     * Retourne l'ensemble des équipes présentes en base de données.
     * @return void
     */
    function getAll(): void
    {
        echo JsonHelpers::stringify($this->equipes->getAll());
    }

    /**
     * Retourne l'ensemble des équipe pour un Hackathon précis.
     * @param $idh
     * @return void
     */
    function getEquipeByHackathon($idh): void
    {
        echo JsonHelpers::stringify($this->equipes->getForIdHackathon($idh));
    }

    /**
     * Génère un token permettant de retrouver une équipe en base de données.
     * Ce token est utilisé pour authentifié une équipe dans l'application cliente.
     * @param $login
     * @param $password
     * @return void
     */
    function auth($login = '', $password = ''): void
    {
        if (isset($login, $password)) {
            $token = $this->equipes->auth($login, $password);
            echo JsonHelpers::stringify(["success" => 1, "result" => $token]);
        } else {
            echo JsonHelpers::stringify(["success" => 0, "result" => null]);
        }
    }

    /**
     * Retourne une équipe en fonction du token passé en paramètres.
     * @param string $token
     * @return void
     */
    function getByToken(string $token = "")
    {
        echo JsonHelpers::stringify($this->token->getEquipeByToken($token));
    }

    /**
     * Création d'une nouvelle équipe.
     * Cette action est exposée via une API
     * Nécéssite la fourniture des paramètres :
     * - nomequipe
     * - lienprototype
     * - nbparticipants
     * - login
     * - password
     * @return void
     */
    function create(): void
    {
        if (isset($_POST['nomequipe'], $_POST['lienprototype'], $_POST['nbparticipants'], $_POST['login'], $_POST['password'])) {
            $result = $this->equipes->add($_POST['nomequipe'], $_POST['lienprototype'], $_POST['nbparticipants'], $_POST['login'], $_POST['password']);

            if ($result) {
                echo JsonHelpers::stringify(["success" => 1, "result" => $result]);
            } else {
                echo JsonHelpers::stringify(["success" => 0, "result" => null]);
            }
        } else {
            echo JsonHelpers::stringify(["success" => 0, "result" => null]);
        }
    }
}