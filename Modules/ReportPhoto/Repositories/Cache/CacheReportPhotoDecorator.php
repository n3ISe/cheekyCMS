<?php namespace Modules\ReportPhoto\Repositories\Cache;

use Modules\ReportPhoto\Repositories\ReportPhotoRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheReportPhotoDecorator extends BaseCacheDecorator implements ReportPhotoRepository
{
    public function __construct(ReportPhotoRepository $reportphoto)
    {
        parent::__construct();
        $this->entityName = 'reportphoto.reportphotos';
        $this->repository = $reportphoto;
    }
}
