<?php namespace ANIKIN\UserPermissions\Components;

use Auth;
use ANIKIN\UserPermissions\Classes\Permission;

/**
 * Component CheckPermission
 *
 * This component checks if the currently logged-in user has a specific permission.
 * If the user does not have the required permission, they can be redirected to a specified page.
 *
 * @package ANIKIN\UserPermissions
 * @author Constantine Anikin
 */
class CheckPermission extends \Cms\Classes\ComponentBase
{
    public function componentDetails(): array
    {
        return [
            'name' => 'Check Permission',
            'description' => 'Checks if the current user has a specific permission'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'permission' => [
                'title' => 'Permission',
                'description' => 'The permission to check',
                'type' => 'dropdown',
                'default' => '',
                'required' => true
            ],
            'redirect' => [
                'title' => 'Redirect',
                'description' => 'Page to redirect if user does not have permission',
                'type' => 'dropdown',
                'default' => ''
            ]
        ];
    }

    public function getPermissionOptions(): array
    {
        $permissions = Permission::listPermissions();
        $options = [];

        foreach ($permissions as $tab => $tabPermissions) {
            foreach ($tabPermissions as $permission) {
                if (isset($permission['code']) && isset($permission['label'])) {
                    $options[$permission['code']] = $tab . ' - ' . $permission['label'];
                }
            }
        }

        return $options;
    }

    /**
     * Returns options for the redirect property.
     *
     * @return array List of pages that can be selected for redirection, with a default "none" option.
     */
    public function getRedirectOptions(): array
    {
        return ['' => '- none -'] + \Cms\Classes\Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    /**
     * Executes when the component runs on a page.
     *
     * Checks if the current user has the required permission. If not, it redirects the user
     * to a specified page or sets the `hasPermission` variable to false on the page.
     */
    public function onRun()
    {
        $permission = $this->property('permission');
        $redirect = $this->property('redirect');

        $user = Auth::getUser();

        if ( ! $user || ! $user->hasPermission($permission)) {
            if ($redirect) {
                return \Redirect::to($this->controller->pageUrl($redirect));
            }

            $this->page['hasPermission'] = false;

            return;
        }

        $this->page['hasPermission'] = true;
    }
}
