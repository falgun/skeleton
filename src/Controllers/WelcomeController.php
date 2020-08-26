<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Templates\Site\SiteTemplate;

class WelcomeController
{

    protected SiteTemplate $template;

    public function __construct(SiteTemplate $template)
    {
        $this->template = $template;
    }

    public function index()
    {
        $name = 'Falgun';

        return $this->template->view('index')->with(compact('name'));
    }
}
