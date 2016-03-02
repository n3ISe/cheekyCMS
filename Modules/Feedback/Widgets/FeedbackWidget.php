<?php namespace Modules\Feedback\Widgets;

use Modules\Feedback\Entities\Feedback;
use Modules\Feedback\Repositories\FeedbackRepository;
use Modules\Dashboard\Foundation\Widgets\BaseWidget;

class FeedbackWidget extends BaseWidget
{
    /**
     * @var \Modules\Blog\Repositories\PostRepository
     */
    private $feedback;

    public function __construct(FeedbackRepository $feedback)
    {
        $this->feedback = $feedback;
    }

    /**
     * Get the widget name
     * @return string
     */
    protected function name()
    {
        return 'FeedbackWidget';
    }

    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'feedback::admin.widgets.feedbacks';
    }

    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data()
    {
        return ['feedbackCount' => $this->feedback->all()->count()];
    }

     /**
     * Get the widget type
     * @return string
     */
    protected function options()
    {
        return [
            'width' => '3',
            'height' => '2',
            'x' => '0',
        ];
    }
}
