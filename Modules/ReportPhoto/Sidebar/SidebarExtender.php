<?php namespace Modules\ReportPhoto\Sidebar;

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
            $group->item(trans('Reported Management'), function (Item $item) {
                $item->icon('fa fa-exclamation-triangle');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('reportphoto::reportphotos.title.reportphotos'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->route('admin.reportphoto.reportphoto.index');
                    $item->authorize(
                        $this->auth->hasAccess('reportphoto.reportphotos.index')
                    );
                });
// append

            });
        });

        return $menu;
    }
}
