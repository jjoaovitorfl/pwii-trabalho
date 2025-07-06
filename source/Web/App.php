<?php

namespace Source\Web;

class App extends Controller
{
    public function __construct()
    {
        parent::__construct("app");
    }

    public function home(): void
    {
        echo $this->view->render("home", [
            "title" => "Início"
        ]);
    }

    public function feiras(): void
    {
        echo $this->view->render("feiras", [
            "title" => "Feiras"
        ]);
    }

    public function painelCliente(): void
    {
        echo $this->view->render("painel-cliente", [
            "title" => "Painel do Cliente"
        ]);
    }

    public function painelFeirante(): void
    {
        echo $this->view->render("painel-feirante", [
            "title" => "Painel do Feirante"
        ]);
    }
}
