<?php namespace Modules\Review\Widgets;

use Modules\Review\Entities\Review;
use Modules\Review\Repositories\ReviewRepository;
use Modules\Dashboard\Foundation\Widgets\BaseWidget;

class ReviewWidget extends BaseWidget
{
    /**
     * @var \Modules\Blog\Repositories\PostRepository
     */
    private $review;

    public function __construct(ReviewRepository $review)
    {
        $this->review = $review;
    }

    /**
     * Get the widget name
     * @return string
     */
    protected function name()
    {
        return 'ReviewWidget';
    }

    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'review::admin.widgets.reviews';
    }

    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data()
    {
        return ['reviewCount' => Review::where('active','!=',2)->count()];
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
