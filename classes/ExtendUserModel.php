<?php namespace ANIKIN\UserPermissions\Classes;

use RainLab\User\Models\User;

/**
 * ExtendUserModel
 *
 * @package ANIKIN\UserPermissions
 * @author Constantine Anikin
 */
class ExtendUserModel
{
    public function subscribe(): void
    {
        User::extend(function($model) {
            $model->addJsonable('permissions');

            $model->addDynamicMethod('hasPermission', function($permission) use ($model) {
                return $this->checkUserPermission($model, $permission);
            });
        });
    }

    /**
     * checks if the given user model has the specified permission.
     *
     * verifies the user model's id, individual permissions, group permissions,
     * and primary group permissions to determine access rights.
     *
     * @param User $model the user model instance to check permissions for
     * @param string $permission the specific permission to verify
     * @return bool  true if the user has the required permission, otherwise false
     */
    protected function checkUserPermission(User $model, string $permission): bool
    {
        if ( ! $model->id) {
            return false;
        }

        if (is_array($model->permissions)
            && isset($model->permissions[$permission])
            && $model->permissions[$permission] == 1) {
            return true;
        }

        if ($model->groups) {
            foreach ($model->groups as $group) {
                if ($group->hasPermission($permission)) {
                    return true;
                }
            }
        }

        if ($model->primary_group && $model->primary_group->hasPermission($permission)) {
            return true;
        }

        return false;
    }
}
