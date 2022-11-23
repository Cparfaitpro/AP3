<?php

namespace models;

use models\base\SQL;

class Membre extends SQL
{
    public function __construct()
    {
        parent::__construct('MEMBRE', 'idmembre');
    }

    /**
     * Retourne les membres d'une équipe $idequipe
     * @param string $idequipe
     * @return bool|array
     */
    public function getByIdEquipe(string $idequipe): bool|array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM equipe e LEFT JOIN membre m on e.idequipe = m.idequipe WHERE m.idequipe = ?");
        $stmt->execute([$idequipe]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addToEquipe($nom, $prenom, $idE, $email, $telephone, $datenaissane, $lienportfolio)
    {
        $stmt = $this->pdo->prepare("INSERT INTO membre(nom, prenom, idequipe, email, telephone, datenaissance, lienportfolio) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$nom, $prenom, $idE, $email, $telephone, $datenaissane, $lienportfolio]);
    }

    public function DeleteMember($id,$idequipe)
    {
        $stmt = $this->pdo->prepare("DELETE FROM membre WHERE idmembre=? AND idequipe=?;");
        return $stmt->execute([$id, $idequipe]);
    }

    public function UpdateNumberParticipant($number, $idequipe)
    {
        $stmt = $this->pdo->prepare("UPDATE equipe SET nbparticipants=nbparticipants+? WHERE idequipe=?");
        return $stmt->execute([$number, $idequipe]);
    }
}