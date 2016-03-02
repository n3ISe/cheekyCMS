<?php namespace Modules\ImageDimension\Sidebar;

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
            $group->item(trans('Image Management'), function (Item $item) {
                $item->icon('fa fa-picture-o');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('Image Dimensions'), function (Item $item) {
                    $item->icon('fa fa-bars');
                    $item->weight(0);
                    $item->append('admin.imagedimension.imagedimension.create');
                    $item->route('admin.imagedimension.imagedimension.index');
                    $item->authorize(
                        $this->auth->hasAccess('imagedimension.imagedimensions.index')
                    );
                });
// append

            });
        });

        return $menu;
    }
}
