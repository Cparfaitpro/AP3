<?php

namespace models;

use models\base\SQL;
use utils\TokenHelpers;

class Token extends SQL
{
    public function __construct()
    {
        parent::__construct('token', 'uuid');
    }

    /**
     * Retourne une équipe à partir de son token.
     * @param $token
     * @return mixed
     * @retur Equipe
     */
    public function getEquipeByToken($token)
    {
        $stmt = $this->pdo->prepare("SELECT e.* FROM token LEFT JOIN equipe e on e.idequipe = TOKEN.idequipe WHERE uuid = ?");
        $stmt->execute([$token]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Génère un nouveau token pour l'équipe $idequipe.
     * @param $idequipe
     * @return mixed|null
     * @throws \Exception
     */
    public function add($idequipe): mixed
    {
        $token = TokenHelpers::guidv4();
        $stmt = $this->pdo->prepare("INSERT INTO token VALUES (?, ?)");
        $result = $stmt->execute([$token, $idequipe]);

        if ($result) {
            return $this->getOne($token);
        } else {
            return null;
        }
    }
}