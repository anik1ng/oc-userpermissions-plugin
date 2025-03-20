<?php namespace ANIKIN\UserPermissions\Classes;

/**
 * Model Permission
 *
 * @package ANIKIN\UserPermissions
 * @author Constantine Anikin
 */
class Permission
{
    /**
     * returns a list of permissions organized by tabs,
     * including custom permissions from plugins
     */
    public static function listPermissions(): array
    {
        /**
         * @event anikin.userpermissions.listPermissions
         * provides an opportunity to register user permissions for the ANIKIN.UserPermissions plugin.
         * the event listener should return an array of permissions.
         *
         * Example usage:
         *
         *   \Event::listen('anikin.userpermissions.listPermissions', function () {
         *      return [
         *          [
         *               'code' => 'dashboard',
         *               'label' => 'Access Dashboard',
         *               'tab' => 'Frontend',
         *               'order' => 100,
         *          ],
         *          [
         *               'code' => 'dashboard.view_profile',
         *               'label' => 'View Profile',
         *               'tab' => 'Frontend',
         *               'order' => 200,
         *           ],
         *           [
         *               'code' => 'dashboard.manage_profile',
         *               'label' => 'Manage Profile',
         *               'tab' => 'Frontend',
         *               'order' => 300,
         *           ],
         *      ];
         *   });
         *
         * each permission requires:
         * - code: unique permission identifier (use dot notation for nesting)
         * - label: display name for the permission
         *
         * optional attributes:
         * - tab: category for grouping permissions (defaults to 'Other')
         * - order: display order within tab (defaults to 999)
         * - comment: additional information shown as tooltip
         */
        $listPermissions = \Event::fire('anikin.userpermissions.listPermissions');

        $result = [];

        if (is_array($listPermissions)) {
            foreach ($listPermissions as $permissions) {
                if ( ! is_array($permissions)) {
                    continue;
                }

                foreach ($permissions as $permission) {
                    if ( ! isset($permission['code']) || ! isset($permission['label'])) {
                        continue;
                    }

                    $tab = $permission['tab'] ?? 'Other';
                    $result[$tab][] = $permission;
                }
            }
        }

        return $result;
    }

    /**
     * Retrieves a list of permissions formatted for use in widgets.
     *
     * This method organizes permissions into an array of objects,
     * each containing details such as code, label, tab, comment, and order.
     */
    public static function getPermissionsForWidget(): array
    {
        $permissions = self::listPermissions();
        $result = [];

        foreach ($permissions as $tab => $tabPermissions) {
            foreach ($tabPermissions as $permission) {
                $permObj = (object)[
                    'code' => $permission['code'],
                    'label' => $permission['label'],
                    'tab' => $tab,
                    'comment' => $permission['comment'] ?? null,
                    'order' => $permission['order'] ?? 999,
                    'children' => []
                ];

                $permObj->addChild = function($child) use ($permObj) {
                    $permObj->children[] = $child;
                };

                $result[$permission['code']] = $permObj;
            }
        }

        return $result;
    }
}
