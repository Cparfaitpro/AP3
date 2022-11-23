<?php

namespace models;

use models\base\SQL;

class Hackathon extends SQL
{
    public function __construct()
    {
        parent::__construct('hackathon', 'idhackathon');
    }

    /**
     * Retourne le Hackathon actuellement actif (en fonction de la date)
     * @return array|false
     */
    public function getActive(): bool|array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM hackathon WHERE dateheurefinh > NOW() ORDER BY dateheuredebuth LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getHackathonForTeamId(int $idE)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM hackathon LEFT JOIN inscrire I on hackathon.idhackathon = I.idhackathon WHERE I.idequipe = ? AND dateheurefinh > NOW() AND I.Date_desinscription IS NULL ORDER BY dateheuredebuth LIMIT 1");
        $stmt->execute([$idE]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function joinHackathon(string $idH, string $idE): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO inscrire (idhackathon,idequipe,dateinscription) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE dateinscription = NOW()");
        return $stmt->execute([intval($idH), intval($idE)]);
    }

    public function leaveHackathon(string $idH, string $idE)
    {
        $stmt = $this->pdo->prepare("UPDATE inscrire SET Date_desinscription=NOW() WHERE idhackathon=? AND idequipe=?;");
        return $stmt->execute([intval($idH), intval($idE)]);
    }

    public function getParticipantHackaton(string $idH)
    {
        $stmt = $this->pdo->prepare("SELECT date_fin_incrip,nb_equipe,(SELECT COUNT(*) FROM inscrire WHERE inscrire.idhackathon=? and inscrire.Date_desinscription IS NULL) AS 'NB_Equipe_Participant', NOW() AS temps FROM hackathon WHERE hackathon.idhackathon=?;");
        $stmt->execute([$idH,$idH]);
        $dispoHackaton=$stmt->fetch(\PDO::FETCH_ASSOC);
        if (floatval($dispoHackaton['NB_Equipe_Participant'])>=floatval($dispoHackaton['nb_equipe']) || $dispoHackaton['date_fin_incrip']>$dispoHackaton['temps'])
        {
            return false;
        }
        else
        {
            return true;
        }    
    }

    public function getDesinscriptionDate(string $idH, string $idE):bool
    {
        $stmt = $this->pdo->prepare("SELECT Date_desinscription FROM inscrire WHERE idhackathon=? AND idequipe=?;");
        $stmt->execute([intval($idH),intval($idE)]);
        $leaveHackathon=$stmt->fetch(\PDO::FETCH_ASSOC);
        if ($leaveHackathon)
        {
            if (is_null($leaveHackathon['Date_desinscription']))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else {
            return false;
        }
        
    }

    public function atelier()
    {
        $stmt= $this->pdo->prepare('SELECT id_atelier, nom_atelier, LEFT(datedebut,10) AS "datejourdebut", LEFT(datefin,10) AS "datejourfin", RIGHT(datedebut,8) AS "heuredebut", RIGHT(datefin,8) AS "heurefin", NbPlace  FROM atelier;');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }   

    public function conferencierByID(string $idA)
    {
        $stmt= $this->pdo->prepare('SELECT nom, prenom FROM conferencier INNER JOIN participer ON participer.id_conferencier=conferencier.id_conferencier WHERE participer.id_activite=?;');
        $stmt->execute([$idA]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function salleByID(string $idA)
    {
        $stmt= $this->pdo->prepare('SELECT nom_salle FROM salle INNER JOIN atelier ON atelier.id_salle=salle.id_salle WHERE atelier.id_atelier=?;');
        $stmt->execute([$idA]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function HackathonByID(string $idA)
    {
        $stmt= $this->pdo->prepare('SELECT thematique FROM hackathon INNER JOIN organise ON hackathon.idhackathon=organise.id_hack WHERE organise.id_atelier=?;');
        $stmt->execute([$idA]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function atelierByID(string $idA)
    {
        $stmt= $this->pdo->prepare('SELECT id_atelier, nom_atelier, LEFT(datedebut,10) AS "datejourdebut", LEFT(datefin,10) AS "datejourfin", RIGHT(datedebut,8) AS "heuredebut", RIGHT(datefin,8) AS "heurefin", NbPlace  FROM atelier WHERE id_atelier=?');
        $stmt->execute([$idA]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }  
}