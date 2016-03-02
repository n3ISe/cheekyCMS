<?php namespace Modules\User\Sidebar;

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
                $item->item(trans('CMS Users'), function (Item $item) {
					$item->weight(1);
					$item->icon('fa fa-user');
					$item->authorize(
						$this->auth->hasAccess('user.users.index') or $this->auth->hasAccess('user.roles.index')
					);

					$item->item(trans('user::users.title.users'), function (Item $item) {
						$item->weight(0);
						$item->icon('fa fa-user');
						$item->route('admin.user.user.index');
						$item->authorize(
							$this->auth->hasAccess('user.users.index')
						);
					});

					$item->item(trans('user::roles.title.roles'), function (Item $item) {
						$item->weight(1);
						$item->icon('fa fa-flag-o');
						$item->route('admin.user.role.index');
						$item->authorize(
							$this->auth->hasAccess('user.roles.index')
						);
					});
				});
// append

            });
        });

        return $menu;
    }
}
