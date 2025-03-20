<?php namespace ANIKIN\UserPermissions\Classes;

/**
 * BackendFormEventsHandler
 *
 * @package ANIKIN\UserPermissions
 * @author Constantine Anikin
 */
class BackendFormEventsHandler
{
    public function subscribe(): void
    {
        \Event::listen('backend.form.extendFields', function($widget) {

            if ($widget->getController() instanceof \RainLab\User\Controllers\Users
                && $widget->model instanceof \RainLab\User\Models\User) {

                $widget->addTabFields([
                    'permissions' => [
                        'tab' => 'Permissions',
                        'label' => 'User Permissions',
                        'type' => 'ANIKIN\UserPermissions\FormWidgets\PermissionEditor',
                        'mode' => 'checkbox'
                    ]
                ]);
            }

            if ($widget->getController() instanceof \RainLab\User\Controllers\UserGroups
                && $widget->model instanceof \RainLab\User\Models\UserGroup) {

                if ($widget->model->code !== 'guest') {
                    $widget->addTabFields([
                        'permissions' => [
                            'tab' => 'Permissions',
                            'label' => 'Group Permissions',
                            'type' => 'ANIKIN\UserPermissions\FormWidgets\PermissionEditor',
                            'mode' => 'checkbox'
                        ]
                    ]);
                }
            }

        });
    }
}
