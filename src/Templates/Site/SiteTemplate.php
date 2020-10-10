<?php
declare(strict_types=1);

namespace App\Templates\Site;

use Falgun\Http\Request;
use Falgun\Template\AbstractTemplate;
use Falgun\Notification\Notification;

class SiteTemplate extends AbstractTemplate
{

    protected $messages;
    protected Request $request;

    public function __construct(Request $request)
    {
        parent::__construct();

        //$this->messages = $notification->flashNotifications();
        $this->request = $request;
    }

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
        $bag = $this->page->getPagination()
            ->make();

        if ($this->page->getPagination()->getTotalPage() <= 1) {
            return;
        }

        require __DIR__ . '/pagination.php';
    }

    public function getPaginatedUri(int $page): string
    {
        $queries = $this->request->queryDatas()->all();
        $queries['page'] = $page;

        $uri = $this->request->uri()->getSchemeHostPathWithoutDefaultPort() .
            '?' . \http_build_query($queries);

        return $uri;
    }
}
