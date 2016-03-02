<?php namespace Modules\Feedback\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Contracts\Authentication;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('feedback::feedbacks.title.feedbacks'), function (Item $item) {
				$item->icon('fa fa-envelope-o');
				$item->weight(100);
				//$item->append('admin.feedback.feedback.create');
				$item->route('admin.feedback.feedback.index');
				$item->authorize(
					$this->auth->hasAccess('feedback.feedbacks.index')
				);
			});
// append
        });

        return $menu;
    }
}
