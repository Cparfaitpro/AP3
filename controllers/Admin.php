<?php

namespace controllers;

use controllers\base\Web;
use utils\SessionHelpers;
use utils\JsonHelpers;
use utils\Template;

class Admin extends Web
{
    private \models\Admin $admin;

    public function __construct()
    {
        $this->admin = new \models\Admin();

    }
    function loginAdmin($login = "", $password = ""): void
    {
        if (SessionHelpers::isLoginAdmin()) {
            $this->redirect("/");
        }

        $erreur = "";
        if (!empty($login) && !empty($password)) {
            $adminController = new \models\Admin();
            $ladmin = $adminController->loginAdmin($login, $password);
            if ($ladmin != null) {
                $_SESSION['LOGINADMIN']=$ladmin['idequipe'];
                SessionHelpers::loginAdmin($ladmin);
                $this->redirect("/");
            } else {
                SessionHelpers::logoutAdmin();
                $erreur = "Connexion impossible avec vos identifiants";
            }
        }

        Template::render("views/Admin/loginAdmin.php", array("erreur" => $erreur));
    }

    function logoutAdmin(): void
    {
        SessionHelpers::logoutAdmin();
        session_destroy();
        $this->redirect("/");
    }
}