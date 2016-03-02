<?php namespace Modules\ApiUser\Repositories\Cache;

use Modules\ApiUser\Repositories\ApiUserRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheApiUserDecorator extends BaseCacheDecorator implements ApiUserRepository
{
    public function __construct(ApiUserRepository $apiuser)
    {
        parent::__construct();
        $this->entityName = 'apiuser.apiusers';
        $this->repository = $apiuser;
    }
}
