<?php namespace ANIKIN\UserPermissions;

use Event;

/**
 * Plugin ANIKIN.UserPermissions
 *
 * @package ANIKIN\UserPermissions
 * @author Constantine Anikin
 */
class Plugin extends \System\Classes\PluginBase
{
    public $require = ['RainLab.User'];

    public function pluginDetails(): array
    {
        return [
            'name' => 'User Permissions',
            'description' => 'Extends RainLab.User plugin with roles and permissions',
            'author' => 'Constantine Anikin',
            'icon' => 'icon-user-secret'
        ];
    }

    public function boot(): void
    {
        Event::subscribe(\ANIKIN\UserPermissions\Classes\ExtendUserGroupModel::class);
        Event::subscribe(\ANIKIN\UserPermissions\Classes\ExtendUserModel::class);
        Event::subscribe(\ANIKIN\UserPermissions\Classes\BackendFormEventsHandler::class);
    }

    public function registerComponents(): array
    {
        return [
            \ANIKIN\UserPermissions\Components\CheckPermission::class => 'checkPermission'
        ];
    }

    public function registerPermissions(): array
    {
        return [
            'anikin.userpermissions.manage_roles' => [
                'tab' => 'User Permissions',
                'label' => 'Manage user roles and permissions'
            ],
        ];
    }

    public function registerMarkupTags(): array
    {
        return [
            'functions' => [
                'hasPermission' => function ($permission) {
                    $user = \Auth::getUser();
                    return $user && $user->hasPermission($permission);
                },
            ]
        ];
    }
}
