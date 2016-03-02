<?php namespace Modules\CuisineType\Repositories\Cache;

use Modules\CuisineType\Repositories\CuisineTypeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCuisineTypeDecorator extends BaseCacheDecorator implements CuisineTypeRepository
{
    public function __construct(CuisineTypeRepository $cuisinetype)
    {
        parent::__construct();
        $this->entityName = 'cuisinetype.cuisinetypes';
        $this->repository = $cuisinetype;
    }
}
