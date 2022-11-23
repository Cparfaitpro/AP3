<?php

namespace models;

use models\base\SQL;

class Equipe extends SQL
{
    public function __construct()
    {
        parent::__construct('EQUIPE', 'idequipe');
    }

    /**
     * Retourne les équipes ainsi que leur nombre de participations à un événement.
     * @return bool|array
     */
    function getAllWithParticipationCount(): bool|array
    {
        $stmt = $this->pdo->prepare("SELECT e.* FROM equipe e LEFT JOIN inscrire i on e.idequipe = i.idequipe");
        $stmt->execute([]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Créer un une équipe en base de données.
     * @param string $nomequipe
     * @param string $lienprototype
     * @param string $nbparticipants
     * @param string $login
     * @param string $password
     * @return mixed|null
     */
    public function add(string $nomequipe, string $lienprototype, string $nbparticipants, string $login, string $password): mixed
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO equipe VALUES(null, ?, ?, ?, ?, ?)");
            $result = $stmt->execute([$nomequipe, $lienprototype, $nbparticipants, $login, password_hash($password, PASSWORD_BCRYPT)]);
            if ($result) {
                return self::getOne($this->pdo->lastInsertId());
            } else {
                return null;
            }
        } catch (\Exception $exception) {
            return null;
        }
    }
    /**
     * Authentifie une équipe en fonction de son login et mot de passe.
     * @param string $login
     * @param string $password
     * @return mixed|null
     */
    public function auth(string $login, string $password): mixed
    {
        $stmt = $this->pdo->prepare('SELECT * FROM equipe WHERE login = ? LIMIT 1');
        $stmt->execute([$login]);
        $equipe = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (password_verify($password, $equipe['password'])) {
            $token = new Token();
            return $token->add($equipe['idequipe']);
        } else {
            return null;
        }

    }

    public function login(string $login, string $password): mixed
    {
        $stmt = $this->pdo->prepare('SELECT * FROM equipe WHERE login = ? LIMIT 1');
        $stmt->execute([$login]);
        $equipe = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (password_verify($password, $equipe['password'])) {
            return $equipe;
        } else {
            return null;
        }
    }

    public function getMembre($idh): bool | array
    {
        $stmt =$this->pdo->prepare('SELECT nom,prenom,nomequipe FROM membre INNER JOIN equipe ON membre.idequipe=equipe.idequipe WHERE equipe.idequipe=?');
        $stmt->execute([$idh]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Retourne les équipes pour un hackathon précis.
     * @param $idh
     * @return bool|array
     */
    public
    function getForIdHackathon($idh): bool|array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM equipe e LEFT JOIN inscrire i on e.idequipe = i.idequipe WHERE i.idhackathon = ? AND i.Date_desinscription IS NULL');
        $stmt->execute([$idh]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create(mixed $nom, mixed $lien, mixed $login, mixed $password)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO equipe VALUES(null, ?, ?, 0, ?, ?)");
            $result = $stmt->execute([$nom, $lien, $login, password_hash($password, PASSWORD_BCRYPT)]);

            if ($result) {
                return $this->getOne($this->pdo->lastInsertId());
            } else {
                return null;
            }
        } catch (\Exception $exception) {
            return null;
        }
    }

    public function setPassword(string $mdp1, string $idequipe)
    {
        $stmt = $this->pdo->prepare("UPDATE equipe SET password=? WHERE idequipe = ?");
        $stmt->execute([password_hash($mdp1, PASSWORD_BCRYPT),$idequipe]);
    }

    public function setNomEquipe(string $nomEquipe, string $idequipe)
    {
        $stmt = $this->pdo->prepare("UPDATE equipe SET nomequipe=? WHERE idequipe = ?");
        $stmt->execute([$nomEquipe,$idequipe]);
    }

    public function setLogin(string $login, string $idequipe)
    {
        $stmt = $this->pdo->prepare("UPDATE equipe SET login=? WHERE idequipe = ?");
        $stmt->execute([$login,$idequipe]);
    }

    public function setPrototype(string $prototype, string $idequipe)
    {
        $stmt = $this->pdo->prepare("UPDATE equipe SET lienprototype=? WHERE idequipe = ?");
        $stmt->execute([$prototype,$idequipe]);
    }


}
