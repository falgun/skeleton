<?php
namespace App\Templates\Site;

use Falgun\Pagination\PaginationInterface;
use Falgun\Template\AbstractTemplateHandler;

class TemplateHandler extends AbstractTemplateHandler
{

    public function boot()
    {
        
    }

    public function preRender()
    {
        $this->loadHead();
        $this->loadHeader();
    }

    public function postRender()
    {
        $this->loadFooter();
        $this->loadFoot();
    }

    public function loadHead()
    {
        require 'head.php';
    }

    public function loadHeader()
    {
        require 'header.php';
    }

    public function loadFoot()
    {
        require 'foot.php';
    }

    public function loadFooter()
    {
        require 'footer.php';
    }

    public function paginate()
    {
        $bag = $this->pagination->make();

        //dump($bag);

        echo '<ul class="pagination">';
        echo '<li class="' . ($bag->firstPage->isValid() ? '' : 'disabled' ) . '"><a href="' . $bag->firstPage->link . '" class="btn" >First</a></li>';
        echo '<li class="' . ($bag->prePage->isValid() ? '' : 'disabled' ) . '"><a href="' . $bag->prePage->link . '" class="btn" >Previous</a></li>';

        foreach ($bag->links as $link) {
            echo '<li class="' . ($link->current ? 'active' : '' ) . '"><a href="' . $link->link . '" class="btn" >' . $link->title . '</a></li>';
        }

        echo '<li class="' . ($bag->nextPage->isValid() ? '' : 'disabled' ) . '"><a href="' . $bag->nextPage->link . '" class="btn" >Next</a></li>';
        echo '<li class="' . ($bag->lastPage->isValid() ? '' : 'disabled' ) . '"><a href="' . $bag->lastPage->link . '" class="btn" >Last</a></li>';

        echo '</ul>';
    }
}
