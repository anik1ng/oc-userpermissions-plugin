<?php namespace ANIKIN\UserPermissions\Classes;

/**
 * PermissionChecker
 *
 * Centralized permission checking logic with hierarchy support
 *
 * @package ANIKIN\UserPermissions
 * @author Constantine Anikin, mail@anikin.pro, https://anikin.pro
 */
class PermissionChecker
{
    /**
     * checks if permission exists with hierarchy support.
     *
     * @param array|null $permissions Permissions array
     * @param string $permission Permission to check
     * @return bool
     */
    public static function hasPermission(?array $permissions, string $permission): bool
    {
        if ( ! is_array($permissions) || empty($permissions)) {
            return false;
        }

        if (!self::isValidPermissionCode($permission)) {
            return false;
        }

        if (isset($permissions[$permission]) && $permissions[$permission] === 1) {
            return true;
        }

        return self::hasParentPermission($permissions, $permission);
    }

    /**
     * checks parent permissions in hierarchy.
     *
     * @param array $permissions
     * @param string $permission
     * @return bool
     */
    protected static function hasParentPermission(array $permissions, string $permission): bool
    {
        $parts = explode('.', $permission);

        if (count($parts) <= 1) {
            return false;
        }

        array_pop($parts);

        while ( ! empty($parts)) {
            $parentPermission = implode('.', $parts);

            if (isset($permissions[$parentPermission]) && $permissions[$parentPermission] === 1) {
                return true;
            }

            array_pop($parts);
        }

        return false;
    }

    /**
     * validates a permission code format.
     *
     * @param string $permission
     * @return bool
     */
    protected static function isValidPermissionCode(string $permission): bool
    {
        return preg_match('/^[a-z0-9._-]+$/i', $permission) === 1;
    }
}
