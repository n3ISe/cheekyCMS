<?php namespace Modules\Restaurant\Widgets;

use Modules\Restaurant\Entities\Restaurant;
use Modules\Restaurant\Repositories\RestaurantRepository;
use Modules\Dashboard\Foundation\Widgets\BaseWidget;

class RestaurantWidget extends BaseWidget
{
    /**
     * @var \Modules\Blog\Repositories\PostRepository
     */
    private $restaurant;

    public function __construct(RestaurantRepository $restaurant)
    {
        $this->restaurant = $restaurant;
    }

    /**
     * Get the widget name
     * @return string
     */
    protected function name()
    {
        return 'RestaurantWidget';
    }

    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'restaurant::admin.widgets.restaurants';
    }

    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data()
    {
        return ['restaurantCount' => Restaurant::where('active','!=',2)->count()];
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
