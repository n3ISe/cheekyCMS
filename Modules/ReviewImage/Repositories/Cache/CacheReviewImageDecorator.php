<?php namespace Modules\ReviewImage\Repositories\Cache;

use Modules\ReviewImage\Repositories\ReviewImageRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheReviewImageDecorator extends BaseCacheDecorator implements ReviewImageRepository
{
    public function __construct(ReviewImageRepository $reviewimage)
    {
        parent::__construct();
        $this->entityName = 'reviewimage.reviewimages';
        $this->repository = $reviewimage;
    }
}
