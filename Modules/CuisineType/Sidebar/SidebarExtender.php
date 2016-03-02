<?php namespace Modules\CuisineType\Sidebar;

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
                $item->item(trans('cuisinetype::cuisinetypes.title.cuisinetypes'), function (Item $item) {
					$item->icon('fa fa-paperclip');
					$item->weight(30);
					$item->append('admin.cuisinetype.cuisinetype.create');
					$item->route('admin.cuisinetype.cuisinetype.index');
					$item->authorize(
						$this->auth->hasAccess('cuisinetype.cuisinetypes.index')
					);
                });
// append

            });
        });

        return $menu;
    }
}
