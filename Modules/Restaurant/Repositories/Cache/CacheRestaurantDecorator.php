<?php namespace Modules\Restaurant\Repositories\Cache;

use Modules\Restaurant\Repositories\RestaurantRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRestaurantDecorator extends BaseCacheDecorator implements RestaurantRepository
{
    public function __construct(RestaurantRepository $restaurant)
    {
        parent::__construct();
        $this->entityName = 'restaurant.restaurants';
        $this->repository = $restaurant;
    }
}
