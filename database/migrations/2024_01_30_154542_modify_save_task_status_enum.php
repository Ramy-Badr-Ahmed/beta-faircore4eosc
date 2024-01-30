<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE software_heritage_requests
                            ADD COLUMN new_saveTaskStatus ENUM('not created', 'not yet scheduled', 'pending', 'running', 'scheduled', 'succeeded', 'failed')
                            DEFAULT 'not created' AFTER saveRequestStatus");

        DB::statement("UPDATE software_heritage_requests
                            SET new_saveTaskStatus = saveTaskStatus");

        DB::statement("ALTER TABLE software_heritage_requests
                            DROP COLUMN saveTaskStatus");

        DB::statement("ALTER TABLE software_heritage_requests
                            RENAME COLUMN new_saveTaskStatus TO saveTaskStatus");
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
