<?php namespace Modules\Asset\Sidebar;

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
                $item->item(trans('asset::assets.title.assets'), function (Item $item) {
					$item->icon('fa fa-tags');
					$item->weight(3);
					$item->route('admin.asset.asset.index');
					$item->authorize(
						$this->auth->hasAccess('asset.assets.index')
						 /* append */
					);
                });
// append

            });
        });

        return $menu;
    }
}
