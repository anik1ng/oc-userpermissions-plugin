<?php namespace ANIKIN\UserPermissions\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;

/**
 * Migration AddPermissionsToUserGroups
 *
 * @package VETRINA\Warehouse
 * @author Constantine Anikin, mail@anikin.pro, https://anikin.pro
 */
return new class extends \October\Rain\Database\Updates\Migration
{
    const TABLE = 'user_groups';
    const COLUMN = 'permissions';

    public function up(): void
    {
        if ( ! Schema::hasColumn(self::TABLE, self::COLUMN)) {
            Schema::table(self::TABLE, function(Blueprint $table) {
                $table->text(self::COLUMN)->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn(self::TABLE, self::COLUMN)) {
            Schema::table(self::TABLE, function(Blueprint $table) {
                $table->dropColumn(self::COLUMN);
            });
        }
    }
};
