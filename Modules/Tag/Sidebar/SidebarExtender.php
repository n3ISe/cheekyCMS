<?php namespace Modules\Tag\Sidebar;

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
                $item->item(trans('tag::tags.title.tags'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(4);
                    $item->append('admin.tag.tag.create');
                    $item->route('admin.tag.tag.index');
                    $item->authorize(
                        $this->auth->hasAccess('tag.tags.index')
					);
                });
// append

            });
        });

        return $menu;
    }
}
