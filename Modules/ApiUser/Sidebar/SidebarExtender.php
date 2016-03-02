<?php namespace Modules\ApiUser\Sidebar;

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
			$group->hideHeading();
            $group->item(trans('User Management'), function (Item $item) {
                $item->icon('fa fa-users');
                $item->weight(1);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('API Users'), function (Item $item) {
					$item->icon('fa fa-user');
					$item->weight(2);
					$item->append('admin.apiuser.apiuser.create');
					$item->route('admin.apiuser.apiuser.index');
					$item->authorize(
						 $this->auth->hasAccess('apiuser.apiusers.index')
						 /* append */
					);
				});
// append

            });
        });

        return $menu;
    }
}
