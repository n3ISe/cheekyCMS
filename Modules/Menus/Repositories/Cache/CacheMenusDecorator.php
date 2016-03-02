<?php namespace Modules\Menus\Repositories\Cache;

use Modules\Menus\Repositories\MenusRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheMenusDecorator extends BaseCacheDecorator implements MenusRepository
{
    public function __construct(MenusRepository $menus)
    {
        parent::__construct();
        $this->entityName = 'menus.menuses';
        $this->repository = $menus;
    }
}
