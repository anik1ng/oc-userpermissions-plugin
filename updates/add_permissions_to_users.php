<?php namespace ANIKIN\UserPermissions\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;


return new class extends \October\Rain\Database\Updates\Migration {
    const TABLE = 'users';
    const COLUMN = 'permissions';

    public function up(): void
    {
        if ( ! Schema::hasColumn(self::TABLE, self::COLUMN)) {
            Schema::table(self::TABLE, function(Blueprint $table) {
                $table->text(self::COLUMN)->nullable();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn(self::TABLE, self::COLUMN)) {
            Schema::table(self::TABLE, function(Blueprint $table) {
                $table->dropColumn(self::COLUMN);
            });
        }
    }
};
