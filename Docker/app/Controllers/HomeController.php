<?php

class HomeController{
    private $bdd;

    public function __construct($bdd){
        $this->bdd = $bdd;
    }

    public function index(){
        require __DIR__ . '/../Views/home.html';
    }
}