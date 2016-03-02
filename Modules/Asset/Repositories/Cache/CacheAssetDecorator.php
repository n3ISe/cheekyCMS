<?php namespace Modules\Asset\Repositories\Cache;

use Modules\Asset\Repositories\AssetRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAssetDecorator extends BaseCacheDecorator implements AssetRepository
{
    public function __construct(AssetRepository $asset)
    {
        parent::__construct();
        $this->entityName = 'asset.assets';
        $this->repository = $asset;
    }
}
