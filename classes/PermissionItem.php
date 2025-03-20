<?php namespace ANIKIN\UserPermissions\Classes;

/**
 * Permission Item
 *
 * Represents a single permission item for use in the PermissionEditor widget.
 *
 * @package ANIKIN\UserPermissions\Models
 * @author Constantine Anikin
 */
class PermissionItem
{
    public string $code;
    public string $label;
    public string $tab;
    public ?string $comment;
    public int $order;
    public array $children = [];

    /**
     * Add a child permission to this permission
     *
     * @param PermissionItem $child Child permission to add
     * @return void
     */
    public function addChild(self $child): void
    {
        $this->children[] = $child;
    }
}
