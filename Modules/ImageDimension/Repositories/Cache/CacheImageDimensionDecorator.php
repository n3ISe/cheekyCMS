<?php namespace Modules\ImageDimension\Repositories\Cache;

use Modules\ImageDimension\Repositories\ImageDimensionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheImageDimensionDecorator extends BaseCacheDecorator implements ImageDimensionRepository
{
    public function __construct(ImageDimensionRepository $imagedimension)
    {
        parent::__construct();
        $this->entityName = 'imagedimension.imagedimensions';
        $this->repository = $imagedimension;
    }
}
