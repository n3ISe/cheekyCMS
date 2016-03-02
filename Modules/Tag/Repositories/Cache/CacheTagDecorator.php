<?php namespace Modules\Tag\Repositories\Cache;

use Modules\Tag\Repositories\TagRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTagDecorator extends BaseCacheDecorator implements TagRepository
{
    public function __construct(TagRepository $tag)
    {
        parent::__construct();
        $this->entityName = 'tag.tags';
        $this->repository = $tag;
    }
}
