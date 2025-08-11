<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Use raw SQL to avoid requiring doctrine/dbal for column change
        DB::statement('ALTER TABLE `events` MODIFY `article` MEDIUMTEXT NOT NULL');
        DB::statement('ALTER TABLE `events` MODIFY `zh_article` MEDIUMTEXT NULL');
    }

    public function down(): void
    {
        // Revert to TEXT (may truncate data if over limit)
        DB::statement('ALTER TABLE `events` MODIFY `article` TEXT NOT NULL');
        DB::statement('ALTER TABLE `events` MODIFY `zh_article` TEXT NULL');
    }
};


