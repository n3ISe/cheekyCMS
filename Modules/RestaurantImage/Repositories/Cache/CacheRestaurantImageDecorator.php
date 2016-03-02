<?php namespace Modules\RestaurantImage\Repositories\Cache;

use Modules\RestaurantImage\Repositories\RestaurantImageRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRestaurantImageDecorator extends BaseCacheDecorator implements RestaurantImageRepository
{
    public function __construct(RestaurantImageRepository $restaurantimage)
    {
        parent::__construct();
        $this->entityName = 'restaurantimage.restaurantimages';
        $this->repository = $restaurantimage;
    }
}
