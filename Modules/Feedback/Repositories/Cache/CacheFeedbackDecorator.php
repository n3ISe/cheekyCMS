<?php namespace Modules\Feedback\Repositories\Cache;

use Modules\Feedback\Repositories\FeedbackRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFeedbackDecorator extends BaseCacheDecorator implements FeedbackRepository
{
    public function __construct(FeedbackRepository $feedback)
    {
        parent::__construct();
        $this->entityName = 'feedback.feedbacks';
        $this->repository = $feedback;
    }
}
