<?php

namespace models;

use models\base\SQL;

class Admin extends SQL
{
    public function __construct()
    {
        parent::__construct('administrateur', 'idadministrateur');
    }

    public function loginAdmin(string $email, string $password): mixed
    {
        $stmt = $this->pdo->prepare('SELECT * FROM administrateur WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $admin = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($admin)
        {
            if (password_verify($password, $admin['motpasse'])) {
                return $admin;
            } else {
                return null;
            }
        }
        else {
            return null;
        }
        
    }



}