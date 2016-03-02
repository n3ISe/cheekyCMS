<?php namespace Modules\ReportReason\Repositories\Cache;

use Modules\ReportReason\Repositories\ReportReasonRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheReportReasonDecorator extends BaseCacheDecorator implements ReportReasonRepository
{
    public function __construct(ReportReasonRepository $reportreason)
    {
        parent::__construct();
        $this->entityName = 'reportreason.reportreasons';
        $this->repository = $reportreason;
    }
}
