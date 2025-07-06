<?php

namespace Source\Web;

class Admin extends Controller
{
    public function __construct()
    {
        parent::__construct("adm");
    }

    public function home(): void
    {
        echo $this->view->render("home", [
            "title" => "Painel Administrativo",
            "css" => "inicio-admin"
        ]);
    }

    public function painelAdmin(): void
    {
        echo $this->view->render("painel-admin", [
            "title" => "Painel Admin",
            "css" => "painel-admin",
            "js" => "painel-admin"
        ]);
    }
}