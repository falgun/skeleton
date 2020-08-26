<?php
declare(strict_types=1);

namespace App\Templates\Site;

use Falgun\Template\AbstractTemplate;
use Falgun\Notification\Notification;

class SiteTemplate extends AbstractTemplate
{

    protected $messages;

//    public function __construct(Notification $notification)
//    {
//        parent::__construct();
//
//        $this->messages = $notification->flashNotifications();
//    }

    public function preRender(): void
    {
        $this->loadHead();
    }

    public function postRender(): void
    {
        $this->loadFoot();
    }

    public function loadHead(): void
    {
        require __DIR__ . '/head.php';
    }

    public function loadFoot(): void
    {
        require __DIR__ . '/foot.php';
    }

    public function paginate()
    {
        $bag = $this->pagination->make();
        require __DIR__ . '/pagination.php';
    }
}
