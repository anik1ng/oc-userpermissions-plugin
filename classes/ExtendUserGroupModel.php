<?php namespace ANIKIN\UserPermissions\Classes;

/**
 * ExtendUserGroupModel
 *
 * @package ANIKIN\UserPermissions
 * @author Constantine Anikin, mail@anikin.pro, https://anikin.pro
 */
class ExtendUserGroupModel
{
    public function subscribe(): void
    {
        \RainLab\User\Models\UserGroup::extend(function($model) {
            $model->addJsonable('permissions');

            $model->addDynamicMethod('hasPermission', function($permission) use ($model) {
                return PermissionChecker::hasPermission($model->permissions, $permission);
            });
        });
    }
}
