<?php
namespace App\Controllers;

use Falgun\Controller\AbstractController;

class HomeController extends AbstractController
{

    public function index()
    {
        return $this->loadView('index', 'Site')->with();
    }
}