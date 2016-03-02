<?php namespace Modules\ApiUser\Widgets;

use Modules\ApiUser\Entities\ApiUser;
use Modules\ApiUser\Repositories\ApiUserRepository;
use Modules\Dashboard\Foundation\Widgets\BaseWidget;

class ApiUserWidget extends BaseWidget
{
    /**
     * @var \Modules\Blog\Repositories\PostRepository
     */
    private $apiuser;

    public function __construct(ApiUserRepository $apiuser)
    {
        $this->apiuser = $apiuser;
    }

    /**
     * Get the widget name
     * @return string
     */
    protected function name()
    {
        return 'ApiUserWidget';
    }

    /**
     * Get the widget view
     * @return string
     */
    protected function view()
    {
        return 'apiuser::admin.widgets.apiusers';
    }

    /**
     * Get the widget data to send to the view
     * @return string
     */
    protected function data()
    {
        return ['apiUserCount' => $this->apiuser->all()->count()];
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
