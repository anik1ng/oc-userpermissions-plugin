<?php namespace ANIKIN\UserPermissions\FormWidgets;

use ANIKIN\UserPermissions\Classes\Permission;

/**
 * PermissionEditor
 *
 * @package ANIKIN\UserPermissions
 * @author Constantine Anikin
 */
class PermissionEditor extends \Backend\FormWidgets\PermissionEditor
{
    /**
     * @var string Mode to display the permission editor with. Available options: radio, checkbox, switch
     */
    public $mode = 'checkbox';

    public function init(): void
    {
        $this->fillFromConfig([
            'mode',
        ]);
    }

    protected function getFilteredPermissions(): array
    {
        return Permission::getPermissionsForWidget();
    }

    protected function loadAssets()
    {
        $this->addCss('/modules/backend/formwidgets/permissioneditor/assets/css/permissioneditor.css');
        $this->addJs('/modules/backend/formwidgets/permissioneditor/assets/js/permissioneditor.js');
    }

    public function getSaveValue($value): array|string
    {
        if ( ! is_array($value)) {
            return [];
        }

        if ($this->mode === 'radio') {
            return $value;
        }

        $filteredPermissions = [];
        foreach ($value as $permission => $val) {
            $intVal = (int)$val;

            if ($intVal === 1 || ($this->mode === 'switch' && $intVal === -1)) {
                $filteredPermissions[$permission] = $intVal;
            }
        }
        return $filteredPermissions;
    }
}
