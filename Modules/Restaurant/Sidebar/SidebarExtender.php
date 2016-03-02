<?php namespace Modules\Restaurant\Sidebar;

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
            $group->item(trans('Restaurant Management'), function (Item $item) {
                $item->icon('fa fa-tags');
                $item->weight(1);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('restaurant::restaurants.title.restaurants'), function (Item $item) {
					$item->icon('fa fa-tag');
					$item->weight(0);
					$item->append('admin.restaurant.restaurant.create');
					$item->route('admin.restaurant.restaurant.index');
					$item->authorize(
						$this->auth->hasAccess('restaurant.restaurants.index')
						 /* append */
					);
                });
// append

            });
        });

        return $menu;
    }
}
